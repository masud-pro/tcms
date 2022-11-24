<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropSomeFieldToOptionsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table( 'options', function ( Blueprint $table ) {

            $table->dropColumn( "user_id" );
            $table->dropColumn( "value" );
            $table->dropColumn( "category" );
            
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table( 'options', function ( Blueprint $table ) {

            $table->foreignId( "user_id" )->nullable()->index();
            $table->string( "value" )->nullable();
            $table->string( "category" )->nullable();

        } );
    }
}