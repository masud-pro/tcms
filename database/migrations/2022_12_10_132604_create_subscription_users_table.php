<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionUsersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'subscription_users', function ( Blueprint $table ) {
            $table->id();

            $table->foreignId( 'user_id' )->constrained()->onDelete( 'cascade' )->index()->nullable();
            $table->foreignId( 'subscription_id' )->nullable()->onDelete( 'cascade' )->index();
            $table->date( 'expiry_date' );
            $table->float( 'price' );
            $table->boolean( 'status' )->default( false );

            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'subscription_users' );
    }
}
