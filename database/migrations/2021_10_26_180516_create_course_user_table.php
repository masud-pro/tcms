<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseUserTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'course_user', function ( Blueprint $table ) {
            $table->id();

            $table->foreignId( "course_id" );
            $table->foreignId( "user_id" );
            $table->boolean( "is_active" )->default( 0 );

            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'course_user' );
    }
}