<?php

use App\Models\Option;
use Database\Seeders\OptionSeeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'options', function ( Blueprint $table ) {
            $table->id();

            $table->foreignId("user_id")->nullable()->index();

            $table->string("name");
            $table->string("slug");
            $table->string("value")->nullable();
            $table->string("category")->nullable();

            $table->timestamps();
        } );

        // Option::create([
        //         'name'  => "Manual Payment",
        //         'slug'  => "manual_payment",
        //         'value' => 1,
        // ]);
        // Option::create([
        //         'name'  => "Online Payment",
        //         'slug'  => "online_payment",
        //         'value' => 0,
        // ]);
        // Option::create([
        //         'name'  => "Bkash Number (Only For Manual Payment)",
        //         'slug'  => "bkash_number",
        //         'value' => "",
        // ]);
        // Option::create([
        //         'name'  => "Rocket Number (Only For Manual Payment)",
        //         'slug'  => "rocket_number",
        //         'value' => "",
        // ]);
        // Option::create([
        //         'name'  => "Nagad Number (Only For Manual Payment)",
        //         'slug'  => "nagad_number",
        //         'value' => "",
        // ]);
        // Option::create([
        //         'name'  => "Remaining SMS",
        //         'slug'  => "remaining_sms",
        //         'value' => 0,
        // ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'options' );
    }
}