<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'subscriptions', function ( Blueprint $table ) {
            $table->id();
            
            $table->string( 'name' );
            $table->double( 'price', 8, 2 );
            $table->longText( 'selected_feature' );
            $table->bigInteger( 'days' );
            
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'subscriptions' );
    }
}