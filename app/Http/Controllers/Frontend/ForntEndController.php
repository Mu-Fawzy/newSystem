<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ForntEndController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    function __construct()
    {
        // $this->middleware('permission:contract-create|contract-update|contract-delete|contract-archive|contract-restore|contract-move-to-archive', ['only' => ['index']]);
        $this->middleware('permission:'.__('content.contract-archive').'', ['only' => ['archive']]);
        $this->middleware('permission:'.__('content.contract-restore').'', ['only' => ['restore']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $contracts = Contract::with('contract','subcontactor','worksite','workitem')
        ->when($request->search, function($q) use($request){
            $q->where('contract_number', 'LIKE', '%' .$request->search. '%')
            ->orWhereHas('subcontactor', function($q) use ($request) {
                return $q->where('name', 'LIKE', '%' . $request->search . '%');
            })
            ->orWhereHas('worksite', function($q) use ($request) {
                return $q->where('name', 'LIKE', '%' . $request->search . '%');
            })->orWhereHas('workitem', function($q) use ($request) {
                return $q->where('name', 'LIKE', '%'. $request->search . '%');
            })->orWhereHas('contract', function($q) use ($request) {
                return $q->where('origin_name', 'LIKE', '%'. $request->search . '%');
            })->orWhereHas('attachinvoices', function($q) use ($request) {
                return $q->where('origin_name', 'LIKE', '%'. $request->search . '%');
            });
        })->paginate(10);

        $countDeletedContracts = DB::table('contracts')->selectRaw('deleted_at')->where('deleted_at','<>',null)->get();
        $archive = false;

        return view('frontend.index', compact('contracts','archive','countDeletedContracts'));
    }

    public function archive()
    {
        $contracts = Contract::onlyTrashed()->with('contract','subcontactor','worksite','workitem')->paginate(10);
        $archive = true;
        return view('frontend.index', compact('contracts','archive'));
    }

    public function restore($id)
    {
        $contract = Contract::withTrashed()->find($id);

        if ($contract) {
            $contract->restore();

            $contract->subcontactor->worksites()->syncWithoutDetaching([$contract->worksite_id]);
            $contract->subcontactor->workitems()->syncWithoutDetaching([$contract->workitem_id]);

            session()->flash('success', 'Contract Restored Successfully!');
            return redirect()->route('home.page');
        }
        return redirect()->back();
    }
}
