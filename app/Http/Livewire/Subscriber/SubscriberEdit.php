<?php

namespace App\Http\Livewire\Subscriber;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\SubAccount;
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
        $this->subscriptionUser  = SubscriptionUser::find( $this->subscriptionUser );
        $this->subscriberName    = $this->subscriptionUser->user->name;
        $this->subscriptionList  = Subscription::all();
        $this->expiryDate        = Carbon::parse( $this->subscriptionUser->expiry_date )->format( 'Y-m-d' );
        $this->subscriberPackage = $this->subscriptionUser->subscription->id;
        // dd( $this->subscriptionUser->subscription );

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

        // dd($data);

        $subscriberUser['user_id']         = $this->subscriptionUser->user_id;
        $subscriberUser['subscription_id'] = $data['subscriberPackage'];
        $subscriberUser['expiry_date']     = Carbon::parse( $this->expiryDate )->addMonths( $data['monthCount'] )->format( 'Y-m-d' );

        //    dd($subscriberUser['expiry_date']);
        //    dd($this->subscriptionUser);
        //  //return 0;

        $this->subscriptionUser->update( $subscriberUser );

        $subAccountData['subscription_user_id'] = $this->subscriptionUser->id;
        $subAccountData['total_price']          = $data['price'];
        $subAccountData['from_date']            = $data['expiryDate'];
        $subAccountData['to_date']              = Carbon::parse( $this->expiryDate )->addMonths( $data['monthCount'] )->format( 'Y-m-d' );
        $subAccountData['status']               = 1;

        SubAccount::create( $subAccountData );

        return redirect()->route( 'subscriber.index' );

    }

    public function render() {
        return view( 'livewire.subscriber.subscriber-edit' );

    }
}