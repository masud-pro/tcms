<?php

namespace App\Http\Livewire\Subscriber;

use App\Models\User;
use Livewire\Component;
use App\Models\Subscription;

class SubscriberCreate extends Component {

    /**
     * @var mixed
     */
    public $subscriberName;

    public function mount() {
        // $this->subscriberName =
    }

    public function render() {

        $subscriberList   = User::role( 'Teacher' )->get();
        $subscriptionList = Subscription::all();

        return view( 'livewire.subscriber.subscriber-create', compact( 'subscriberList', 'subscriptionList' ) );
    }
}