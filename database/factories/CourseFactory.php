<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory {

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        return [
            'name'        => $this->faker->name,
            'description' => $this->faker->text( 200 ),
            'class_link'  => $this->faker->text,
            'fee'         => $this->faker->numberBetween( 1000, 3000 ),
            'type'        => $this->faker->randomElement( ['Monthly', 'One Time'] ),
            'capacity'    => $this->faker->numberBetween( 10, 70 ),
            'time'        => $this->faker->date( 'd-M-y', 'now' ),
            'section'     => $this->faker->word,
            'subject'     => $this->faker->word,
            'room'        => $this->faker->numberBetween( 15, 150 ),
            'address'     => $this->faker->address,
            'image'       => null,
            'teacher_id'  => $this->faker->numberBetween( 2, 3 ),
        ];
    }
}