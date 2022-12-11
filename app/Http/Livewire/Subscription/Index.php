<?php

namespace App\Http\Livewire\Subscription;

use Livewire\Component;
use App\Models\Subscription;
use Livewire\WithPagination;

class Index extends Component {
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
        $subscriptions = Subscription::filter( $this->search )->latest()->paginate( 15 );
        return view( 'livewire.subscription.index', compact( 'subscriptions' ) );
    }
}