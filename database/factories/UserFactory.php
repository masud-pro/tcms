<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        return [
            'name'              => $this->faker->name(),
            'email'             => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random( 10 ),
            'role'              => 'Student',
            'dob'               => $this->faker->dateTime( 'd-m-Y' ),
            'gender'            => $this->faker->randomElement( ['male', 'female'] ),
            'reg_no'            => $this->faker->randomNumber(),
            'roll'              => $this->faker->randomNumber(),
            'class'             => $this->faker->numberBetween( 5, 12 ),
            'waiver'            => $this->faker->randomNumber( 3 ),
            'phone_no'          => $this->faker->phoneNumber,
            'fathers_name'      => $this->faker->name( 'male' ),
            'fathers_phone_no'  => $this->faker->phoneNumber,
            'mothers_name'      => $this->faker->name( 'female' ),
            'mothers_phone_no'  => $this->faker->phoneNumber,
            'address'           => $this->faker->address,
            'is_active'         => $this->faker->numberBetween( 0, 1 ),
            'is_active'         => $this->faker->numberBetween( 0, 1 ),
            'teacher_id'        => $this->faker->numberBetween( 3, 4 ),
        ];
    }

    // /**
    //  * Indicate that the model's email address should be unverified.
    //  *
    //  * @return \Illuminate\Database\Eloquent\Factories\Factory
    //  */
    // public function unverified() {
    //     return $this->state( function ( array $attributes ) {
    //         return [
    //             'email_verified_at' => null,
    //         ];
    //     } );
    // }

    // /**
    //  * Indicate that the user should have a personal team.
    //  *
    //  * @return $this
    //  */
    // public function withPersonalTeam() {

    //     if ( !Features::hasTeamFeatures() ) {
    //         return $this->state( [] );
    //     }

    //     return $this->has(
    //         Team::factory()
    //             ->state( function ( array $attributes, User $user ) {
    //                 return ['name' => $user->name . '\'s Team', 'user_id' => $user->id, 'personal_team' => true];
    //             } ),
    //         'ownedTeams'
    //     );
    // }

}
