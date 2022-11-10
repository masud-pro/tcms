<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class AdminPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = [
            // 'user_management_access',
            // 'permission_create',
            // 'permission_edit',
            // 'permission_show',
            // 'permission_delete',
            // 'permission_access',
            // 'role_create',
            // 'role_edit',
            // 'role_show',
            // 'role_delete',
            // 'role_access',
            // 'user_create',
            // 'user_edit',
            // 'user_show',
            // 'user_delete',
            // 'user_access',
           
            // 
            'courses_create',
            'courses_edit',
            'courses_delete',
            'courses_update',
            'courses_access',
        ];

        foreach ($permissions as $permission)   {
            Permission::create([
                'name' => $permission
            ]);
        }
    }
}