<?php

namespace App\Http\Livewire\Register;

use App\Models\AdminAccount;
use App\Models\Subscription;
use App\Models\SubscriptionUser;
use App\Models\TeacherInfo;
use App\Models\User;
use App\Traits\DefaultSettingTraits;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class SubscriberRegister extends Component {

    use DefaultSettingTraits;

    public $planName;

    public $planList;

    public $planFeature;

    public $planPrice;

    public $customPlanData = false;

    public $billChecked;

    public $month;

    public $register;

    public $nextStep;

    public $fName;

    public $lName;

    public $phoneNumber;

    public $userName;

    public $emailAddress;

    public $dob;

    public $gender;

    public $curriculum;

    public $teachingLevel;

    public $address;

    public $institute;

    public $password;

    public $password_confirmation;

    public function mount() {
        $freeTrail = Subscription::where( 'name', 'Free Trail' )->first();

        $this->planList = Subscription::all();

        $this->planName    = $freeTrail->id;
        $this->planFeature = explode( ',', Subscription::find( $freeTrail->id )->selected_feature );

        $this->register = false;
        $this->month    = 1;
    }

    public function updated() {

        $plan = Subscription::find( $this->planName );

        $featureList = explode( ',', $plan->selected_feature );

        $this->planFeature = $featureList;
        $this->planPrice   = $plan->price;
    }

    public function updatedBillChecked() {

        if ( $this->billChecked ) {
            $this->month = 12;
            $this->changeMonthsBill();
        } else {
            $this->month = 1;
            $this->changeMonthsBill();
        }

    }

    public function updatedCustomPlanData() {

        if ( $this->customPlanData ) {
            $this->month = 12;
            $this->changeMonthsBill();
        } else {
            $this->month = 1;
            $this->changeMonthsBill();
            $this->billChecked = false;
        }

    }

    public function updatedMonth() {
        $this->changeMonthsBill();
    }

    public function changeMonthsBill() {
        $plan = Subscription::find( $this->planName );

        $discountMonth    = floor( $this->month / 12 ) * 2; // 12 mash hole 10 mash gunbe
        $monthToCalculate = $this->month - $discountMonth;
        $this->planPrice  = $plan->price * $monthToCalculate;

    }

    public function nextStep() {
        $this->register = true;
        $this->nextStep = true;
    }

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

        // dd($data);

        $user = User::query();

        $newTeacher['name']      = $data['fName'] . " " .  $data['lName'];
        $newTeacher['email']     = $data['emailAddress'];
        $newTeacher['phone_no']  = $data['phoneNumber'];
        $newTeacher['dob']       = $data['dob'];
        $newTeacher['gender']    = $data['gender'];
        $newTeacher['address']   = $data['address'];
        $newTeacher['password']  = Hash::make( $data['password'] );
        $newTeacher['is_active'] = 1;

        //new user created on user table
        $user = $user->create( $newTeacher );

        // those data for teacher table
        $newTeacherData['curriculum']     = $data['curriculum'];
        $newTeacherData['institute']      = $data['institute'];
        $newTeacherData['teaching_level'] = $data['teachingLevel'];
        $newTeacherData['user_id']        = $user->id;

        TeacherInfo::create( $newTeacherData );

        $user->assignRole( 'Teacher' );
        $this->defaultSetting( $user->id );

        Auth::login( $user );

        $this->regSubscription( $this->planName, $this->planPrice, $user->id );

    }

    public function regSubscription( $planId, $planPrice, $userId ) {
        Subscription::find( $planId );

        $data['subscription_id'] = $planId;
        $data['user_id']         = $userId;
        $data['expiry_date']     = Carbon::now()->addMonths( $this->month );
        $data['status']          = 1;

        $subUser = SubscriptionUser::create( $data );

        $subAccountData['subscription_user_id'] = $subUser->id;
        $subAccountData['total_price']          = $planPrice;
        $subAccountData['from_date']            = Carbon::now();
        $subAccountData['status']               = 1;
        $subAccountData['to_date']              = Carbon::now()->addMonths( $this->month );

        AdminAccount::create( $subAccountData );
        return redirect()->route( 'dashboard' );

    }

    public function render() {
        return view( 'livewire.register.subscriber-register' );
    }

}
