<?php

namespace App\Http\Livewire\Account;

use App\Models\Account;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class IndividualStudent extends Component {

    /**
     * @var mixed
     */
    public $user, $status, $due, $manualPayment;

    /**
     * @var string
     */
    protected $paginationTheme = 'bootstrap';

    /**
     * @var array
     */
    protected $queryString = [
        "status" => ["except" => ""],
    ];

    public function mount() {
        $this->user = Auth::user()->id;
        // $this->onlinePayment = Option::where( "slug", "online_payment" )->first()->value;
        $this->manualPayment = getTeacherSetting( "manual_payment" )->value;
        $this->due           = Account::where( "user_id", auth()->user()->id )->where( "status", "Unpaid" )->count();
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