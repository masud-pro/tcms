<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'users', function ( Blueprint $table ) {
            $table->id();
            
            $table->string( 'name' );
            $table->string( 'email' )->unique();
            $table->timestamp( 'email_verified_at' )->nullable();
            $table->string( 'password' );
            $table->rememberToken();
            $table->foreignId( 'current_team_id' )->nullable();
            $table->string( 'profile_photo_path', 2048 )->nullable();

            $table->string( "role" )->nullable();
            $table->date( "dob" )->nullable();
            $table->string( "gender" )->nullable();
            $table->integer( "class" )->nullable();
            $table->string( "roll" )->nullable();
            $table->string( "reg_no" )->nullable();
            $table->boolean( "is_active" )->default(0);
            $table->integer( "waiver" )->default(0);
            $table->string( "phone_no" )->nullable();
            $table->string( "fathers_name" )->nullable();
            $table->string( "fathers_phone_no" )->nullable();
            $table->string( "mothers_name" )->nullable();
            $table->string( "mothers_phone_no" )->nullable();
            $table->text( "address" )->nullable();

            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'users' );
    }
}
