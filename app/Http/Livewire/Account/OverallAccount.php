<?php

namespace App\Http\Livewire\Account;

use App\Models\Account;
use Carbon\Carbon;
use Livewire\Component;

class OverallAccount extends Component {

    public $month;
    public $q;
    public $deleteId;
    public $updateId;

    public $account;

    protected $rules = [
        'account.name'        => 'required|string',
        'account.description' => 'nullable|string|max:500',
        'account.status'      => 'required|string',
        'account.paid_amount' => 'required|numeric|min:0',
        'account.month'       => 'required|string',
    ];

    protected $queryString = [
        "month" => ["except" => ""],
        "q"     => ["except" => ""],
    ];

    public function mount() {
        $this->account['status'] = "Revenue";
    }

    public function flushCreate() {
        $this->account           = [];
        $this->account['status'] = "Revenue";
    }

    public function deleteId( $id ) {
        $this->deleteId = $id;
    }

    public function updateId( $id ) {
        $this->updateId         = $id;
        $this->account          = Account::find( $id )->toArray();
        $this->account['month'] = Carbon::parse( $this->account['month'] )->format( "m-Y" );
    }

    public function updateAccount() {

        $data = $this->validate()['account'];

        $month         = "01" . "-" . $data['month'];
        $month         = Carbon::createFromFormat( 'd-m-Y', $month );
        $data['month'] = $month;

        Account::find( $this->updateId )->update( $data );

        $this->dispatchBrowserEvent( 'accountUpdate' );

        session()->flash( "success", "Account updated successfully" );
    }

    public function delete() {
        Account::find( $this->deleteId )->delete();
    }

    public function createAccount() {
        $data = $this->validate()['account'];

        $month         = "01" . "-" . $data['month'];
        $month         = Carbon::createFromFormat( 'd-m-Y', $month );
        $data['month'] = $month;

        Account::create( $data );

        $this->dispatchBrowserEvent( 'accountCreated' );

        session()->flash( "success", "Account added successfully" );
    }

    public function render() {

        if ( isset( $this->month ) ) {

            $everything = Account::select( ["accounts.*", "accounts.id as account_id","users.id as user_id", "users.name as user_name", "users.email as user_email"] )
                ->with( ["user", "course"] )
                ->leftJoin( "users", "accounts.user_id", "=", "users.id" )
                ->orderBy( "users.name", "asc" )
                ->orderBy( "accounts.created_at", "desc" )
                ->when( $this->q, function ( $query, $q ) {
                    $query->where( 'users.name', 'like', '%' . $q . '%' );
                } )
            // ->where( 'users.name', 'like', '%' . $this->q . '%' )
                ->when( $this->month, function ( $query, $month ) {
                    $query->whereMonth( "month", $month );
                } );

            $accounts  = $everything->get();
            $totalPaid = $accounts->where( 'status', 'Paid' )->sum( "paid_amount" );
            $netIncome = $accounts->where( 'status', 'Revenue' )->sum( "paid_amount" );

            $expense = $accounts->where( 'status', 'Expense' )->sum( "paid_amount" );

            $unpaid = $accounts->where( 'status', 'Unpaid' )->sum( "paid_amount" );
            $pending = $accounts->where( 'status', 'Pending' )->sum( "paid_amount" );
            $totalUnpaid = $unpaid + $pending;
            $total       = $netIncome + $totalPaid;
            $revenue     = $total - $expense;

        } else {
            $accounts    = [];
            $total       = null;
            $totalUnpaid = null;
        }

        return view( 'livewire.account.overall-account', [
            "accounts"    => $accounts,
            "total"       => $total ?? 0,
            "totalPaid"   => $totalPaid ?? 0,
            "revenue"     => $revenue ?? 0,
            "totalUnpaid" => $totalUnpaid ?? 0,
            "expense"     => $expense ?? 0,
            "netIncome"   => $netIncome ?? 0,
        ] );

    }

}
