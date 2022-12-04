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
            'courses.index',
            'courses.create',
            'courses.edit',
            'courses.destroy',
            'courses.archived',
            'courses.authorization_panel',
            'courses.authorize_users',

            'student.index',
            'student.create',
            'student.edit',
            'student.destroy',

            'feed.create',
            'feed.edit',
            'feed.destroy',
            'feed.create_link',
            'feed.edit_link',
            'feed.destroy_link',

            'exam_question.index',
            'exam_question.create',
            'exam_question.edit',
            'exam_question.destroy',
            'exam_question.assigned_course',

            'attendance.course_students',
            'attendance.individual_students',

            'accounts.update',
            'accounts.course_update',
            'accounts.overall_user_account',
            'accounts.individual_student',

            'transactions.user_online_transactions',

            'file_manager.individual_teacher',

            'settings.individual_teacher',
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
            'courses.create',
            'courses.edit',
            'courses.destroy',
            'courses.archived',
            'courses.authorization_panel',
            'courses.authorize_users',

            'student.index',
            'student.create',
            'student.edit',
            'student.destroy',

            'feed.create',
            'feed.edit',
            'feed.destroy',
            'feed.create_link',
            'feed.edit_link',
            'feed.destroy_link',

            'exam_question.index',
            'exam_question.create',
            'exam_question.edit',
            'exam_question.destroy',
            'exam_question.assigned_course',

            'attendance.course_students',
            'attendance.individual_students',

            'accounts.update',
            'accounts.course_update',
            'accounts.overall_user_account',
            'accounts.individual_student',

            'transactions.user_online_transactions',

            'file_manager.individual_teacher',

            'settings.individual_teacher',
        ] );

        $teacher = Role::create( ['name' => 'Teacher'] );

        $teacher->givePermissionTo( [
            'courses.index',
            'courses.create',
            'courses.edit',
            'courses.destroy',
            'courses.archived',
            'courses.authorization_panel',
            'courses.authorize_users',

            'student.index',
            'student.create',
            'student.edit',
            'student.destroy',

            'feed.create',
            'feed.edit',
            'feed.destroy',
            'feed.create_link',
            'feed.edit_link',
            'feed.destroy_link',

            'exam_question.index',
            'exam_question.create',
            'exam_question.edit',
            'exam_question.destroy',
            'exam_question.assigned_course',

            'attendance.course_students',
            'attendance.individual_students',

            'accounts.update',
            'accounts.course_update',
            'accounts.overall_user_account',
            'accounts.individual_student',

            'transactions.user_online_transactions',

            'file_manager.individual_teacher',

            'settings.individual_teacher',
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
