<?php

namespace App\Http\Livewire\Subscriber;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\Subscription;
use App\Models\SubscriptionUser;

class SubscriberEdit extends Component {

    /**
     * @var mixed
     */
    public $subscriptionUser;
    /**
     * @var mixed
     */
    public $subscriberName;
    /**
     * @var mixed
     */
    public $subscriberPackage;
    /**
     * @var mixed
     */
    public $price;
    /**
     * @var mixed
     */
    public $monthCount;
    /**
     * @var mixed
     */
    // public $subscriberList;
    /**
     * @var mixed
     */
    public $subscriptionList;

    /**
     * @var mixed
     */
    public $expiryDate;
    /**
     * @var array
     */
    protected $rules = [
        'subscriberName'    => ['required'],
        'subscriberPackage' => ['required'],
        'price'             => ['required'],
        'expiryDate'        => ['required'],
        'monthCount'        => ['required'],
    ];

    public function mount() {
        $this->calculatePrice();
        $this->subscriptionUser = SubscriptionUser::find( $this->subscriptionUser );
        $this->subscriberName   = $this->subscriptionUser->user->name;
        $this->subscriptionList = Subscription::all();
        $this->expiryDate       = Carbon::parse( $this->subscriptionUser->expiry_date )->format( 'Y-m-d' );

        // dd( $this->expiryDate );
    }

    public function updated() {
        $this->calculatePrice();

    }

    public function calculatePrice() {
        $subscriberPackage = Subscription::find( $this->subscriberPackage );

        if ( $this->monthCount && $this->subscriberPackage ) {
            $totalPrice = $subscriberPackage->price * $this->monthCount;

            $this->price = $totalPrice;
        }
    }

    public function submit() {
        $data = $this->validate();
    }

    public function render() {
        return view( 'livewire.subscriber.subscriber-edit' );

    }
}