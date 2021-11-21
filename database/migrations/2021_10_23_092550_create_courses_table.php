<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'courses', function ( Blueprint $table ) {
            $table->id();

            $table->string("name");
            $table->text("description")->nullable();
            $table->text("class_link")->nullable();
            $table->integer("fee");
            $table->string("type");
            $table->string("time");
            $table->integer("capacity");
            $table->string("section")->nullable();
            $table->string("subject");
            $table->string("room")->nullable();
            $table->text("address")->nullable();
            $table->string("image")->nullable();

            $table->softDeletes();
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'courses' );
    }
}
