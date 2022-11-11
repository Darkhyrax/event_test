<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //We create first the permissions
        Permission::create(['name' => 'manage_events']);
        Permission::create(['name' => 'manage_participants']);

        // We create and store the admin role
        $adminrole = Role::create(['name' => 'Administrator']);

        // We give created permissions to role administrator
        $adminrole->givePermissionTo('manage_events');
        $adminrole->givePermissionTo('manage_participants');

        // We create next user role
        Role::create(['name' => 'User']);
    }
}
