<?php

namespace App\Traits;

use App\Models\Setting;

trait DefaultSettingTraits {

    /**
     * @param $userId
     */
    public function defaultSetting( $userId ) {
        // $b = [];

        // $optionIds = Option::pluck( 'id' )->toArray();

        // //    dd($optionId);

        // foreach ( $optionIds as $id ) {
        //     return $id;
        // }

        // // dd($b);

        $defaultOptions = [
            [
                'user_id'   => 1,
                'option_id' => 1, //  Manual Payment
                'value'     => 1, //  it can be  [ 1 ( Active ) | 0 ( Not Active ) ]

            ],
            [
                'user_id'   => 1,
                'option_id' => 2, //  Online Payment
                'value'     => 1, //  it can be  [ 1 ( Active ) | 0 ( Not Active ) ]

            ],
            [
                'user_id'   => 1,
                'option_id' => 3, //  Bkash Number (Only For Manual Payment)
                'value'     => null, //  it can be  [ Can be Empty ]

            ],
            [
                'user_id'   => 1,
                'option_id' => 4, //  Rocket Number (Only For Manual Payment),
                'value'     => null, //  it can be  [ Can be Empty ]

            ],
            [
                'user_id'   => 1,
                'option_id' => 5, //  Nagad Number (Only For Manual Payment)
                'value'     => null, //  it can be  [ Can be Empty ]

            ],
            [
                'user_id'   => 1,
                'option_id' => 6, //  Remaining SMS
                'value'     => 0, //  value = 1 - n++ [can any number]

            ],
            [
                'user_id'   => 1,
                'option_id' => 7, //  Front Page Image
                'value'     => 0, //  value = 0 [for Default image]= Front Page Image

            ],
            [
                'user_id'   => 1,
                'option_id' => 8, //  Can Students See Their Friends
                'value'     => 0, //  value = [0 = Students Cannot See Friends | 1 = Students Can See Friends]

            ],
            [
                'user_id'   => 1,
                'option_id' => 9, //  Emoji Visibility
                'value'     => 0, //  value = 0 Emoji Not Visible | 1 Emoji Visibility

            ],
            [
                'user_id'   => 1,
                'option_id' => 10, //  Front Page Font Color
                'value'     => 'dark', //  value = dark | light

            ],
            [
                'user_id'   => 1,
                'option_id' => 11, //  Dashboard Course View
                'value'     => 'grid', //  value = grid | table

            ],
        ];

        foreach ( $defaultOptions as $option ) {
            Setting::create( [
                // 'user_id'    => $option['user_id'], // User
                'user_id'    => $userId, // User
                'option_id' => $option['option_id'],
                'value'      => $option['value'],
                'created_at' => now(),
            ] );
        }
    }

}

//