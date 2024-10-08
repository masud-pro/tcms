<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSMSTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 's_m_s', function ( Blueprint $table ) {
            $table->id();

            $table->foreignId( "course_id" )->nullable()->index();
            $table->string( "for" );
            $table->integer( "count" );
            $table->text( "message" );

            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 's_m_s' );
    }
}
