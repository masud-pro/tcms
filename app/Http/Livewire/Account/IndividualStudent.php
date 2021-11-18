<?php

namespace App\Http\Livewire\Account;

use App\Models\Option;
use App\Models\Account;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class IndividualStudent extends Component {

    public $user;

    public $status;

    public $onlinePayment;

    public $manualPayment;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        "status" => ["except" => ""],
    ];

    public function mount() {
        $this->user = Auth::user()->id;
        $this->onlinePayment = Option::where( "slug", "online_payment" )->first()->value;
        $this->manualPayment = Option::where( "slug", "manual_payment" )->first()->value;
    }

    public function render() {

        if ( isset( $this->user ) ) {
            $accounts = Account::when( $this->user, function ( $query, $student ) {
                $query->where( "user_id", $student );
            } )
                ->when( $this->status, function ( $query, $status ) {
                    $query->where( "status", $status );
                } )
                ->latest()
                ->simplePaginate( 15 );
        } else {
            $accounts = [];
        }

        return view( 'livewire.account.individual-student', [
            'accounts' => $accounts,
        ] );
    }

}
