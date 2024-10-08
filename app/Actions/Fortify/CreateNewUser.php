<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Notifications\NewUserAdminNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers {
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array              $input
     * @return \App\Models\User
     */
    public function create( array $input ) {
        Validator::make( $input, [
            'name'             => ['required', 'string', 'max:255'],
            'email'            => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'dob'              => ['required'],
            'gender'           => ['required'],
            'class'            => ['required'],
            'phone_no'         => ['required', 'min:11', 'max:11', 'unique:users,phone_no'],
            'fathers_name'     => ['required'],
            'fathers_phone_no' => ['required', 'min:11', 'max:11'],
            'mothers_name'     => ['required'],
            'mothers_phone_no' => ['required', 'min:11', 'max:11'],
            'address'          => ['required'],
            'password'         => $this->passwordRules(),
            'terms'            => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
            'teacher_id'       => ['nullable'],
        ] )->validate();

        $user = [
            'name'             => $input['name'],
            'email'            => $input['email'],
            'dob'              => $input['dob'],
            'gender'           => $input['gender'],
            'class'            => $input['class'],
            'phone_no'         => $input['phone_no'],
            'fathers_name'     => $input['fathers_name'],
            'fathers_phone_no' => $input['fathers_phone_no'],
            'mothers_name'     => $input['mothers_name'],
            'mothers_phone_no' => $input['mothers_phone_no'],
            'address'          => $input['address'],
            'password'         => Hash::make( $input['password'] ),
            'teacher_id'       => $input['teacher_id'],
        ];

        $user = User::create( $user );

        $user->assignRole( 'Student' );

        Notification::send( $user->teacher, new NewUserAdminNotification() );

        return $user;
    }
}
