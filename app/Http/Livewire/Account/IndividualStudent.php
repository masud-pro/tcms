<?php

namespace App\Http\Livewire\Account;

use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class IndividualStudent extends Component {

    public $user;

    public $status;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        "status" => ["except" => ""],
    ];

    public function mount() {
        $this->user = Auth::user()->id;
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
