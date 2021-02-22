<?php
namespace App\Http\Controllers\Dashboard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Models\Role;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:'.__('content.role-list').'|'.__('content.role-show').'|'.__('content.role-create').'|'.__('content.role-edit').'|'.__('content.role-delete').'', ['only' => ['index']]);
        $this->middleware('permission:'. __('content.role-create'), ['only' => ['create','store']]);
        $this->middleware('permission:'. __('content.role-show'), ['only' => ['show']]);
        $this->middleware('permission:'. __('content.role-edit'), ['only' => ['edit','update']]);
        $this->middleware('permission:'. __('content.role-delete'), ['only' => ['destroy']]);
    }
    
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        $searchText = trans_choice('content.role',2);
        $user = Auth::user();

        if ($user->hasRole( __('content.owner') )) {
            $roles = Role::when($request->search ,function($q) use ($request) {
                return $q->orWhere(function ($qr) use ($request) {
                    foreach(LaravelLocalization::getSupportedLanguagesKeys() as $localeCode) {
                        $qr->orWhere("name->$localeCode", 'LIKE', '%'. $request->search . '%');
                    };
                });
            })->orderBy('id','DESC')->paginate(10);
        }else {
            $roles = Role::where(function ($qr) use ($request) {
                foreach(LaravelLocalization::getSupportedLanguagesKeys() as $localeCode) {
                    $qr->where("name->$localeCode",'NOT LIKE', Lang::get('content.owner',[],$localeCode));
                };
            })->when($request->search ,function ($query) use ($request) {
                return $query->where(function ($qr) use ($request) {
                    foreach(LaravelLocalization::getSupportedLanguagesKeys() as $localeCode) {
                        $qr->orWhere("name->$localeCode", 'LIKE', '%'. $request->search . '%')
                        ->where("name->$localeCode",'NOT LIKE', Lang::get('content.owner',[],$localeCode));
                    };
                });
            })->orderBy('id','DESC')->paginate(5); 
        }

        return view('dashboard.roles.index',compact('roles','searchText'));
    }
    
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $searchText = __('content.roles');
        $permission = Permission::get();
        return view('dashboard.roles.create',compact('permission','searchText'));
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(RoleRequest $request)
    {
        $data = [];
        foreach(LaravelLocalization::getSupportedLanguagesKeys() as $localeCode){
            $data['name'][$localeCode] = $request["name_".$localeCode];
        }

        $role = Role::create($data);

        $role->syncPermissions($request->input('permissions'));
        return redirect()->route('roles.index')
        ->with('success', __('content.created successfully',['name'=>trans_choice('content.role',1),'attr'=>$role->name])); 
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function show($id)
    {
        $searchText = trans_choice('content.role',2);
        $role = Role::find($id);
        $rolePermissions = $role->permissions()->get();
        return view('dashboard.roles.show',compact('role','rolePermissions','searchText'));
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $searchText = trans_choice('content.role',2);
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = $role->permissions()->pluck('permission_id','permission_id')->all();
        
        return view('dashboard.roles.edit',compact('role','permission','rolePermissions','searchText'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(RoleRequest $request, Role $role)
    {
        $data = [];
        foreach(LaravelLocalization::getSupportedLanguagesKeys() as $localeCode){
            $data['name'][$localeCode] = $request["name_".$localeCode];
        }

        $role->update($data);

        $role->syncPermissions($request->input('permissions'));
        return redirect()->route('roles.index')
        ->with('success', __('content.updated successfully',['name'=>trans_choice('content.role',1),'attr'=>$role->name]));
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        if($role->users->count() > 0)
        {
            foreach($role->users as $user)
            {
                if($user->roles->count() <= 1) {
                    $user->status = 0;
                }
                $user->save();
            }
        }

        $role->delete();
        return redirect()->route('roles.index')
        ->with('success', __('content.deleted successfully',['name'=>trans_choice('content.role',1),'attr'=>$role->name]));
    }
}