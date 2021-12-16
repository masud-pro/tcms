<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();

            $table->foreignId( 'course_id' )->index();
            $table->foreignId( 'assignment_id' )->index();

            $table->string( 'name' );
            $table->text( 'description' )->nullable();
            $table->string( 'type' );
            $table->dateTime( "start_time" );
            $table->dateTime( "deadline" );
            $table->boolean( "is_accepting_submission" )->default(false);
            // $table->integer( "submit_count" )->nullable();

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
        Schema::dropIfExists('assessments');
    }
}
