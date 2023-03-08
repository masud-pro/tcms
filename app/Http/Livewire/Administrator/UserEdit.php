<?php

namespace App\Http\Livewire\Administrator;

use Livewire\Component;
use App\Models\TeacherInfo;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserEdit extends Component {

    /**
     * @var mixed
     */
    public $roles, $isTeacher, $administrator;
    /**
     * @var mixed
     */
    public $name, $email, $business_institute_name, $phone_no, $userRole, $user_name, $dob, $gender, $curriculum, $institute, $teaching_level, $password, $password_confirmation, $address;

//
    public function mount() {
        $this->roles = $this->roleName();

        // user information
        $this->name     = $this->administrator->name;
        $this->email    = $this->administrator->email;
        $this->phone_no = $this->administrator->phone_no;
        $this->dob      = $this->administrator->dob;
        $this->address  = $this->administrator->address;
        $this->gender   = $this->administrator->gender;
        $this->userRole = $this->administrator->roles->first()->id ?? '';
        // $this->password = Hash::check( 'password', $this->administrator->password );

        // teacher information
        $this->user_name               = $this->administrator->teacherInfo->username ?? '';
        $this->curriculum              = $this->administrator->teacherInfo->curriculum ?? '';
        $this->institute               = $this->administrator->teacherInfo->institute ?? '';
        $this->teaching_level          = $this->administrator->teacherInfo->teaching_level ?? '';
        $this->business_institute_name = $this->administrator->teacherInfo->business_institute_name ?? '';

        if ( $this->administrator->hasRole( 'Teacher' ) == 2 ) {
            $this->isTeacher = true;
        } else {
            $this->isTeacher = false;
        }

    }

    public function submit() {

        if ( $this->userRole == 2 ) {
            $data = $this->validate( [
                'name'                    => ['required'],
                'email'                   => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $this->administrator->id],
                'phone_no'                => ['required'],
                'userRole'                => ['required'],
                'user_name'               => ['required', 'alpha', 'max:255', 'unique:teacher_infos,username,' . $this->administrator->teacherInfo->id],
                'dob'                     => ['required'],
                'gender'                  => ['required'],
                'curriculum'              => ['required'],
                'institute'               => ['required'],
                'teaching_level'          => ['required'],
                'business_institute_name' => ['nullable'],
                'address'                 => ['required'],
                'password'                => ['nullable', 'confirmed', Password::min( 8 )],
            ] );

            $userData['name']              = $data['name'];
            $userData['email']             = $data['email'];
            $userData['phone_no']          = $data['phone_no'];
            $userData['dob']               = $data['dob'];
            $userData['gender']            = $data['gender'];
            $userData['address']           = $data['address'];
            $userData['password']          = Hash::make( $data['password'] ) ?? Hash::make( $this->password );
            $userData['role']              = 'Admin';
            $userData['is_active']         = 1;
            $userData['email_verified_at'] = now();

            // user data stored in database
            $this->administrator->update( $userData );

            // teacher info data stored in database

            $teacherData['user_id']                 = $this->administrator->id;
            $teacherData['username']                = $data['user_name'];
            $teacherData['curriculum']              = $data['curriculum'];
            $teacherData['institute']               = $data['institute'];
            $teacherData['teaching_level']          = $data['teaching_level'];
            $teacherData['business_institute_name'] = $data['business_institute_name'];

            $this->administrator->teacherInfo->update( $teacherData );
            $this->administrator->syncRoles( $this->userRole );

        } else {

            $data = $this->validate( [
                'name'                  => ['required'],
                'email'                 => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $this->administrator->id],
                'phone_no'              => ['required'],
                'dob'                   => ['required'],
                'gender'                => ['required'],
                'address'               => ['required'],
                'password'              => ['nullable', 'confirmed', Password::min( 8 )],
                'password_confirmation' => ['nullable'],
            ] );

            $userData['name']              = $data['name'];
            $userData['email']             = $data['email'];
            $userData['phone_no']          = $data['phone_no'];
            $userData['dob']               = $data['dob'];
            $userData['gender']            = $data['gender'];
            $userData['address']           = $data['address'];
            $userData['password']          = Hash::make( $data['password'] );
            $userData['role']              = 'Admin';
            $userData['is_active']         = 1;
            $userData['email_verified_at'] = now();

            // user data stored in database
            $this->administrator->update( $userData );
            $this->administrator->syncRoles( $this->userRole );

        }

        return redirect()->route( 'administrator.index' );

    }

    public function updatedUserRole() {

        if ( $this->userRole == 2 ) {
            $this->isTeacher = true;
        } else {
            $this->isTeacher = false;
        }
    }

    public function roleName() {
        return Role::WhereNotIn( 'name', ['Student'] )->get();
    }

    public function render() {
        return view( 'livewire.administrator.user-edit' );
    }
}