<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation {
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update( $user, array $input ) {

        if ( Auth::user()->role == "Student" ) {
            Validator::make( $input, [
                'name'         => ['required', 'string', 'max:255'],
                'email'        => ['required', 'email', 'max:255', Rule::unique( 'users' )->ignore( $user->id )],
                "address"      => ["required"],
                "role"         => ["required"],
                "dob"          => ["required"], ["date"],
                "gender"       => ["required"],
                "class"        => ["nullable", "integer"],
                "phone_no"     => ["required", 'min:11', 'max:11',Rule::unique( 'users', 'phone_no' )->ignore( $user->id )],
                "fathers_name" => ["nullable", "string"],
                "mothers_name" => ["nullable", "string"],
                'photo'        => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            ] )->validateWithBag( 'updateProfileInformation' );
        } else {
            Validator::make( $input, [
                'name'     => ['required', 'string', 'max:255'],
                'phone_no' => ['required', 'min:11', 'max:11'],
                'email'    => ['required', 'email', 'max:255', Rule::unique( 'users' )->ignore( $user->id )],
                'photo'    => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            ] )->validateWithBag( 'updateProfileInformation' );
        }

        if ( isset( $input['photo'] ) ) {
            $user->updateProfilePhoto( $input['photo'] );
        }

        if ( $input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail ) {
            $this->updateVerifiedUser( $user, $input );
        } else {
            $user->forceFill( [
                'name'         => $input['name'],
                'email'        => $input['email'],
                'address'      => $input['address'],
                'role'         => $input['role'],
                'dob'          => $input['dob'],
                'gender'       => $input['gender'],
                'class'        => $input['class'],
                'phone_no'     => $input['phone_no'],
                'fathers_name' => $input['fathers_name'],
                'mothers_name' => $input['mothers_name'],
            ] )->save();
        }

    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser( $user, array $input ) {
        $user->forceFill( [
            'name'              => $input['name'],
            'email'             => $input['email'],
            'email_verified_at' => null,
        ] )->save();

        $user->sendEmailVerificationNotification();
    }

}
