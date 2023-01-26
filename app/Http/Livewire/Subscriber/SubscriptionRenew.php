<?php

namespace App\Http\Livewire\Subscriber;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\AdminAccount;
use App\Models\Subscription;
use App\Models\SubscriptionUser;

class SubscriptionRenew extends Component {
    /**
     * @var mixed
     */
    public $planPrice;
    /**
     * @var mixed
     */
    public $planList;
    /**
     * @var mixed
     */
    public $month;
    /**
     * @var mixed
     */
    public $planName;
    /**
     * @var mixed
     */
    public $subscriptionName;
    /**
     * @var mixed
     */
    public $price;
    /**
     * @var mixed
     */
    public $featureList;
    /**
     * @var mixed
     */
    public $subscriptionPreviousPrice;
    /**
     * @var mixed
     */
    public $showSubscriptionPreviousPrice;
    /**
     * @var mixed
     */
    public $subscribedUser;
    /**
     * @var mixed
     */

    /**
     * @var array
     */
    protected $rules = [
        'month'     => 'required',
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

        if ( $this->planName ) {
            $this->subscriptionPreviousPrice     = $subscription->price;
            $this->showSubscriptionPreviousPrice = true;
        }
    }

    public function updatedplanName() {

        $this->calculatePrice();

    }

    public function updatedmonth() {
        $this->calculatePrice();
    }

    public function calculatePrice() {
        $subscription = Subscription::where( 'id', $this->planName )->first();

        $selectedPlan = $this->subscribedUser->subscription_id == $subscription->id;

        if ( $selectedPlan ) {
            $selectedPlanPrice                   = $this->subscribedUser->special_price ?? $subscription->price;
            $this->subscriptionPreviousPrice     = $subscription->price;
            $this->showSubscriptionPreviousPrice = true;

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
        $subAccount['status']               = 1;

        AdminAccount::create( $subAccount );
    }

    public function render() {

        return view( 'livewire.subscriber.subscription-renew' );
    }
}