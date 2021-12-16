<?php

namespace App\Http\Livewire\Account;

use App\Models\Account;
use App\Models\Course;
use Livewire\Component;

class AllAccounts extends Component {

    public $deleteId = '';

    public $batch;

    public $month;

    public $batches;

    protected $queryString = [
        "batch" => ["except" => ""],
        "month" => ["except" => ""],
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

            $everything = Account::when( $this->batch, function ( $query, $batch ) {
                $query->where( "course_id", $batch );
            } )->when( $this->month, function ( $query, $month ) {
                $query->whereMonth( "month", $month );
            } );

            $accounts    = $everything->get();
            $total       = $accounts->where( 'status', 'Paid' )->sum( "paid_amount" );
            $totalUnpaid = $accounts->where( 'status', 'Unpaid' )->sum( "paid_amount" );
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
