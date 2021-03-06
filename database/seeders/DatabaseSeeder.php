<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //create all Permission
        $permissions = config('customPermission.permissions');
        foreach ($permissions as $permission) {
            Permission::create($this->createPermission($permission));
        }

        //create Role 'Owner' and give all permissions
        $role = Role::create($this->createRole());
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);

        //create Super Admin with Role 'Owner'
        $user = User::create([
            'name' => 'mrrmohamed',
            'email' => 'mrrmohamedfawzy@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('00000000'),
            'status' => true,
            'remember_token' => Str::random(10),
        ]);
        $user->assignRole([$role->id]);

        // \App\Models\User::factory(1)->create();
        // \App\Models\Worksite::factory(150)->create();
        // \App\Models\Workitem::factory(120)->create();
        // \App\Models\Subcontractor::factory(25)->create();
        // \App\Models\Contract::factory(1000)->create();
    }

    public function createRole(){
        $arrayrole = array();
        foreach(LaravelLocalization::getSupportedLanguagesKeys() as $localeCode){
            $arrayrole['name'][$localeCode] = Lang::get('content.owner',[],$localeCode);
        }
        return $arrayrole;
    }

    public function createPermission($perm){
        $arraypermission = array();
        foreach(LaravelLocalization::getSupportedLanguagesKeys() as $localeCode){
            $arraypermission['name'][$localeCode] = Lang::get('content.'.$perm,[],$localeCode);
        }
        return $arraypermission;
    }
    
}
