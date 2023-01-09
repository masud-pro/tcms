<?php

namespace App\Http\Livewire\Subscriber;

use Livewire\Component;
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

    public function mount() {
        $this->planList = Subscription::WhereNotIn( 'name', ['Trail Plan'] )->get();
        // $t = Subscription::WhereNotIn('name', ['Trail Plan'])->get();
        // dd($t);

        // $b =

        $this->planName =  SubscriptionUser::where( 'user_id',  );

        // dd( $this->planName);
    }

    public function submit() {
        # code...
    }

    public function render() {
        return view( 'livewire.subscriber.subscription-renew' );
    }
}
