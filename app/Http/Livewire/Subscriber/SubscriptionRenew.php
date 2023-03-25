<?php

namespace App\Http\Livewire\Subscriber;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\AdminAccount;
use App\Models\Subscription;
use App\Models\SubscriptionUser;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SslCommerzPaymentController;

class SubscriptionRenew extends Component {
    /**
     * @var mixed
     */
    public $planPrice, $planList, $month, $planName, $subscriptionName, $price, $featureList, $subscriptionPreviousPrice, $showSubscriptionPreviousPrice, $subscribedUser;

    /**
     * @var array
     */
    protected $rules = [
        'month'     => 'required|int',
        'planName'  => 'required',
        'planPrice' => 'required',
    ];

    public function mount() {
        $this->subscribedUser = SubscriptionUser::where( 'user_id', auth()->user()->id )->first();
        $subscription         = Subscription::where( 'id', $this->planName )->first();

        $this->planList = Subscription::WhereNotIn( 'id', [1] )->get();
        $this->planName = $this->subscribedUser->subscription_id;
        $subscription   = Subscription::where( 'id', $this->planName )->first();

        $this->featureList      = explode( ',', $this->subscribedUser->subscription->selected_feature );
        $this->price            = $this->subscribedUser->special_price ?? $this->subscribedUser->subscription->price;
        $this->subscriptionName = $this->subscribedUser->subscription->name;

        if ( $this->subscribedUser->special_price ) {
            $this->subscriptionPreviousPrice     = $subscription->price;
            $this->showSubscriptionPreviousPrice = true;
        }
    }

    public function updatedplanName() {
        $this->validate([
            'planName'  => 'required|int',
        ],[
            'planName.required' => 'This field is required.',
            'planName.integer' => 'Please Select Your Plan',
        ]);
        $this->calculatePrice();
    }

    public function updatedmonth() {
        $this->calculatePrice();
        $this->changeMonthsBill();
    }

    public function changeMonthsBill() {
        $plan = Subscription::find( $this->planName );

        $discountMonth    = floor( (int) $this->month / 12 ) * 2; // 12 mash hole 10 mash gunbe
        $monthToCalculate = (int) $this->month - $discountMonth;
        $this->planPrice  = $plan->price * $monthToCalculate;
    }

    public function calculatePrice() {
        $subscription = Subscription::where( 'id', $this->planName )->first();

        $selectedPlan = $this->subscribedUser->subscription_id == $subscription->id;

        if ( $selectedPlan ) {
            $specialPrice = $this->subscribedUser->special_price;
            $selectedPlanPrice                   = $specialPrice ?? $subscription->price;
            $this->subscriptionPreviousPrice     = $subscription->price;

            if($specialPrice){
                $this->showSubscriptionPreviousPrice = true;
            }

        } else {
            $selectedPlanPrice                   = $subscription->price;
            $this->showSubscriptionPreviousPrice = false;
        }
        $this->planPrice        = (int) $this->month * $selectedPlanPrice;
        $this->featureList      = explode( ',', $subscription->selected_feature );
        $this->price            = $selectedPlanPrice;
        $this->subscriptionName = $subscription->name;

    }

    public function submit() {
        $data = $this->validate();

        $sub = SubscriptionUser::where( 'user_id', auth()->user()->id )->first();

        $subscription['subscription_id'] = $data['planName'];
        $subscription['expiry_date']     = Carbon::parse( $sub->expiry_date )->addMonths( $data['month'] );
        $subscription['status']          = 1;

        $sub->update( $subscription );

        $subAccount['subscription_user_id'] = $sub->id;
        $subAccount['total_price']          = $data['planPrice'];
        $subAccount['to_date']              = now();
        $subAccount['from_date']            = Carbon::parse( $sub->expiry_date )->addMonths( $data['month'] );
        $subAccount['purpose']              = 'Renew Subscription : ' . $sub->subscription->name . ' Package';
        $subAccount['status']               = 0;

        $adminAccount = AdminAccount::create( $subAccount );

        $user = Auth::user();

        $this->renewPayment( $adminAccount, $user );

    }

    public function renewPayment( $adminAccount, $user ) {

        $paymentData['name']             = $user->name;
        $paymentData['email']            = $user->email;
        $paymentData['address']          = $user->address;
        $paymentData['phone_no']         = $user->phone_no;
        $paymentData['amount']           = $this->planPrice;
        $paymentData['admin_account_id'] = $adminAccount->id;
        $paymentData['user_id']          = $user->id;

        $payOptions = SslCommerzPaymentController::renew_subscription_payment( $paymentData );

        $paymentLink = json_decode( $payOptions )->data;
        return redirect( $paymentLink );
    }

    public function render() {

        return view( 'livewire.subscriber.subscription-renew' );
    }
}
