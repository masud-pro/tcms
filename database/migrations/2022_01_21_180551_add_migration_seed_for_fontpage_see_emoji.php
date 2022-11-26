<?php

use App\Models\Option;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMigrationSeedForFontpageSeeEmoji extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::table('accounts', function (Blueprint $table) {
            $table->string('name')->nullable()->after("course_id");
            $table->longText('description')->nullable()->after("name");
            $table->dropColumn('plus_minus');

            $table->foreignId( "user_id" )->nullable()->change();
            $table->foreignId( "course_id" )->nullable()->change();
        });        

        // Option::create( [
        //     'name'  => "Front Page Image",
        //     'slug'  => "front_page_image",
        //     'value' => 0,
        // ] );

        // Option::create( [
        //     'name'  => "Can Students See Their Friends",
        //     'slug'  => "can_student_see_friends",
        //     'value' => 1,
        // ] );

        // Option::create( [
        //     'name'  => "Emoji Visibility",
        //     'slug'  => "emoji_visibility",
        //     'value' => 1,
        // ] );

        // Option::create( [
        //     'name'  => "Front Page Font Color",
        //     'slug'  => "front_page_font_color",
        //     'value' => "dark", // light
        // ] );

        // Option::create( [
        //     'name'  => "Dashboard Course View",
        //     'slug'  => "dashboard_course_view",
        //     'value' => "grid", // table
        // ] );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('description');
            $table->string( "plus_minus" )->nullable();

            $table->foreignId( "user_id" )->required()->change();
            $table->foreignId( "course_id" )->required()->change();
        }); 

        // Option::where( "slug", "front_page_image" )->delete();
        // Option::where( "slug", "can_student_see_friends" )->delete();
        // Option::where( "slug", "emoji_visibility" )->delete();
        // Option::where( "slug", "front_page_font_color" )->delete();
        // Option::where( "slug", "dashboard_course_view" )->delete();
    }
}