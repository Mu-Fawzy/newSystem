<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class UserController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    function __construct()
    {
        $this->middleware('permission:'.__('content.user-list').'|'.__('content.user-show').'|'.__('content.user-create').'|'.__('content.user-edit').'|'.__('content.user-delete').'', ['only' => ['index']]);
        $this->middleware('permission:'.__('content.user-create').'', ['only' => ['create','store']]);
        $this->middleware('permission:'.__('content.user-show').'', ['only' => ['show']]);
        $this->middleware('permission:'.__('content.user-edit').'', ['only' => ['edit','update']]);
        $this->middleware('permission:'.__('content.user-delete').'', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchText = trans_choice('content.user',2);
        $user = Auth::user();
        
        if ($user->hasRole( __('content.owner') )) {
            $users = User::with('roles')->when($request->search ,function ($query) use ($request) {
                return $query->where('name','like','%'.$request->search.'%')
                ->orWhere('email','like','%'.$request->search.'%')
                ->orWhere(function ($qr) use ($request) {
                    foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
                        $qr->orWhereHas('roles', function ($qs) use ($request,$localeCode) {
                            return $qs->where("name->$localeCode", 'LIKE', '%'. $request->search . '%');
                        });
                    }
                });
            })->orderBy('id','DESC')->paginate(10);
        }else {
            $users = User::with('roles')->whereHas('roles', function ($q) {
                foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
                    return $q->where("name->$localeCode",'NOT LIKE', Lang::get('content.owner',[],$localeCode));
                }

            })->when($request->search ,function ($query) use ($request) {
                return $query->where('name','like','%'.$request->search.'%')
                ->orWhere('email','like','%'.$request->search.'%')
                ->whereHas('roles', function ($qnr) {
                    foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
                        return $qnr->where("name->$localeCode",'NOT LIKE', Lang::get('content.owner',[],$localeCode));
                    }
                })->orWhere(function ($qr) use ($request) {
                    foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
                        $qr->orWhereHas('roles', function ($qs) use ($request,$localeCode) {
                            return $qs->where("name->$localeCode", 'LIKE', '%'. $request->search . '%')
                            ->where("name->$localeCode",'NOT LIKE', Lang::get('content.owner',[],$localeCode));
                        });
                    }
                });
            })->orderBy('id','DESC')->paginate(10);
        }
        
        return view('dashboard.users.index',compact('searchText','users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $searchText = trans_choice('content.user',2);
        $user = Auth::user();
        if ($user->hasRole( __('content.owner') )) {
            $roles = Role::select('id','name')->get();
        }else{
            foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
                $roles = Role::where("name->$localeCode",'NOT LIKE',Lang::get('content.owner',[],$localeCode))->select('id','name')->get();
            }
        }
        
        return view('dashboard.users.create',compact('roles','searchText'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $inputs = $request->except('roles');

        $inputs['password'] = Hash::make($inputs['password']);
        $user = User::create($inputs);
        
        $user->assignRole($request->input('roles'));
        return redirect()->route('users.index')
        ->with('success', __('content.created successfully',['name'=>trans_choice('content.user',1),'attr'=>$user->name]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $searchText = trans_choice('content.user',2);
        $user = User::find($id);
        return view('dashboard.users.show',compact('user','searchText'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $searchText = trans_choice('content.user',2);
        $user = User::find($id);
        $auth = Auth::user();

        if ($auth->hasRole( __('content.owner') )) {
            $roles = Role::select('id','name')->get();
        }else{
            foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
                $roles = Role::where("name->$localeCode",'NOT LIKE',Lang::get('content.owner',[],$localeCode))->select('id','name')->get();
            }
        }
        
        $userRole = $user->roles->pluck('name','name')->all();

        return view('dashboard.users.edit',compact('user','roles','userRole','searchText'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,['password']);
        }
        $user = User::find($id);
        $user->update($input);
        
        $user->syncRoles($request->input('roles'));

        return redirect()->route('users.index')
        ->with('success', __('content.updated successfully',['name'=>trans_choice('content.user',1),'attr'=>$user->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')
        ->with('success', __('content.deleted successfully',['name'=>trans_choice('content.user',1),'attr'=>$user->name]));
    }
}
