<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubAccountsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'sub_accounts', function ( Blueprint $table ) {
            $table->id();
            $table->foreignId( 'subscription_user_id' )->index();
            $table->double( 'total_price', 8, 2 );
            $table->date( 'to_date' );
            $table->date( 'from_date' );
            $table->string( 'status' )->default( 'Unpaid' );

            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'sub_accounts' );
    }
}