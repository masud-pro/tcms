<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->constrained()->onDelete('cascade')->index();
            $table->string('username')->unique()->nullable()->index();
            $table->bigInteger('bank_account_name')->nullable();
            $table->bigInteger('bank_account_no')->nullable();
            $table->bigInteger('bank_account_branch')->nullable();
            $table->bigInteger('nid')->nullable();
            $table->string('nid_img')->nullable();
            $table->string('institute')->nullable();
            $table->string('curriculum')->nullable();
            $table->string('teaching_level')->nullable();
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
        Schema::dropIfExists('teacher_infos');
    }
}