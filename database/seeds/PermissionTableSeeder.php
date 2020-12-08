<?php

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
        $permissions = [
            'Financial-Employee-access',
            'Financial-Employee-list',
            'Financial-Employee-create',
            'Financial-Employee-edit',
            'Financial-Employee-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $role = Role::create(['name' => 'Financial Employee']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);
    }
}
