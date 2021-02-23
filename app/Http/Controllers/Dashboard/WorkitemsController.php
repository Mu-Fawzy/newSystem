<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkitemRequest;
use App\Models\Workitem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class WorkitemsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:'.__('content.work-list').'|'.__('content.work-create').'|'.__('content.work-update').'|'.__('content.work-delete').'', ['only' => ['index']]);
        $this->middleware('permission:'.__('content.work-create').'', ['only' => ['create','store']]);
        $this->middleware('permission:'.__('content.work-update').'', ['only' => ['edit','update']]);
        $this->middleware('permission:'.__('content.work-delete').'', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $searchText = trans_choice('content.work item',2);
        $workitems = Workitem::with('user')
        ->when($request->search, function($q) use($request){
            return $q->where(function ($query) use($request){
                foreach(LaravelLocalization::getSupportedLanguagesKeys() as $localeCode) {
                    $query->orWhere("name->$localeCode", 'LIKE', '%'.$request->search.'%');
                }
            });
        })->when($request->year, function($q) use ($request){
            $q->whereYear('created_at', $request->year);
        })->orderBy('id','DESC')->paginate(5);

        $years = DB::table('workitems')
        ->select(DB::raw('YEAR(created_at) as year'))
        ->orderBy('year', 'asc')
        ->groupBy('year')
        ->get();

        return view('dashboard.worksitems.workitems', compact('workitems','searchText','years'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $searchText = trans_choice('content.work item',2);
        return view('dashboard.worksitems.create', compact('searchText'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WorkitemRequest $request)
    {
        $data = array();
        foreach(LaravelLocalization::getSupportedLanguagesKeys() as $localeCode){
            $data['name'][$localeCode] = $request["name.".$localeCode];
        }

        $data['user_id'] = auth()->id();

        $workitem = Workitem::create($data);

        if($workitem){
            $request->session()->flash('success', __('content.created successfully',['attr'=>$workitem->name,'name'=>trans_choice('content.work item',1)]));
            return redirect()->route('workitems.index');
        }
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Workitem  $workitem
     * @return \Illuminate\Http\Response
     */
    public function edit(Workitem $workitem)
    {
        $searchText = trans_choice('content.work item',2);
        return view('dashboard.worksitems.edit', compact('workitem','searchText'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Workitem  $workitems
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Workitem $workitem)
    {
        $this->validate($request,[
            'name.*' => "required|string|unique_translation:workitems,name,{$workitem->id}",
        ]);
        $data = [];
        foreach(LaravelLocalization::getSupportedLanguagesKeys() as $localeCode){
            $data['name'][$localeCode] = $request["name.".$localeCode];
        }

        $data['user_id'] = auth()->id();

        $workitem->update($data);

        if($workitem){
            $request->session()->flash('success', __('content.updated successfully',['attr'=>$workitem->name,'name'=>trans_choice('content.work item',1)]));
            return redirect()->route('workitems.index');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Workitem  $workitem
     * @return \Illuminate\Http\Response
     */
    public function destroy(Workitem $workitem)
    {
        $workitem->delete();
        session()->flash('success', __('content.deleted successfully',['attr'=>$workitem->name,'name'=>trans_choice('content.work item',1)]));
        return redirect()->route('workitems.index');
    }
}
