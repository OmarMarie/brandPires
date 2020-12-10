<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
    use Spatie\Permission\Models\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       /* $permissions = [
            'admin',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'company-list',
            'company-create',
            'company-edit',
            'company-delete'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        /*$role = Role::create(['name' => 'Financial Employee']);*/

       // $permissions = Permission::pluck('id','id')->all();

        /*$role->syncPermissions($permissions);*/

       // $user = User::Where('name','admin')->first();

       /* $role = Role::create(['name' => 'Admin']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);*/

        /*$user->assignRole([1]);*/
    }
}
