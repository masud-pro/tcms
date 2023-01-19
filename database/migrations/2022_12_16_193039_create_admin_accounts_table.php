<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_accounts', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId( 'subscription_user_id' )->index();
            $table->double( 'total_price', 8, 2 );
            $table->date( 'to_date' );
            $table->date( 'from_date' )->nullable();
            $table->string('purpose')->nullable();
            $table->string( 'status' )->default( 'Unpaid' );

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_accounts');
    }
}