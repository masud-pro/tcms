<?php

namespace App\Http\Livewire\Account;

use Carbon\Carbon;
use App\Models\Course;
use App\Models\Account;
use Livewire\Component;
use App\Exports\AccountsExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\AccountController;

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
        $this->batches = Auth::user()->addedCourses()->get();
        $this->month = Carbon::today()->format("m-Y");
    }

    public function deleteId( $id ) {
        $this->deleteId = $id;
    }

    public function delete() {
        Account::find( $this->deleteId )->delete();
    }

    public function downloadPDF() {
        return Excel::download(new AccountsExport($this->q, $this->batch, $this->month), 
        'Accounts - ' . $this->month . '.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }

    public function render() {

        if ( isset( $this->month ) && isset( $this->batch ) && $this->batch != "" ) {

            $thisMonthAccount = Account::whereMonth( "month", Carbon::today() )->where( "course_id", $this->batch )->count();

            if ( $thisMonthAccount == 0 ) {

                $course      = Course::findOrFail( $this->batch );
                $allaccounts = Account::whereMonth( "month", Carbon::today() )->where( "course_id", $this->batch )->pluck( "id" );

                if( $allaccounts->count() == 0 ){
                    generate_payments( $course );
                }
            }

            $everything = Account::select( ["accounts.*", "accounts.id as account_id", "users.id as user_id", "users.name as user_name", "users.email as user_email"] )
                ->with( "user" )
                ->whereHas( "user", function ( $query ) {
                    $query->where( 'name', 'like', '%' . $this->q . '%' )
                        ->orWhere( 'id', 'like', '%' . $this->q . '%' );
                } )
                ->leftJoin( "users", "accounts.user_id", "=", "users.id" )
                ->orderBy( "users.name", "asc" )
                ->when( $this->batch, function ( $query, $batch ) {
                    $query->where( "course_id", $batch );
                } )
                ->when( $this->month, function ( $query, $month ) {
                    $query->whereMonth( "month", $month );
                } )
                ->where( function ( $query ) {
                    $query->where( "status", "Paid" );
                    $query->orWhere( "status", "Unpaid" );
                    $query->orWhere( "status", "Pending" );
                } );

            $accounts    = $everything->get();
            $total       = $accounts->where( 'status', 'Paid' )->sum( "paid_amount" );
            $unpaid      = $accounts->where( 'status', 'Unpaid' )->sum( "paid_amount" );
            $pending     = $accounts->where( 'status', 'Pending' )->sum( "paid_amount" );
            $totalUnpaid = $unpaid + $pending;

            // dd($accounts);
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
