<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SomeSAASChanges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('teacher_id')->nullable()->after('current_team_id');
        });

        Schema::table( 'courses', function ( Blueprint $table ) {
            $table->foreignId( 'teacher_id' )->index()->after( 'class_link' );
        } );

        Schema::table( 'options', function ( Blueprint $table ) {

            $table->dropColumn( "user_id" );
            $table->dropColumn( "value" );
            $table->dropColumn( "category" );
            
        } );

        Schema::table( 'orders', function ( Blueprint $table ) {
            $table->foreignId( 'teacher_id' )->index();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('teacher_id')->nullable();
        });

        Schema::table( 'courses', function ( Blueprint $table ) {
            $table->dropColumn( 'teacher_id' );
        } );

        Schema::table( 'options', function ( Blueprint $table ) {
            $table->foreignId( "user_id" )->nullable()->index();
            $table->string( "value" )->nullable();
            $table->string( "category" )->nullable();
        } );

        Schema::table( 'orders', function ( Blueprint $table ) {
            $table->dropColumn( 'teacher_id' )->index();
        } );
    }
}
