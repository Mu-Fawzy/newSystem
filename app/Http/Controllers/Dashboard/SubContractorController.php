<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Subcontractor;
use App\Http\Controllers\Controller;
use App\Http\Requests\UploadFileRequest;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Requests\SubcontractorRequest;

class SubContractorController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:'.__('content.subcontractor-list').'|'.__('content.subcontractor-trashed').'|'.__('content.subcontractor-restore').'|'.__('content.subcontractor-create').'|'.__('content.subcontractor-edit').'|'.__('content.subcontractor-delete').'|'.__('content.subcontractor-deletefile').'', ['only' => ['index','show']]);
        $this->middleware('permission:'.__('content.subcontractor-create').'', ['only' => ['create','store']]);
        $this->middleware('permission:'.__('content.subcontractor-edit').'', ['only' => ['show','update']]);
        $this->middleware('permission:'.__('content.subcontractor-delete').'', ['only' => ['destroy']]);
        $this->middleware('permission:'.__('content.subcontractor-trashed').'', ['only' => ['trashed']]);
        $this->middleware('permission:'.__('content.subcontractor-restore').'', ['only' => ['restore']]);
        $this->middleware('permission:'.__('content.subcontractor-deletefile').'', ['only' => ['deletefile']]);
    }

    public function openfile($folder_name,$attach_name)
    {
        $path = Storage::disk('public_upload')->getDriver()->getAdapter()->applyPathPrefix($folder_name.'/'.$attach_name);
        return response()->file($path);
    }

    public function downloadfile($folder_name,$attach_name)
    {
        $path = Storage::disk('public_upload')->getDriver()->getAdapter()->applyPathPrefix($folder_name.'/'.$attach_name);
        return response()->download($path);
    }

    public function index(Request $request)
    {
        $searchText = trans_choice('content.subcontractor',2);
        $trash = false;

        $subcontractors = Subcontractor::with('user')
        ->when($request->search ,function ($query) use ($request) {
            return $query->where('phone','LIKE', '%'.$request->search.'%')
            ->orWhere(function ($q) use ($request) {
                foreach(LaravelLocalization::getSupportedLanguagesKeys() as $localeCode) {
                    $q->orWhere(function ($qr) use ($request,$localeCode) {
                        return $qr->where("name->$localeCode", 'LIKE', '%'. $request->search . '%')
                                ->orWhere("address->$localeCode",'LIKE', '%'.$request->search.'%');
                    });
                }
            });
        })->when($request->year, function($q) use ($request){
            $q->whereYear('created_at', $request->year);
        })
        ->orderBy('id','DESC')->paginate(5);

        $countDeletedSubContracts = DB::table('subcontractors')->where('deleted_at', '<>', null)->get();

        $years = DB::table('subcontractors')
        ->select(DB::raw('YEAR(created_at) as year'))
        ->orderBy('year', 'asc')
        ->groupBy('year')
        ->get();

        return view('dashboard.subcontractor.subcontractors', compact('subcontractors','years','searchText','countDeletedSubContracts','trash'));
    }

    public function getWorksites(Subcontractor $subcontractor)
    {
        $worksites = $subcontractor->worksites()->paginate(5);
        $subcontractorWorksites = $worksites->total();
        return view('dashboard.worksites.worksites', compact('worksites','subcontractor','subcontractorWorksites'));
    }

    public function getWorkitems(Subcontractor $subcontractor)
    {
        $workitems = $subcontractor->workitems()->paginate(5);
        $subcontractorWorkitems = $workitems->total();
        return view('dashboard.worksitems.workitems', compact('workitems','subcontractor','subcontractorWorkitems'));
    }

    public function trashed()
    {
        $searchText = trans_choice('content.subcontractor',2);
        $trash = true;

        $subcontractors = Subcontractor::with('user')->latest()->onlyTrashed()->paginate(10);

        $years = DB::table('subcontractors')
        ->select(DB::raw('YEAR(created_at) as year'))
        ->orderBy('year', 'asc')
        ->groupBy('year')
        ->get();

        return view('dashboard.subcontractor.subcontractors', compact('subcontractors','searchText','years','trash'));
    }

    public function create()
    {
        $years = DB::table('subcontractors')
        ->select(DB::raw('YEAR(created_at) as year'))
        ->orderBy('year', 'asc')
        ->groupBy('year')
        ->get();

        return view('dashboard.subcontractor.create', compact('years'));
    }

    public function store(SubcontractorRequest $request)
    {
        $data = [];
        foreach(LaravelLocalization::getSupportedLanguagesKeys() as $localeCode){
            $data['name'][$localeCode] = $request["name_".$localeCode];
            $data['address'][$localeCode] = $request["address_".$localeCode];
            $data['bio'][$localeCode] = $request["bio_".$localeCode];
        }
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['status'] = $request->status;
        $data['user_id'] = auth()->id();

        $subcontractors = Subcontractor::create($data);

        if($request->hasFile('logo')){
            $photo = $request->file('logo');
            $path  = $photo->store('/logos', 'public_upload');

            $attachment = new Attachment();
            $attachment->name = basename($path);
            $attachment->type = 'logo';
            $attachment->origin_name = $photo->getClientOriginalName();
            $attachment->extension = $photo->getClientOriginalExtension();

            $subcontractors->attachlogo()->save($attachment);
        }

        if($request->hasFile('attachment_name')){
            foreach ($request->file('attachment_name') as $photo) {
                $path  = $photo->store('/attachs', 'public_upload');

                $attachment = new Attachment();
                $attachment->name = basename($path);
                $attachment->type = 'attachs';
                $attachment->origin_name = $photo->getClientOriginalName();
                $attachment->extension = $photo->getClientOriginalExtension();

                $subcontractors->attachs()->save($attachment);
            }
        }

        if($subcontractors){
            $request->session()->flash('success', __('content.created successfully',['name'=>trans_choice('content.subcontractor',1),'attr'=>$subcontractors->name])); 
            return redirect()->route('subcontractors.index');
        }
        return redirect()->back();
    }

    public function show(Subcontractor $subcontractor)
    {
        $searchText = trans_choice('content.subcontractor',2);
        return view('dashboard.subcontractor.show', compact('subcontractor','searchText'));
    }

    public function edit(Subcontractor $subcontractor)
    {
        
    }

    public function update(SubcontractorRequest $request, SubContractor $subcontractor)
    {
        $data = [];
        foreach(LaravelLocalization::getSupportedLanguagesKeys() as $localeCode){
            $data['name'][$localeCode] = $request["name_".$localeCode];
            $data['address'][$localeCode] = $request["address_".$localeCode];
            $data['bio'][$localeCode] = $request["bio_".$localeCode];
        }
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;


        $subcontractor->update($data);

        if($subcontractor){
            $request->session()->flash('success', __('content.updated successfully',['name'=>trans_choice('content.subcontractor',1),'attr'=>$subcontractor->name]));
            

            return redirect()->back();
        }
        return redirect()->back();

    }

    public function updateStatus(Request $request, SubContractor $subcontractor)
    {
        $subcontractor->update([
            'status' => $request->status,
        ]);

        if($subcontractor){
            $request->session()->flash('success', __('content.updated successfully',['name'=>trans_choice('content.subcontractor',1),'attr'=>$subcontractor->name]));
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function updateAttachs(UploadFileRequest $request, SubContractor $subcontractor)
    {
        if($request->hasFile('attachment_name')){
            foreach ($request->file('attachment_name') as $photo) {
                $path  = $photo->store('/attachs', 'public_upload');

                $attachment = new Attachment();
                $attachment->name = basename($path);
                $attachment->type = 'attachs';
                $attachment->origin_name = $photo->getClientOriginalName();
                $attachment->extension = $photo->getClientOriginalExtension();

                $subcontractor->attachs()->save($attachment);
            }
            $request->session()->flash('success', __('content.updated successfully',['attr'=>trans_choice('content.attachment',2),'name'=>'']));
            return redirect()->back();

        }elseif($request->hasFile('logo')) {

            if($subcontractor->attachlogo != null)
            {
                //remove logo from database 
                Storage::disk('public_upload')->delete('logos/'.$subcontractor->attachlogo->name);
                $subcontractor->attachlogo()->delete();
            }
            
            $photo = $request->file('logo');
            $path  = $photo->store('/logos', 'public_upload');

            $attachment = new Attachment();
            $attachment->name = basename($path);
            $attachment->type = 'logo';
            $attachment->origin_name = $photo->getClientOriginalName();
            $attachment->extension = $photo->getClientOriginalExtension();

            $subcontractor->attachlogo()->save($attachment);

            $request->session()->flash('success', __('content.updated successfully',['name'=>'', 'attr'=>__('content.logo')]));
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function destroy($id)
    {
        $this_subcontractor = Subcontractor::withTrashed()->findOrFail($id);

        if($this_subcontractor->trashed()){
            if (!empty($this_subcontractor->attachlogo->name)) {
                //remove logo from database 
                Storage::disk('public_upload')->delete('logos/'.$this_subcontractor->attachlogo->name);
                $this_subcontractor->attachlogo()->delete();
            }
            if (!empty($this_subcontractor->attachs)) {
                //remove attachs from database 
                $this_subcontractor->attachs->each(function($attach) {
                    Storage::disk('public_upload')->delete('attachs/'.$attach->name);
                    $attach->delete();
                });
            }

            $this_subcontractor->forceDelete();
            session()->flash('success', __('content.deleted successfully',['attr'=> $this_subcontractor->name, 'name'=> trans_choice('content.subcontractor',1)]));
            return redirect()->route('subcontractors.index');
        }else{
            $this_subcontractor->delete();

            session()->flash('success', __('content.trashed successfully',['attr'=> $this_subcontractor->name, 'name'=> trans_choice('content.subcontractor',1)]));
            return redirect()->route('subcontractors.index');
        }
    }

    public function deletefile(SubContractor $subcontractor, $file_name)
    {
        $subcontractor->attachs->each(function($attach) use($file_name){
            if($attach->name == $file_name){
                Storage::disk('public_upload')->delete('attachs/'.$attach->name);
                $attach->delete();
            }
        });
        session()->flash('success', __('content.file deleted successfully!'));
        return redirect()->back();
    }

    public function restore($id)
    {
        $this_subcontractor = Subcontractor::onlyTrashed()->findOrFail($id);
        $this_subcontractor->restore();

        session()->flash('success', __('content.restored successfully',['attr'=> $this_subcontractor->name, 'name'=> trans_choice('content.subcontractor',1)]));
        return redirect()->route('subcontractors.index');
    }
}
