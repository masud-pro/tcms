<?php

namespace Database\Seeders;

use App\Models\Subscription;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $subscription = [
            'name'  => 'Test name',
            'price' => 999,
            'days'  => 29,
        ];

        Subscription::create( $subscription );

    }
}