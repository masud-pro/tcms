<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseUserSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        //

        $users = User::pluck( 'id' );
        $faker = Factory::create();

        Course::factory()
            ->create()
            ->each( function ( $course ) use ( $users, $faker ) {
                $course->user()->attach( $faker->unique()->randomElements( $users, $course->capacity ));
            } );

        // DB::table('user_skill')->insert(
        //     [
        //         'user_id' => factory(App\User::class)->create()->id,
        //         'skill_id' => factory(App\Skill::class)->create()->id,
        //     ]
        // );

    }
}