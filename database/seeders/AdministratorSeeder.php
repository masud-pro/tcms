<?php

namespace Database\Seeders;

use App\Models\TeacherInfo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdministratorSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $user = User::create(
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

        $user->assignRole( 'Super Admin' );

        $user = User::create(
            [
                'name'              => 'Test Teacher',
                'email'             => 'test@teacher.com',
                'email_verified_at' => now(),
                'role'              => 'Admin',
                'password'          => Hash::make( 'password' ),
                'created_at'        => now(),
            ]
        );

        TeacherInfo::create([
            'user_id'           => $user->id,
            'username'          => 'testteacher',
        ]);

        $user->assignRole( 'Teacher ' );

        $user = User::create(
            [
                'name'              => 'Test Teacher Two',
                'email'             => 'test@teacher2.com',
                'email_verified_at' => now(),
                'role'              => 'Admin',
                'password'          => Hash::make( 'password' ),
                'created_at'        => now(),
            ]
        );

        $user->assignRole( 'Teacher ' );
    }
}
