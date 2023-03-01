<?php

namespace Database\Seeders;

use App\Models\Option;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Option::truncate();

        $option = [
            [
                'id'            => 1,
                'name'          => "Manual Payment",
                'slug'          => "manual_payment",
                'default_value' => 1,
                'role'          => "Teacher",
                'created_at'    => now(),
            ],
            [
                'id'            => 3,
                'name'          => "Bkash Number (Only For Manual Payment)",
                'slug'          => "bkash_number",
                'default_value' => null,
                'role'          => "Teacher",
                'created_at'    => now(),
            ],
            [
                'id'            => 4,
                'name'          => "Rocket Number (Only For Manual Payment)",
                'slug'          => "rocket_number",
                'default_value' => null,
                'role'          => "Teacher",
                'created_at'    => now(),
            ],
            [
                'id'            => 5,
                'name'          => "Nagad Number (Only For Manual Payment)",
                'slug'          => "nagad_number",
                'default_value' => null,
                'role'          => "Teacher",
                'created_at'    => now(),
            ],
            [
                'id'            => 6,
                'name'          => "Remaining SMS",
                'slug'          => "remaining_sms",
                'default_value' => 10,
                'role'          => "Teacher",
                'created_at'    => now(),
            ],
            [
                'id'            => 7,
                'name'          => "Front Page Image",
                'slug'          => "front_page_image",
                'default_value' => 0,
                'role'          => "All User",
                'created_at'    => now(),
            ],
            [
                'id'            => 8,
                'name'          => "Can Students See Their Friends",
                'slug'          => "can_student_see_friends",
                'default_value' => 0,
                'role'          => "Teacher",
                'created_at'    => now(),
            ],
            [
                'id'            => 9,
                'name'          => "Emoji Visibility",
                'slug'          => "emoji_visibility",
                'default_value' => 0,
                'role'          => "Teacher",
                'created_at'    => now(),
            ],
            [
                'id'            => 10,
                'name'          => "Front Page Font Color",
                'slug'          => "front_page_font_color",
                'default_value' => "dark",
                'role'          => "All User",
                'created_at'    => now(),
            ],
            [
                'id'            => 11,
                'name'          => "Dashboard Course View",
                'slug'          => "dashboard_course_view",
                'default_value' => "grid",
                'role'          => "Teacher",
                'created_at'    => now(),
            ], [
                'id'            => 12,
                'name'          => "Super Admin",
                'slug'          => "total_massage_count",
                'default_value' => "grid",
                'role'          => "Teacher",
                'created_at'    => now(),
            ],

        ];
        Option::insert($option);
    }
}