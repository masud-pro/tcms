<?php

namespace App\Http\Livewire\Subscriber;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\SubAccount;
use App\Models\Subscription;
use App\Models\SubscriptionUser;

class SubscriberCreate extends Component {

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
    public $startDate;
    /**
     * @var mixed
     */
    public $monthCount = 1;

    /**
     * @var array
     */
    protected $rules = [
        'subscriberName'    => ['required'],
        'subscriberPackage' => ['required'],
        'price'             => ['required'],
        'startDate'         => ['required'],
        'monthCount'        => ['required'],
    ];

    public function mount() {

        $this->calculatePrice();
        $this->startDate = Carbon::now()->format( 'Y-m-d' );

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

        // dd( $data );
        // $monthCount   = Carbon::parse( $this->monthCount );
        // $startDate = Carbon::parse( $this->startDate );
        // $diff      = $startDate->diffInYears( $monthCount );

        // dd( $diff );

        //  dd( $this->subscriberName, $this->subscriberPackage, $this->startDate, $this->monthCount, $this->price );

        $subscriberUser['user_id']         = $data['subscriberName'];
        $subscriberUser['subscription_id'] = $data['subscriberPackage'];
        $subscriberUser['expiry_date']     = Carbon::now()->addMonths( $data['monthCount'] );

        $subUser = SubscriptionUser::create( $subscriberUser );

        // dd($subUser->id);

        $subAccountData['subscription_user_id'] = $subUser->id;
        $subAccountData['total_price']          = $data['price'];
        $subAccountData['from_date']            = $data['startDate'];
        $subAccountData['to_date']              = Carbon::now()->addMonths( $data['monthCount'] );
        $subAccountData['status']               = 1;

        SubAccount::create( $subAccountData );
        return redirect()->route('subscriber.index');

    }

    // public function updated() {
    //     $this->dispatchBrowserEvent( 'reInitJquery' );

    // }

    public function render() {

        $subscriberList   = User::role( 'Teacher' )->get();
        $subscriptionList = Subscription::all();

        return view( 'livewire.subscriber.subscriber-create', compact( 'subscriberList', 'subscriptionList' ) );
    }
}
