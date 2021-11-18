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
        Option::insert( [
            [
                'name'  => "Manual Payment",
                'slug'  => "manual_payment",
                'value' => 1,
            ],
            [
                'name'  => "Online Payment",
                'slug'  => "online_payment",
                'value' => 0,
            ],
            [
                'name'  => "Bkash Number (Only For Manual Payment)",
                'slug'  => "bkash_number",
                'value' => "",
            ],
            [
                'name'  => "Rocket Number (Only For Manual Payment)",
                'slug'  => "rocket_number",
                'value' => "",
            ],
            [
                'name'  => "Nagad Number (Only For Manual Payment)",
                'slug'  => "nagad_number",
                'value' => "",
            ],
        ] );
    }
}
