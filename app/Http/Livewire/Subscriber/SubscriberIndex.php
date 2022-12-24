<?php

namespace App\Http\Livewire\Subscriber;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SubscriptionUser;

class SubscriberIndex extends Component {
    use WithPagination;

    /**
     * @var string
     */
    protected $paginationTheme = 'bootstrap';
    /**
     * @var mixed
     */
    public $search;

    /**
     * @var array
     */
    protected $queryString = [
        "search" => ['except' => ''],
        'page'   => ['except' => 1],
    ];
    public function render() {
        $subscriptionUsers = SubscriptionUser::filter( $this->search )->latest()->paginate( 15 );
        
        return view('livewire.subscriber.subscriber-index', compact( 'subscriptionUsers' ) );
    }
}