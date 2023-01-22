<?php

namespace App\Http\Livewire\Subscriber;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\AdminAccount;
use App\Models\Subscription;
use App\Models\SubscriptionUser;

class SubscriptionRenew extends Component {
    public $planPrice;
    public $planList;
    public $month;
    public $planName;
    public $price;
    public $featureList;

    /**
     * @var array
     */
    protected $rules = [
        'month'     => 'required',
        'planName'  => 'required',
        'planPrice' => 'required',
    ];

    public function mount() {
        $this->planList    = Subscription::WhereNotIn( 'name', ['Free Trail'] )->get();
        $this->planName    = SubscriptionUser::where( 'user_id', auth()->user()->id )->first()['subscription_id'];
        $this->planPrice   = $this->month * Subscription::where( 'id', $this->planName )->first()['price'];
        $this->featureList = explode( ',', Subscription::where( 'id', $this->planName )->first()['selected_feature'] );
        $this->price       = Subscription::where( 'id', $this->planName )->first()['price'];
    }

    public function updated() {
        $price             = Subscription::where( 'id', $this->planName )->first()['price'];
        $this->planPrice   = (int) $this->month * $price;
        $this->featureList = explode( ',', Subscription::where( 'id', $this->planName )->first()['selected_feature'] );
        $this->price       = Subscription::where( 'id', $this->planName )->first()['price'];
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
