<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::create( 'accounts', function ( Blueprint $table ) {
            $table->id();

            $table->foreignId( "user_id" )->index();
            $table->foreignId( "course_id" )->index();
            $table->string( "status" )->default( "Unpaid" );
            $table->integer( "paid_amount" );
            $table->date( "month" );
            $table->string( "plus_minus" )->nullable();

            $table->timestamps();
        } );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'accounts' );
    }
}
