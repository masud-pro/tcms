<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTeacherIdToCoursesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table( 'courses', function ( Blueprint $table ) {
            $table->foreignId( 'teacher_id' )->index()->after( 'class_link' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table( 'courses', function ( Blueprint $table ) {
            $table->dropColumn( 'teacher_id' );
        } );
    }
}
