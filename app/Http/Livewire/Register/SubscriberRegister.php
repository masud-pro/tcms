<?php

namespace App\Http\Livewire\Register;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\TeacherInfo;
use App\Models\AdminAccount;
use App\Models\Subscription;
use App\Models\SubscriptionUser;
use App\Traits\DefaultSettingTraits;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\SslCommerzPaymentController;

class SubscriberRegister extends Component {

    use DefaultSettingTraits;
    /**
     * @var mixed
     */
    public $planId;
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
    public $customPlanData = false;
    /**
     * @var mixed
     */
    public $billChecked;
    /**
     * @var mixed
     */
    public $month;
    /**
     * @var mixed
     */
    public $register;
    /**
     * @var mixed
     */
    public $nextStep;
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
    public $username;

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
    /**
     * @var mixed
     */
    public $business_institute_name;

    public function mount() {
        $freeTrail = Subscription::find( 1 );

        $this->planList = Subscription::all();

        $this->planId      = $freeTrail->id;
        $this->planPrice   = $freeTrail->price;
        $this->planFeature = explode( ',', Subscription::find( $freeTrail->id )->selected_feature );

        $this->register = false;
        $this->month    = 1;
        // $this->dob    = Carbon::today()->format("m-Y");
    }

    public function updatedplanId() {
        $plan = Subscription::find( $this->planId );

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
        $plan = Subscription::find( $this->planId );

        $discountMonth    = floor( $this->month / 12 ) * 2; // 12 mash hole 10 mash gunbe
        $monthToCalculate = $this->month - $discountMonth;
        $this->planPrice  = $plan->price * $monthToCalculate;
    }

    public function nextStep() {
        $this->register = true;
        $this->nextStep = true;
        $this->dispatchBrowserEvent( 'initLiveValidation' );
    }

    protected function rules() {
        return [
            'fName'                   => ['required'],
            'lName'                   => ['required'],
            'phoneNumber'             => ['required'],
            'username'                => ['required', 'alpha', 'max:255', 'unique:teacher_infos,username'],
            'emailAddress'            => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'dob'                     => ['required'],
            'gender'                  => ['required'],
            'curriculum'              => ['required'],
            'institute'               => ['nullable'],
            'business_institute_name' => ['nullable'],
            'teachingLevel'           => ['required'],
            'address'                 => ['required'],
            'password'                => ['required', 'confirmed', Password::min( 8 )->mixedCase()->letters()->numbers()->symbols()->uncompromised()],
            'password_confirmation'   => ['required'],
        ];
    }

    /**
     * @var array
     */
    protected $messages = [
        'fName.required'         => 'Please enter your first name.',
        'lName.required'         => 'Please enter Your last name.',
        'phoneNumber.required'   => 'Please enter Your phone number.',
        'username.required'      => 'The user name field is required.',
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

        $newTeacher['name']      = $data['fName'] . " " . $data['lName'];
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
        $newTeacherData['curriculum']              = $data['curriculum'];
        $newTeacherData['institute']               = $data['institute'];
        $newTeacherData['teaching_level']          = $data['teachingLevel'];
        $newTeacherData['username']                = $data['username'];
        $newTeacherData['business_institute_name'] = $data['business_institute_name'];
        $newTeacherData['user_id']                 = $user->id;

        TeacherInfo::create( $newTeacherData );

        $user->assignRole( 'Teacher' );
        $this->defaultSetting( $user->id );

        $this->regSubscription( $this->planId, $this->planPrice, $user );

        Auth::login( $user );

        $domainToRedirect = getToBeSubdomain( $newTeacherData['username'] );
        return redirect( $domainToRedirect . RouteServiceProvider::HOME );
    }

    /**
     * @param $planId
     * @param $planPrice
     * @param $user
     */
    public function regSubscription( $planId, $planPrice, $user ) {
        $subscription            = Subscription::find( $planId );
        $data['subscription_id'] = $subscription->id;
        $data['price']           = $subscription->price;
        $data['user_id']         = $user->id;
        $data['expiry_date']     = Carbon::now()->addMonths( $this->month );
        $data['status']          = 0;

        $subUser = SubscriptionUser::create( $data );

        $subAccountData['subscription_user_id'] = $subUser->id;
        $subAccountData['total_price']          = $planPrice;
        $subAccountData['from_date']            = Carbon::now();
        $subAccountData['status']               = 0;
        $subAccountData['to_date']              = Carbon::now()->addMonths( $this->month );

        $adminAccount = AdminAccount::create( $subAccountData );

        if ( $planPrice != 0 ) {

            $paymentData['name']             = $user->name;
            $paymentData['email']            = $user->email;
            $paymentData['address']          = $user->address;
            $paymentData['phone_no']         = $user->phone_no;
            $paymentData['amount']           = $this->planPrice;
            $paymentData['admin_account_id'] = $adminAccount->id;
            $paymentData['user_id']          = $user->id;

            $payOptions  = SslCommerzPaymentController::subscription_payment( $paymentData );
            $paymentLink = json_decode( $payOptions )->data;
            return redirect( $paymentLink );
        } else {
            $subUser->update( [
                'status' => 1,
            ] );
            $adminAccount->update( [
                'status' => 1,
            ] );
            Auth::login( $user );
            return redirect()->route( 'dashboard' );
        }
    }

    public function render() {
        return view( 'livewire.register.subscriber-register' );
    }
}