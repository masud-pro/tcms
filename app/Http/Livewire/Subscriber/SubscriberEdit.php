<?php

namespace App\Http\Livewire\Subscriber;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\AdminAccount;
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
    public $subscriptionList;
    /**
     * @var mixed
     */
    public $expiryDate;
    /**
     * @var mixed
     */
    public $specialPrice;
    /**
     * @var mixed
     */
    public $specialPriceField;

    /**
     * @var array
     */
    protected $rules = [
        'subscriberName'    => ['required'],
        'subscriberPackage' => ['required'],
        'price'             => ['required'],
        'expiryDate'        => ['required'],
        'monthCount'        => ['required'],
        'specialPrice'      => ['nullable'],
    ];

    public function mount() {
        $this->calculatePrice();
        $this->subscriptionUser  = SubscriptionUser::find( $this->subscriptionUser );
        $this->subscriberName    = $this->subscriptionUser->user->name;
        $this->subscriptionList  = Subscription::WhereNotIn( 'id', [1] )->get();
        $this->expiryDate        = Carbon::parse( $this->subscriptionUser->expiry_date )->format( 'Y-m-d' );
        $this->subscriberPackage = $this->subscriptionUser->subscription->id;
        $this->specialPrice      = $this->subscriptionUser->special_price;
        $this->monthCount        = 1;
        // dd( $this->subscriptionUser->subscription );

        // dd( $this->expiryDate );
    }

    public function updatedsubscriberPackage() {
        //   dd($this->subscriberPackage);
        // $this->subscriberPackage;
        $newPackage = $this->subscriptionUser->subscription_id != $this->subscriberPackage;
        if ( $newPackage ) {
            $this->specialPrice = null;
        } else {
            $this->specialPrice = $this->subscriptionUser->special_price;
            $this->calculatePrice();
        }
    }

    public function updatedmonthCount() {
        $this->calculatePrice();
    }

    public function updatedspecialPrice() {
        $this->calculatePrice();
    }

    // public function updated() {
    //     $this->calculatePrice();
    //     // dd( $this->subscriptionUser->special_price == $this->specialPrice );
    // }

    public function calculatePrice() {
        $subscriberPackage = Subscription::find( $this->subscriberPackage );

        if ( $this->monthCount && $this->subscriberPackage ) {

            switch ( $this->specialPrice ) {
                case "0":
                    $subscriptionPrice = $subscriberPackage->price;
                    break;
                case null:
                    $subscriptionPrice = $subscriberPackage->price;
                    break;
                default:
                    $subscriptionPrice = $this->specialPrice ?? $subscriberPackage->price;
            }

            $totalPrice = (int) $subscriptionPrice * $this->monthCount;

            $this->price             = $totalPrice;
            $this->specialPriceField = false;
        }
    }

    public function submit() {
        $data = $this->validate();

        // dd($data);

        $subscriberUser['user_id']         = $this->subscriptionUser->user_id;
        $subscriberUser['subscription_id'] = $data['subscriberPackage'];
        $subscriberUser['expiry_date']     = Carbon::parse( $this->expiryDate )->addMonths( $data['monthCount'] )->format( 'Y-m-d' );
        $subscriberUser['special_price']   = $data['specialPrice'] == null ? null : $data['specialPrice'];
        //    dd($subscriberUser['expiry_date']);
        //    dd($this->subscriptionUser);
        //  //return 0;

        $this->subscriptionUser->update( $subscriberUser );

        $subAccountData['subscription_user_id'] = $this->subscriptionUser->id;
        $subAccountData['total_price']          = (int) $data['price'];
        $subAccountData['from_date']            = $data['expiryDate'];
        $subAccountData['to_date']              = Carbon::parse( $this->expiryDate )->addMonths( $data['monthCount'] )->format( 'Y-m-d' );
        $subAccountData['status']               = 1;

        AdminAccount::create( $subAccountData );

        return redirect()->route( 'subscriber.index' );

    }

    public function render() {
        return view( 'livewire.subscriber.subscriber-edit' );

    }
}