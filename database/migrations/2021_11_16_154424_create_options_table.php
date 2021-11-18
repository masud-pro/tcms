<?php

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

        Artisan::call('db:seed', [
            '--class' => OptionSeeder::class,
        ]);
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
