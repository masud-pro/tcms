<?php

namespace App\Http\Livewire\Subscriber;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\Subscription;

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

        dd( $data );
        // $monthCount   = Carbon::parse( $this->monthCount );
        // $startDate = Carbon::parse( $this->startDate );
        // $diff      = $startDate->diffInYears( $monthCount );

        // dd( $diff );

        //  dd( $this->subscriberName, $this->subscriberPackage, $this->startDate, $this->monthCount, $this->price );
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