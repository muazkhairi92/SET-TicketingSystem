<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {
        //

        // app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'see-all-users']);
        Permission::create(['name' => 'delete-users']);

        Permission::create(['name' => 'see-all-tickets']);
        Permission::create(['name' => 'create-tickets']);
        Permission::create(['name' => 'edit-tickets']);
        Permission::create(['name' => 'delete-tickets']);

        $adminRole = Role::create(['name' => 'admin']);
        $supportRole = Role::create(['name' => 'support']);
        $developerRole = Role::create(['name' => 'developer']);

        $adminRole->givePermissionTo([
            'see-all-users',
            'delete-users',
        ]);

        $supportRole->givePermissionTo([
            'create-tickets',
            'see-all-tickets',
            'edit-tickets',
            'delete-tickets',
        ]);
        $developerRole->givePermissionTo([
            'edit-tickets',
            'see-all-tickets'
        ]);
    }
}
