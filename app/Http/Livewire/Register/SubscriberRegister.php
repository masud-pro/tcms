<?php

namespace App\Http\Livewire\Register;

use App\Models\User;
use Livewire\Component;
use App\Models\TeacherInfo;
use App\Models\Subscription;
use App\Traits\DefaultSettingTraits;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SubscriberRegister extends Component {
    use DefaultSettingTraits;
    /**
     * @var mixed
     */
    public $planName;
    /**
     * @var mixed
     */
    public $planList;
    /**
     * @var mixed
     */
    public $planFeature;
    /**
     * @var mixed
     */
    public $planPrice;
    /**
     * @var mixed
     */
    public $billChecked;
    /**
     * @var mixed
     */
    public $freeTrail;
    /**
     * @var mixed
     */
    public $register;
    /**
     * @var mixed
     */
    public $nextStep;
    //
    /**
     * @var mixed
     */
    public $fName;
    /**
     * @var mixed
     */
    public $lName;
    /**
     * @var mixed
     */
    public $phoneNumber;
    /**
     * @var mixed
     */
    public $userName;
    /**
     * @var mixed
     */
    public $emailAddress;
    /**
     * @var mixed
     */
    public $dob;
    /**
     * @var mixed
     */
    public $gender;
    /**
     * @var mixed
     */
    public $curriculum;
    /**
     * @var mixed
     */
    public $teachingLevel;
    /**
     * @var mixed
     */
    public $address;
    /**
     * @var mixed
     */
    public $institute;
    /**
     * @var mixed
     */
    public $password;
    /**
     * @var mixed
     */
    public $password_confirmation;

    public function mount() {

        // $this->planList = ;
        // $this->startDate = Carbon::now()->format( 'Y-m-d' );
        $freeTrail = Subscription::where( 'name', 'Trail Plan' )->first();

        $this->planList = Subscription::all();

        $this->planName    = $freeTrail->id;
        $this->planFeature = explode( ',', Subscription::find( $freeTrail->id )->selected_feature );

        $this->freeTrail = true;
        $this->register  = false;

        //    dd( Subscription::where('name', 'Trail Plan')->first());

    }

    // public function updatedBillChecked() {

    // }

    public function updated() {
        // dump( $this->billChecked );

        $plan = Subscription::find( $this->planName );

        $featureList = explode( ',', $plan->selected_feature );

        //  dd($featureList);

        //   dd($this->planFeature = $featureList);
        $this->planFeature = $featureList;
        $this->planPrice   = $plan->price;

        $this->freeTrail = false;

        if ( $this->billChecked ) {
            $this->changeMonthsBill( 1 );
        } elseif ( $this->billChecked ) {
            $this->changeMonthsBill( 12 );
        }

    }

    /**
     * @param $monthly
     */
    public function changeMonthsBill( $is_yearly ) {
        $plan = Subscription::find( $this->planName );

        if ( $is_yearly ) {
            $this->planPrice = $plan->price * 12;
        } else {
            $this->planPrice = $plan->price;
        }
    }

    public function nextStep() {
        $this->register = true;
        $this->nextStep = true;
    }

    /**
     * @var array
     */
    protected function rules() {
        return [
            'fName'                 => ['required'],
            'lName'                 => ['required'],
            'phoneNumber'           => ['required'],
            'userName'              => ['required'],
            'emailAddress'          => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'dob'                   => ['required'],
            'gender'                => ['required'],
            'curriculum'            => ['required'],
            'institute'             => ['required'],
            'teachingLevel'         => ['required'],
            'address'               => ['required'],
            'password'              => ['required', 'confirmed', Password::min( 8 )->mixedCase()->letters()->numbers()->symbols()->uncompromised()],
            'password_confirmation' => ['required'],
        ];
    }

    /**
     * @var array
     */
    protected $messages = [
        'fName.required'         => 'Please enter your first name.',
        'lName.required'         => 'Please enter Your last name.',
        'phoneNumber.required'   => 'Please enter Your phone number.',
        'userName.required'      => 'The user name field is required.',
        'emailAddress.required'  => 'The email field is required',
        'dob.required'           => 'The date of birth field is required',
        'gender.required'        => 'The gender field is required',
        'curriculum.required'    => 'The curriculum field is required',
        'institute.required'     => 'The institute field is required',
        'teachingLevel.required' => 'The teaching level field is required',
        'address.required'       => 'The address field is required',
        'password.required'      => 'The password field is required',
    ];

    public function submit() {
        $data = $this->validate();

        $user = User::query();

        $newTeacher['name']     = $data['fName'] . $data['lName'];
        $newTeacher['email']    = $data['emailAddress'];
        $newTeacher['phone_no'] = $data['phoneNumber'];
        $newTeacher['dob']      = $data['dob'];
        $newTeacher['gender']   = $data['gender'];
        $newTeacher['address']  = $data['address'];
        $newTeacher['password'] = Hash::make( $data['password'] );
        
        //new user created on user table
        $user = $user->create( $newTeacher );

        // those data for teacher table
        $newTeacherData['curriculum']     = $data['curriculum'];
        $newTeacherData['institute']      = $data['institute'];
        $newTeacherData['teaching_level'] = $data['teachingLevel'];
        $newTeacherData['user_id']        = $user->id;



        TeacherInfo::create( $newTeacherData );

        // $newTeacher['name'] = $data['fName'];

        // $data['name']     = $newUserdata['name'];
        // $data['email']    =
        // $data['phone_no'] =
        // $data['dob']      =
        // $data['gender']   =
        // $data['address']  =
        // $data['password'] = Hash::make( $request->password );

        // $user = $user->create( $userData );

        // $teacherData['curriculum']     = $request->curriculum;
        // $teacherData['institute']      = $request->institute;
        // $teacherData['teaching_level'] = $request->teaching_level;
        // $teacherData['user_id']        = $user->id;

        // TeacherInfo::create( $teacherData );

        $user->assignRole('Teacher');

    }

    public function render() {

        return view( 'livewire.register.subscriber-register' );

    }
}