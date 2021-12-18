<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentResponsesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'assignment_responses', function ( Blueprint $table ) {
            $table->id();

            $table->foreignId( "assessment_id" )->index();
            $table->foreignId( "assignment_id" )->index();
            $table->foreignId( "user_id" )->index();

            $table->text( "answer" )->nullable();
            $table->float( "marks" )->nullable();
            $table->boolean( "is_marks_published" )->default( false );
            $table->boolean( "is_submitted" )->default( false );
            $table->dateTime( "submitted_at" )->nullable();

            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'assignment_responses' );
    }
}
