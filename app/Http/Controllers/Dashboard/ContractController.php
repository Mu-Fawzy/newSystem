<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContractRequest;
use App\Http\Requests\UpdateFilesRequest;
use App\Models\Attachment;
use App\Models\Contract;
use App\Models\Subcontractor;
use App\Models\Workitem;
use App\Models\Worksite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ContractController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    function __construct()
    {
        $this->middleware('permission:'.__('content.contract-create').'|'.__('content.contract-update').'|'.__('content.contract-delete').'|'.__('content.contract-archive').'|'.__('content.contract-restore').'|'.__('content.contract-move-to-archive').'', ['only' => ['index']]);
        $this->middleware('permission:'.__('content.contract-archive').'', ['only' => ['archive']]);
        $this->middleware('permission:'.__('content.contract-create').'', ['only' => ['create','store']]);
        $this->middleware('permission:'.__('content.contract-restore').'', ['only' => ['restore']]);
        $this->middleware('permission:'.__('content.contract-update').'', ['only' => ['edit','update']]);
        $this->middleware('permission:'.__('content.contract-move-to-archive').'', ['only' => ['destroy']]);
        $this->middleware('permission:'.__('content.contract-delete').'', ['only' => ['deleteForEver']]);
    }

    public function index(Request $request)
    {
        $searchText = trans_choice('content.contract',2);
        $contracts = Contract::with('user','contract','attachinvoices','subcontactor','worksite','workitem')
        ->when($request->search, function($q) use($request){
            return $q->where('contract_number', 'LIKE', '%'.$request->search.'%')
            ->orWhere(function ($qr) use ($request) {
                foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
                    $qr->orWhereHas('subcontactor', function ($qs) use ($request,$localeCode) {
                        return $qs->where("name->$localeCode", 'LIKE', '%'. $request->search .'%');
                    })->orWhereHas('worksite', function ($qwi) use ($request,$localeCode) {
                        return $qwi->where("name->$localeCode", 'LIKE', '%'. $request->search .'%');
                    })->orWhereHas('workitem', function ($qws) use ($request,$localeCode) {
                        return $qws->where("name->$localeCode", 'LIKE', '%'. $request->search .'%');
                    });
                }
            });
        })->when($request->year, function($qu) use ($request){
            return $qu->whereYear('created_at', $request->year);
        })->orderBy('id', 'DESC')->paginate(15);
        $countDeletedContracts = DB::table('contracts')->where('deleted_at', '<>', null)->get();

        $years = DB::table('contracts')
        ->whereNull('deleted_at')
        ->select(DB::raw('YEAR(created_at) as year'))
        ->orderBy('year', 'asc')
        ->groupBy('year')
        ->get();

        $archive = false;

        return view('dashboard.contract.contracts', compact('contracts','countDeletedContracts','archive','years','searchText'));
    }    
    
    public function archive()
    {
        $contracts = Contract::onlyTrashed()->with('user','contract','attachinvoices','subcontactor','worksite','workitem')->orderBy('id', 'DESC')->paginate(15);

        $archive = true;

        return view('dashboard.contract.contracts', compact('contracts','archive'));
    }

    public function create()
    {
        $worksites = Worksite::select('id', 'name')->get();
        $workitems= Workitem::select('id', 'name')->get();
        $subcontractors = Subcontractor::select('id', 'name')->where('status','1')->get();
        return view('dashboard.contract.create', compact('worksites','workitems','subcontractors'));
    }

    public function store(ContractRequest $request)
    {
        $data = $request->except(['_token']);
        $data['user_id'] = auth()->id();

        $contract = Contract::create($data);
        
        if($request->hasFile('contract')){
            $photo = $request->file('contract');
            $path  = $photo->store('/contracts', 'public_upload');

            $attachment = new Attachment();
            $attachment->name = basename($path);
            $attachment->type = 'contract';
            $attachment->origin_name = $photo->getClientOriginalName();
            $attachment->extension = $photo->getClientOriginalExtension();

            $contract->contract()->save($attachment);
        }

        if($request->hasFile('invoices')){
            foreach ($request->file('invoices') as $photo) {
                $path  = $photo->store('/invoices', 'public_upload');

                $attachment = new Attachment();
                $attachment->name = basename($path);
                $attachment->type = 'invoices';
                $attachment->origin_name = $photo->getClientOriginalName();
                $attachment->extension = $photo->getClientOriginalExtension();

                $contract->attachinvoices()->save($attachment);
            }
        }

        $contract->subcontactor->worksites()->syncWithoutDetaching([$contract->worksite_id]); // add worksite to subcontractor
        $contract->subcontactor->workitems()->syncWithoutDetaching([$contract->workitem_id]); // add workitem to subcontractor

        if($contract){
            $request->session()->flash('success', __('content.created successfully',['attr'=>$contract->contract_number,'name'=>trans_choice('content.contract',1)]));
            return redirect()->route('contracts.index');
        }
        return redirect()->back();
    }

    public function show(Contract $contract)
    {
        //
    }

    public function edit(Contract $contract)
    {
        $worksites = Worksite::select('id', 'name')->get();
        $workitems= Workitem::select('id', 'name')->get();
        $contract = Contract::with('subcontactor','worksite','workitem')->find($contract->id);
        
        return view('dashboard.contract.edit', compact('worksites','workitems','contract'));
    }

    public function update(ContractRequest $request, Contract $contract)
    {
        // return $request;
        $data = $request->except(['_token','_method']);
        $data['user_id'] = auth()->id();

        $oldsubcontractor = Subcontractor::find($contract->subcontractor_id);
        $oldworksites = Worksite::find($contract->worksite_id);
        $oldworkitems = Workitem::find($contract->workitem_id);
        //return $oldworkitems;

        $collection = collect($oldworksites->contracts);
        $ubcontractorfromwebsite =  $collection->whereIn('subcontractor_id', [$oldsubcontractor->id]);
        if ($ubcontractorfromwebsite->count() == 1) {
            $oldsubcontractor->worksites()->detach($contract->worksite_id); 
        }

        $collection = collect($oldworkitems->contracts);
        $ubcontractorfromwebsite =  $collection->whereIn('subcontractor_id', [$oldsubcontractor->id]);
        if ($ubcontractorfromwebsite->count() == 1) {
            $oldsubcontractor->workitems()->detach($contract->workitem_id); 
        }
        
        $contract->update($data);
        // add worksite to subcontractor
        $contract->subcontactor->worksites()->syncWithoutDetaching([$contract->worksite_id]);
        $contract->subcontactor->workitems()->syncWithoutDetaching([$contract->workitem_id]);

        if($contract){
            $request->session()->flash('success', __('content.updated successfully',['attr'=>$contract->contract_number,'name'=>trans_choice('content.contract',1)]));
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function destroy($id)
    {
        $contract = Contract::withTrashed()->findOrFail($id);
        $subcontractor = Subcontractor::find($contract->subcontractor_id);
        $worksites = Worksite::find($contract->worksite_id);
        $workitems = Workitem::find($contract->workitem_id);

        $collection = collect($worksites->contracts);
        $ubcontractorfromwebsite =  $collection->whereIn('subcontractor_id', [$subcontractor->id]);
        if ($ubcontractorfromwebsite->count() == 1) {
            $subcontractor->worksites()->detach($contract->worksite_id); 
        }

        $collection = collect($workitems->contracts);
        $ubcontractorfromwebsite =  $collection->whereIn('subcontractor_id', [$subcontractor->id]);
        if ($ubcontractorfromwebsite->count() == 1) {
            $subcontractor->workitems()->detach($contract->workitem_id); 
        }
        
        $contract->delete();

        if($contract){
            session()->flash('success', __('content.archived successfully',['attr'=>$contract->contract_number,'name'=>trans_choice('content.contract',1)]));
            
            return redirect()->route('contracts.index');
        }
        return redirect()->back();
    }

    public function deleteForEver($id)
    {
        $contract = Contract::withTrashed()->findOrFail($id);
        $subcontractor = Subcontractor::find($contract->subcontractor_id);
        $worksites = Worksite::find($contract->worksite_id);
        $workitems = Workitem::find($contract->workitem_id);

        if (!$contract->trashed()) {
            $collection = collect($worksites->contracts);
            $ubcontractorfromwebsite =  $collection->whereIn('subcontractor_id', [$subcontractor->id]);
            if ($ubcontractorfromwebsite->count() == 1) {
                $subcontractor->worksites()->detach($contract->worksite_id); 
            }

            $collection = collect($workitems->contracts);
            $ubcontractorfromwebsite =  $collection->whereIn('subcontractor_id', [$subcontractor->id]);
            if ($ubcontractorfromwebsite->count() == 1) {
                $subcontractor->workitems()->detach($contract->workitem_id); 
            }
        }
        
        if ($contract->contract != null) {
            if(is_file('uploads/contracts/'.$contract->contract->name)){
                Storage::disk('public_upload')->delete('contracts/'.$contract->contract->name);
            }
        }
        
        $contract->contract()->delete();

        foreach($contract->attachinvoices as $attach){
            if(is_file('uploads/invoices/'.$attach->name)){
                Storage::disk('public_upload')->delete('invoices/'.$attach->name);
            }
            $contract->attachinvoices()->delete();
        }

        $contract->forceDelete();

        if($contract){
            session()->flash('success', __('content.deleted successfully',['attr'=>$contract->contract_number,'name'=>trans_choice('content.contract',1)]));
            return redirect()->route('contracts.index');
        }
        return redirect()->back();
    }

    public function updateContract(UpdateFilesRequest $request, Contract $contract)
    {
        if($request->hasFile('contract')) {
            if($contract->contract != null)
            {
                Storage::disk('public_upload')->delete('contracts/'.$contract->contract->name);
                $contract->contract()->delete();
            }

            $photo = $request->file('contract');
            $path  = $photo->store('/contracts', 'public_upload');

            $attachment = new Attachment();
            $attachment->name = basename($path);
            $attachment->type = 'contract';
            $attachment->origin_name = $photo->getClientOriginalName();
            $attachment->extension = $photo->getClientOriginalExtension();

            $contract->contract()->save($attachment);

            $request->session()->flash('success', __('content.updated successfully',['attr'=>$contract->contract_number,'name'=>trans_choice('content.contract',1)]));
            return redirect()->back();
        }elseif($request->hasFile('invoices')){
            foreach ($request->file('invoices') as $photo) {
                $path  = $photo->store('/invoices', 'public_upload');

                $attachment = new Attachment();
                $attachment->name = basename($path);
                $attachment->type = 'invoices';
                $attachment->origin_name = $photo->getClientOriginalName();
                $attachment->extension = $photo->getClientOriginalExtension();

                $contract->attachinvoices()->save($attachment);
            }
            $request->session()->flash('success', 
        );
            
            return redirect()->route('contracts.index');
        }
        return redirect()->back();
        
    }

    public function contractdeletefile(Contract $contract,$path, $file_name)
    {
        if ($path == "invoices") {
            $contract->attachinvoices->each(function($attach) use($file_name, $path){
                if($attach->name == $file_name){
                    Storage::disk('public_upload')->delete($path.'/'.$attach->name);
                    $attach->delete();
                }
            });
        } elseif($path == "contracts") {
            if($contract->contract->name == $file_name){
                Storage::disk('public_upload')->delete($path.'/'.$contract->contract->name);
                $contract->contract->delete();
            }
        }
        
        session()->flash('success', __('content.deleted successfully',['attr'=>'','name'=>trans_choice('content.file',1)]));
        return redirect()->back();
    }


    public function restore($id)
    {
        $contract = Contract::withTrashed()->findOrFail($id);

        if ($contract) {
            $contract->restore();

            $contract->subcontactor->worksites()->syncWithoutDetaching([$contract->worksite_id]);
            $contract->subcontactor->workitems()->syncWithoutDetaching([$contract->workitem_id]);


            session()->flash('success', __('content.restored successfully',['attr'=>$contract->contract_number,'name'=>trans_choice('content.contract',1)]));
            return redirect()->route('contracts.index');
        }
        return redirect()->back();
    }
}