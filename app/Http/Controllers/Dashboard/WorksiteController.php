<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorksiteRequest;
use App\Models\Worksite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class WorksiteController extends Controller
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
        $searchText = trans_choice('content.work site',2);
        $worksites = Worksite::with('user')
        ->when($request->search, function($q) use($request){
            return $q->where(function ($query) use($request){
                foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
                    $query->orWhere('name->'.$localeCode, 'LIKE', '%'.$request->search.'%')
                    ->orWhere('owner->'.$localeCode, 'LIKE', '%'. $request->search . '%');
                }
            });
        })->when($request->year, function($q) use ($request){
            $q->whereYear('created_at', $request->year);
        })->orderBy('id','DESC')->paginate(5);

        $years = DB::table('worksites')
        ->select(DB::raw('YEAR(created_at) as year'))
        ->orderBy('year', 'asc')
        ->groupBy('year')
        ->get();

        return view('dashboard.worksites.worksites', compact('worksites','years','searchText'));
    }

    public function create()
    {
        $searchText = trans_choice('content.work site',2);
        return view('dashboard.worksites.create', compact('searchText'));
    }

    public function store(WorksiteRequest $request)
    {
        $data = [];
        foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties){
            $data['name'][$localeCode] = $request["name_".$localeCode];
            $data['owner'][$localeCode] = $request["owner_".$localeCode];
        }

        $data['user_id'] = auth()->id();

        $worksites = Worksite::create($data);

        if($worksites){
            $request->session()->flash('success', __('content.created successfully',['attr'=>$worksites->name,'name'=>trans_choice('content.work site',1)]));
            return redirect()->route('worksites.index');

            
        }
        return redirect()->back();
    }

    public function edit(Worksite $worksite)
    {
        $searchText = trans_choice('content.work site',2);
        return view('dashboard.worksites.edit', compact('worksite','searchText'));
    }

    public function update(WorksiteRequest $request, Worksite $worksite)
    {

        $data = [];
        foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties){
            $data['name'][$localeCode] = $request["name_".$localeCode];
            $data['owner'][$localeCode] = $request["owner_".$localeCode];
        }

        $data['user_id'] = auth()->id();

        $worksite->update($data);

        if($worksite){
            $request->session()->flash('success', __('content.updated successfully',['attr'=>$worksite->name,'name'=>trans_choice('content.work site',1)]));
            return redirect()->route('worksites.index');
        }
        return redirect()->back();
    }

    public function destroy(Worksite $worksite)
    {
        $worksite->delete();
        session()->flash('success', __('content.deleted successfully',['attr'=>$worksite->name,'name'=>trans_choice('content.work site',1)]));
        return redirect()->route('worksites.index');
    }
}
