<?php

namespace Database\Seeders;

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
                'password'          => Hash::make( '&#Mb619)hub' ),
                'created_at'        => now(),
            ]
        );

        $user->assignRole( 'Super Admin' );
    }
}
