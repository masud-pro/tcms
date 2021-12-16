<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentFilesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'assignment_files', function ( Blueprint $table ) {
            $table->id();

            $table->foreignId( "assignment_response_id" )->index();
            $table->foreignId( "assignment_id" )->index();
            $table->foreignId( "assessment_id" )->index();

            $table->string( "name" );
            $table->string( "url" );

            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'assignment_files' );
    }
}
