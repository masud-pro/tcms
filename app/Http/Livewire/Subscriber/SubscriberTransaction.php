<?php

namespace App\Http\Livewire\Subscriber;

use Livewire\Component;
use App\Models\SubAccount;

class SubscriberTransaction extends Component
{

    public $search;
    
    public function render()
    {
        $subscriberUsers = SubAccount::filter( $this->search )->latest()->paginate( 15 );
        return view('livewire.subscriber.subscriber-transaction',compact('subscriberUsers'));
    }
}