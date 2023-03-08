<?php

namespace App\Http\Livewire\Administrator;

use App\Models\User;
use Livewire\Component;
use App\Models\TeacherInfo;
use Spatie\Permission\Models\Role;
use App\Traits\DefaultSettingTraits;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserCreate extends Component {

    use DefaultSettingTraits;
    /**
     * @var mixed
     */
    public $roles, $isTeacher;
    /**
     * @var mixed
     */
    public $name, $email, $phone_no, $userRole, $user_name, $business_institute_name, $dob, $gender, $curriculum, $institute, $teaching_level, $password, $password_confirmation, $address;

//
    public function mount() {
        $this->roles = $this->roleName();

        $this->isTeacher = false;

    }

    public function submit() {

        if ( $this->userRole == 2 ) {
            $data = $this->validate( [
                'name'                    => ['required'],
                'email'                   => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
                'phone_no'                => ['required'],
                'userRole'                => ['required'],
                'user_name'               => ['required', 'alpha', 'max:255', 'unique:teacher_infos,username'],
                'dob'                     => ['required'],
                'gender'                  => ['required'],
                'curriculum'              => ['required'],
                'institute'               => ['required'],
                'teaching_level'          => ['required'],
                'business_institute_name' => ['nullable'],
                'password'                => ['required', 'confirmed', Password::min( 8 )->mixedCase()->letters()->numbers()->symbols()->uncompromised()],
                'password_confirmation'   => ['required'],
                'address'                 => ['required'],
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
            $user = User::create( $userData );
            $user->assignRole( 2 );

            // teacher info data stored in database

            $teacherData['user_id']                 = $user->id;
            $teacherData['username']                = $data['user_name'];
            $teacherData['curriculum']              = $data['curriculum'];
            $teacherData['institute']               = $data['institute'];
            $teacherData['business_institute_name'] = $data['business_institute_name'];
            $teacherData['teaching_level']          = $data['teaching_level'];

            TeacherInfo::create( $teacherData );

            $this->defaultSetting( $user->id );

        } else {

            $data = $this->validate( [
                'name'                  => ['required'],
                'email'                 => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
                'phone_no'              => ['required'],
                'dob'                   => ['required'],
                'gender'                => ['required'],
                'address'               => ['required'],
                'password'              => ['required', 'confirmed', Password::min( 8 )->mixedCase()->letters()->numbers()->symbols()->uncompromised()],
                'password_confirmation' => ['required'],
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
            $user = User::create( $userData );
            $this->user->assignRole( $this->userRole );
            $this->adminDefaultSetting( $user->id );
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
        return view( 'livewire.administrator.user-create' );
    }
}