<?php

namespace App\Http\Livewire\Subscriber;

use Livewire\Component;
use App\Models\AdminAccount;

class SubscriberTransaction extends Component {

    /**
     * @var mixed
     */
    public $search;

    public function render() {

        $subscriberUsers = AdminAccount::filter( $this->search )->latest()->paginate( 15 );
        return view( 'livewire.subscriber.subscriber-transaction', compact( 'subscriberUsers' ) );
    }
}