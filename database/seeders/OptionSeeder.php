<?php

namespace Database\Seeders;

use App\Models\Option;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        
        Option::truncate();

        $option = [
            [
                'id'   => 1,
                'name' => "Manual Payment",
                'slug' => "manual_payment",
                'created_at' =>now(),
            ],
            [
                'id'   => 2,
                'name' => "Online Payment",
                'slug' => "online_payment",
                'created_at' =>now(),
            ],
            [
                'id'   => 3,
                'name' => "Bkash Number (Only For Manual Payment)",
                'slug' => "bkash_number",
                'created_at' =>now(),
            ],
            [
                'id'   => 4,
                'name' => "Rocket Number (Only For Manual Payment)",
                'slug' => "rocket_number",
                'created_at' =>now(),
            ],
            [
                'id'   => 5,
                'name' => "Nagad Number (Only For Manual Payment)",
                'slug' => "nagad_number",
                'created_at' =>now(),
            ],
            
            [
                'id'   => 6,
                'name' => "Remaining SMS",
                'slug' => "remaining_sms",
                'created_at' =>now(),
            ],
        ];
        Option::insert( $option );
    }
}

// Option::create([
//     'name'  => "Manual Payment",
//     'slug'  => "manual_payment",
//     'value' => 1,
// ]);
// Option::create([
//     'name'  => "Online Payment",
//     'slug'  => "online_payment",
//     'value' => 0,
// ]);
// Option::create([
//     'name'  => "Bkash Number (Only For Manual Payment)",
//     'slug'  => "bkash_number",
//     'value' => "",
// ]);
// Option::create([
//     'name'  => "Rocket Number (Only For Manual Payment)",
//     'slug'  => "rocket_number",
//     'value' => "",
// ]);
// Option::create([
//     'name'  => "Nagad Number (Only For Manual Payment)",
//     'slug'  => "nagad_number",
//     'value' => "",
// ]);
// Option::create([
//     'name'  => "Remaining SMS",
//     'slug'  => "remaining_sms",
//     'value' => 0,
// ]);