<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'feeds', function ( Blueprint $table ) {
            $table->id();

            $table->foreignId( 'course_id' )->index();
            $table->foreignId( 'user_id' )->index();

            $table->string( 'name' );
            $table->text( 'description' )->nullable();
            $table->string( 'type' );
            $table->text( 'link' )->nullable();

            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'feeds' );
    }
}
