<?php

namespace App\Http\Livewire\Subscriber;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\AdminAccount;
use App\Models\Subscription;
use App\Models\SubscriptionUser;

class SubscriberCreate extends Component {

    /**
     * @var mixed
     */
    public $subscriberName, $subscriberPackage, $price, $startDate, $specialPrice, $specialPriceField, $monthCount = 1;

    /**
     * @var array
     */
    protected $rules = [
        'subscriberName'    => ['required'],
        'subscriberPackage' => ['required'],
        'price'             => ['required'],
        'startDate'         => ['required'],
        'monthCount'        => ['required'],
        'specialPrice'      => ['nullable'],
    ];

    public function mount() {

        $this->calculatePrice();
        $this->startDate = Carbon::now()->format( 'Y-m-d' );

        $this->specialPriceField = true;

    }

    public function updated() {
        $this->calculatePrice();

    }

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

        $subscriberUser['user_id']         = $data['subscriberName'];
        $subscriberUser['subscription_id'] = $data['subscriberPackage'];
        $subscriberUser['expiry_date']     = Carbon::now()->addMonths( $data['monthCount'] );
        $subscriberUser['special_price']   = $data['specialPrice'];

        $subUser = SubscriptionUser::create( $subscriberUser );

        $subAccountData['subscription_user_id'] = $subUser->id;
        $subAccountData['total_price']          = (int) $data['price'];
        $subAccountData['from_date']            = $data['startDate'];
        $subAccountData['to_date']              = Carbon::now()->addMonths( $data['monthCount'] );
        $subAccountData['status']               = 1;

        AdminAccount::create( $subAccountData );
        return redirect()->route( 'subscriber.index' );

    }

    public function render() {

        $subscriberList   = User::role( 'Teacher' )->get();
        $subscriptionList = Subscription::WhereNotIn( 'id', [1] )->get();

        return view( 'livewire.subscriber.subscriber-create', compact( 'subscriberList', 'subscriptionList' ) );
    }
}