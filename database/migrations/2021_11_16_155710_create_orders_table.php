<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'orders', function ( Blueprint $table ) {
            $table->id();

            $table->integer( 'user_id' )->unsigned()->index()->nullable();
            $table->integer( 'account_id' )->unsigned()->index()->nullable();
            $table->string( 'name' )->nullable();
            $table->string( 'email' )->nullable();
            $table->string( 'phone' )->nullable();
            $table->double( 'amount' )->nullable();
            $table->double( 'store_amount' )->nullable();
            $table->double( 'currency_amount' )->nullable();
            $table->string( 'card_type' )->nullable();
            $table->longText( 'address' )->nullable();
            $table->string( 'status' )->nullable();
            $table->string( 'transaction_id' )->nullable();
            $table->string( 'currency' )->nullable();

            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'orders' );
    }
}
