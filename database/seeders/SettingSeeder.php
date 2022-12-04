<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $userId = 1;

        $option = [
            // option_id => 1  => Manual Payment => value => 1 | 0 [ Active | Not Active ]
            [
                'user_id'    => $userId ?? 2,
                'option_id'  => 1,
                'value'      => 1,
                'created_at' => now(),
            ],
            //     option_id => 2  => Online Payment => value => 1 | 0 [ Active | Not Active ]
            [
                'user_id'    => $userId ?? 2,
                'option_id'  => 2,
                'value'      => 0,
                'created_at' => now(),
            ],
            //     'option_id' => 3 => Null [ Can be Empty ]  = Bkash Number (Only For Manual Payment)
            [
                'user_id'    => $userId ?? 2,
                'option_id'  => 3,
                'value'      => null,
                'created_at' => now(),
            ],
            //     'option_id' => Null [ Can be Empty ]  = Rocket Number (Only For Manual Payment),
            [
                'user_id'    => $userId ?? 2,
                'option_id'  => 4,
                'value'      => null,
                'created_at' => now(),
            ],
            //     'option_id' => 4 => Null [ Can be Empty ]  = Nagad Number (Only For Manual Payment)
            [
                'user_id'    => $userId ?? 2,
                'option_id'  => 5,
                'value'      => null,
                'created_at' => now(),
            ],
            //     'option_id' => 6 => Remaining SMS
            //      Default value = 0 => value = 1 - n [can any number]
            [
                'user_id'    => $userId ?? 2,
                'option_id'  => 6,
                'value'      => 0,
                'created_at' => now(),
            ],
            //     'option_id' => 6 = Front Page Image
            //      Default value = 0 [for Default image]= Front Page Image
            [
                'user_id'    => $userId ?? 2,
                'option_id'  => 7,
                'value'      => 0,
                'created_at' => now(),
            ],
            //     'option_id' => 7 => Null [ Can be Empty ]  = Can Students See Their Friends
            //      Default value = 0 | 1  [0 = Students Cannot See Friends | 1 = Students Can See Friends]
            [
                'user_id'    => $userId ?? 2,
                'option_id'  => 8,
                'value'      => 0,
                'created_at' => now(),
            ],
            //     'option_id' => 8 => Null [ Can be Empty ]  = Emoji Visibility
            //      Default value = 0 Emoji Not Visible | 1 Emoji Visibility
            [
                'user_id'    => $userId ?? 2,
                'option_id'  => 9,
                'value'      => 0,
                'created_at' => now(),
            ],
            //     'option_id' => 9 => Null [ Can be Empty ]  = Front Page Font Color
            //      Default value = dark | light
            [
                'user_id'    => $userId ?? 2,
                'option_id'  => 10,
                'value'      => "dark",
                'created_at' => now(),
            ],
            //     'option_id' => 10 => Null [ Can be Empty ]  = Dashboard Course View
            //      Default value = grid | table
            [
                'user_id'    => $userId ?? 2,
                'option_id'  => 11,
                'value'      => "grid",
                'created_at' => now(),
            ],
            // //     'option_id' => 11 => Null [ Can be Empty ]  = Manual Payment
            // //      Default value = 0 Not Active | 1 Active
            // [
            //     'user_id'    => 2,
            //     'option_id'  => 12,
            //     'value'      => 1,
            //     'created_at' => now(),
            // ],
            // //     'option_id' => 12 => Null [ Can be Empty ]  = Online Payment
            // //      Default value = 0 Not Active | 1 Active
            // [
            //     'user_id'    => 2,
            //     'option_id'  => 13,
            //     'value'      => 0,
            //     'created_at' => now(),
            // ],
            // //     'option_id' => 13 => Null [ Can be Empty ]  = Bkash Number (Only For Manual Payment)
            // [
            //     'user_id'    => 2,
            //     'option_id'  => 14,
            //     'value'      => null,
            //     'created_at' => now(),
            // ],
            // //     'option_id' => 13 => Null [ Can be Empty ]  = Rocket Number (Only For Manual Payment)
            // [
            //     'user_id'    => 2,
            //     'option_id'  => 15,
            //     'value'      => null,
            //     'created_at' => now(),
            // ],
            // //     'option_id' => 13 => Null [ Can be Empty ]  = Nagad Number (Only For Manual Payment)
            // [
            //     'user_id'    => 2,
            //     'option_id'  => 16,
            //     'value'      => null,
            //     'created_at' => now(),
            // ],
        ];
        Setting::insert( $option );
    }
}