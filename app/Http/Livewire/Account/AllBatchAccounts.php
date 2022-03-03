<?php

namespace App\Http\Livewire\Account;

use Carbon\Carbon;
use App\Models\Account;
use Livewire\Component;
use Livewire\WithPagination;

class AllBatchAccounts extends Component {

    use WithPagination;

    public $q;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        "q"     => ["except" => ""],
    ];

    public function change_status( Account $account, $status ) {

        if( $status == "Unpaid" ){

            $account->update([
                'status' => "Paid",
            ]);

        }elseif($status == "Paid"){
            
            $account->update([
                'status' => "Unpaid",
            ]);
        }
    }

    public function render() {
        return view( 'livewire.account.all-batch-accounts', [
            "accounts" => Account::select( ["accounts.*", "accounts.id as account_id", "users.id as user_id", "users.name as user_name", "users.email as user_email"] )
            ->with( "user" )
            ->whereMonth("accounts.created_at", Carbon::today())
            ->whereHas( "user", function ( $query ) {
                $query->where( 'name', 'like', '%' . $this->q . '%' )
                    ->orWhere( 'id', 'like', '%' . $this->q . '%' );
            } )
            ->leftJoin( "users", "accounts.user_id", "=", "users.id" )
            ->orderBy( "users.name", "asc" )
            ->simplePaginate( 50 ),
        ] );
    }
}
