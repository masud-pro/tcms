<?php

namespace App\Http\Livewire\Subscriber;

use Livewire\Component;
use App\Models\SubscriptionUser;

class SubscriberOwnTransaction extends Component {
    /**
     * @var mixed
     */
    public $search;

    public function render() {
        // dd(auth()->user()->id);
        // $subscriberUsers = AdminAccount::whereHas('user_id', auth()->user()->id)->first()->transactions();
        // $subscriberUsers = SubscriptionUser::where( 'user_id', auth()->user()->id )->first()->transactions;
        // $subscriberUsers = auth()->user()->subscriptionUser->transactions;

        // dd( $ownTransaction );

        // $ownTransaction = SubscriptionUser::where( 'user_id', auth()->user()->id )
        // ->first()->transactions()
        // ->where( 'purpose', 'like', "%" . $this->search . "%" )
        // ->where( 'id', 'like', "%" . $this->search . "%" )
        // ->latest()->paginate( 15 );

        $ownTransaction = SubscriptionUser::where( 'user_id', auth()->user()->id )
            ->first()->transactions()
            ->where( 'id', 'like', "%" . $this->search . "%" )
            ->orWhere( 'purpose', 'like', "%" . $this->search . "%" )
            ->latest()->paginate( 15 );

        return view( 'livewire.subscriber.subscriber-own-transaction', compact( 'ownTransaction' ) );
    }
}