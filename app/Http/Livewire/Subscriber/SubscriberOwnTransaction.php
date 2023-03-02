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

        $ownTransaction = SubscriptionUser::where( 'user_id', auth()->user()->id )
            ->first()->transactions()
            ->where( 'id', 'like', "%" . $this->search . "%" )
            ->orWhere( 'purpose', 'like', "%" . $this->search . "%" )
            ->latest()->paginate( 15 );

        return view( 'livewire.subscriber.subscriber-own-transaction', compact( 'ownTransaction' ) );
    }
}