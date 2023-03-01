<?php

namespace App\Traits;

use App\Models\Option;
use App\Models\Setting;

trait DefaultSettingTraits
{

    /**
     * @param $userId
     */
    public function defaultSetting($userId)
    {

        $defaultOptions =  Option::WhereNotIn('role', ['Super Admin'])->get();

        foreach ($defaultOptions as $option) {
            Setting::create([
                'user_id'    => $userId, // User 
                'option_id' => $option->id,
                'value'      => $option->default_value,
                'created_at' => now(),
            ]);
        }
    }


    /**
     * @param $userId
     */
    public function adminDefaultSetting($userId)
    {
        $defaultOptions =  Option::WhereNotIn('role', ['Teacher'])->get();

        foreach ($defaultOptions as $option) {
            Setting::create([
                'user_id'    => $userId, // User 
                'option_id' => $option->id,
                'value'      => $option->default_value,
                'created_at' => now(),
            ]);
        }
    }
}

//
