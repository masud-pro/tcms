<?php

namespace App\Http\Livewire\Account;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Course;
use App\Models\Account;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AllBatchAccountsExport;

class AllBatchAccounts extends Component {

    use WithPagination;

    /**
     * @var mixed
     */
    public $student;

    /**
     * @var mixed
     */
    public $status;

    /**
     * @var string
     */
    protected $paginationTheme = 'bootstrap';

    /**
     * @var array
     */
    protected $queryString = [
        "student" => ["except" => ""],
        "status"  => ["except" => ""],
    ];

    /**
     * @param Account   $account
     * @param $status
     */
    public function change_status( Account $account, $status ) {

        $course = Course::findOrFail( $account->course_id );

        if ( $status == "Unpaid" ) {

            $account->update( [
                'status' => "Paid",
            ] );

            $course->user()->updateExistingPivot( $account->user_id, [
                'is_active' => 1,
            ] );
        } elseif ( $status == "Paid" ) {

            $account->update( [
                'status' => "Unpaid",
            ] );

            $course->user()->updateExistingPivot( $account->user_id, [
                'is_active' => 0,
            ] );
        } elseif ( $status == "Pending" ) {

            $account->update( [
                'status' => "Paid",
            ] );

            $course->user()->updateExistingPivot( $account->user_id, [
                'is_active' => 1,
            ] );
        }
    }

    public function downloadPDF() {
        return Excel::download( new AllBatchAccountsExport( $this->student ), 'Accounts - ' . Carbon::now()->format( 'M-Y' ) . '.pdf', \Maatwebsite\Excel\Excel::DOMPDF );
    }

    public function render() {
        return view( 'livewire.account.all-batch-accounts', [
            "accounts" => Account::select( ["accounts.*", "accounts.id as account_id", "users.id as user_id", "users.name as user_name", "users.email as user_email"] )
                ->with( "user" )
                ->whereMonth( "accounts.created_at", Carbon::today() )
                ->whereHas( "user", function ( $query ) {
                    $query->when( $this->student, function ( $query ) {
                               $query->where( 'name', 'like', '%' . $this->student . '%' )
                                     ->orWhere( 'id', 'like', $this->student );
                           } )->when( $this->status, function ( $query ) {
                        $query->where( 'status', $this->status );
                    } );
                } )
                   ->leftJoin( "users", "accounts.user_id", "=", "users.id" )
                   ->orderBy( "users.name", "asc" )
                   ->simplePaginate( 50 ),
        ] );
    }
}
