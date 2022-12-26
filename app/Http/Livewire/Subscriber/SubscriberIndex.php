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

    /**
     * @param SubscriptionUser $user
     * @param $user_status
     */
    public function change_status( SubscriptionUser $userData, $user_status ) {
        if ( $user_status == 1 ) {
            $userData->update( [
                'status' => 0,
            ] );

          //  $userData->notify( new UserStatusUpdateNotification( 0 ) );
        } else {
            $userData->update( [
                'status' => 1,
            ] );

          //  $user->notify( new UserStatusUpdateNotification( 1 ) );
        }

        session()->flash( 'status', 'Status Changed Successfully' );
    }

    public function render() {
        $subscriptionUsers = SubscriptionUser::filter( $this->search )->latest()->paginate( 15 );

        return view( 'livewire.subscriber.subscriber-index', compact( 'subscriptionUsers' ) );
    }
}