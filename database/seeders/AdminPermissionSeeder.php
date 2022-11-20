<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class AdminPermissionSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = [
            //
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
            // 'courses_create',
            // 'courses_edit',
            // 'courses_delete',
            // 'courses_update',
            // 'courses_access',
            // 'courses.edit',
            //

            'courses.index',
            'courses.archived',
            'courses.authorization_panel',
            'courses.authorize_users',
            'courses.reauthorize_users',
            'courses.create',
            'courses.edit',
            'courses.update',
            'courses.destroy',
            'feed.edit',
            'feed.destroy',
            'feed.create',
            'feed.create_link',
            'feed.store',
            'feed.store_link',
            'feed.edit_link',
            'feed.update',
            'feed.update_link',
        ];

        foreach ( $permissions as $permission ) {
            Permission::create( [
                'name' => $permission,
            ] );
        }

        // gets all permissions via Gate::before rule; see AuthServiceProvider
        $superAdmin = Role::create( ['name' => 'Super Admin'] );
        $superAdmin->givePermissionTo( [
            'courses.index',
            'courses.archived',
            'courses.authorization_panel',
            'courses.authorize_users',
            'courses.reauthorize_users',
            'courses.create',
            'courses.edit',
            'courses.update',
            'courses.destroy',
            'feed.edit',
            'feed.destroy',
            'feed.create',
            'feed.create_link',
            'feed.store',
            'feed.store_link',
            'feed.edit_link',
            'feed.update',
            'feed.update_link',
        ] );

        $teacher = Role::create( ['name' => 'Teacher'] );

        $teacher->givePermissionTo( [
            'courses.index',
            'courses.archived',
            'courses.authorization_panel',
            'courses.authorize_users',
            'courses.reauthorize_users',
            'courses.create',
            'courses.edit',
            'courses.update',
            'courses.destroy',
            'feed.edit',
            'feed.destroy',
            'feed.create',
            'feed.create_link',
            'feed.store',
            'feed.store_link',
            'feed.edit_link',
            'feed.update',
            'feed.update_link',
        ] );

        Role::create( ['name' => 'Student'] );
        Role::create( ['name' => 'Moderator'] );

        $admin = User::create(
            [
                'name'              => 'Masud Rana',
                'email'             => 'admin@admin.com',
                'phone_no'          => '01516188989',
                'email_verified_at' => now(),
                'role'              => 'Admin',
                'password'          => Hash::make( 'password' ),
                'created_at'        => now(),
            ]
        );

        $admin->assignRole( 'Super Admin' );

        $teacher = User::create(
            [
                'name'              => 'Test Teacher',
                'email'             => 'test@teacher.com',
                'email_verified_at' => now(),
                'role'              => 'Admin',
                'password'          => Hash::make( 'password' ),
                'created_at'        => now(),
            ]
        );

        $teacher->assignRole( 'Teacher' );
        
        $teacher = User::create(
            [
                'name'              => 'Test Teacher',
                'email'             => 'test@teacher2.com',
                'email_verified_at' => now(),
                'role'              => 'Admin',
                'password'          => Hash::make( 'password' ),
                'created_at'        => now(),
            ]
        );

        $teacher->assignRole( 'Teacher' );
    }
}