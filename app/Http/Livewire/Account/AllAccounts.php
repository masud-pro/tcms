<?php

namespace App\Http\Livewire\Account;

use App\Models\Account;
use App\Models\Course;
use Livewire\Component;

/**
 * This class is of mailnly batch accounts with paid unpaid but no expense
 */
class AllAccounts extends Component {

    public $deleteId = '';

    public $batch;

    public $month;

    public $batches;

    public $q;

    protected $queryString = [
        "batch" => ["except" => ""],
        "month" => ["except" => ""],
        "q"     => ["except" => ""],
    ];

    public function mount() {
        $this->batches = Course::all();
    }

    public function deleteId( $id ) {
        $this->deleteId = $id;
    }

    public function delete() {
        Account::find( $this->deleteId )->delete();
    }

    public function render() {

        if ( isset( $this->month ) && isset( $this->batch ) && $this->batch != "" ) {

            $everything = Account::select( ["accounts.*", "accounts.id as account_id", "users.name as user_name", "users.email as user_email"] )
                ->with( "user")
                ->whereHas("user",function($query){
                    $query->where('name', 'like', '%'.$this->q.'%');
                })
                ->leftJoin( "users", "accounts.user_id", "=", "users.id" )
                ->orderBy( "users.name", "asc" )
                
                ->when( $this->batch, function ( $query, $batch ) {
                    $query->where( "course_id", $batch );
                } )
                ->when( $this->month, function ( $query, $month ) {
                    $query->whereMonth( "month", $month );
                } )
                ->where( function($query){
                    $query->where("status", "Paid");
                    $query->orWhere("status", "Unpaid");
                } );

            $accounts    = $everything->get();
            $total       = $accounts->where( 'status', 'Paid' )->sum( "paid_amount" );
            $totalUnpaid = $accounts->where( 'status', 'Unpaid' )->sum( "paid_amount" );

            // dd($everything);
        } else {
            $accounts    = [];
            $total       = null;
            $totalUnpaid = null;
        }

        return view( 'livewire.account.all-accounts', [
            "accounts"    => $accounts,
            "total"       => $total ?? 0,
            "totalUnpaid" => $totalUnpaid ?? 0,
        ] );
    }

}
