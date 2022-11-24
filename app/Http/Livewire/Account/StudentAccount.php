<?php

namespace App\Http\Livewire\Account;

use App\Models\Course;
use App\Models\Account;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentAccountsExport;

class StudentAccount extends Component {

    /**
     * @var mixed
     */
    public $batch;

    /**
     * @var mixed
     */
    public $batches;

    /**
     * @var mixed
     */
    public $students;

    /**
     * @var mixed
     */
    public $user;

    /**
     * @var array
     */
    protected $queryString = [
        'user'  => ["except" => ""],
        'batch' => ["except" => ""],
    ];

    public function mount() {
        $this->batches  = Auth::user()->addedCourses()->get();
        $this->students = [];

        if ( $this->batch != "" ) {
            $this->students = Course::findOrFail( $this->batch )->user->sortBy( "name" );
        }

    }

    public function updatedBatch() {

        if ( $this->batch != "" ) {
            $this->students = Course::findOrFail( $this->batch )->user->sortBy( "name" );
        } else {
            $this->students = [];
            $this->user     = "";
            $this->batch    = "";
        }
    }

    public function updated() {
        $this->dispatchBrowserEvent( 'reInitJquery' );
    }

    public function downloadPDF() {
        return Excel::download( new StudentAccountsExport( $this->user, $this->students ), 'hello.pdf' );
    }

    public function render() {
        if ( isset( $this->batch ) && isset( $this->user ) ) {
            $accounts = Account::when( $this->user, function ( $query, $student ) {
                $query->where( "user_id", $student );
            } )->get();
        } else {
            $accounts = [];
        }

        return view( 'livewire.account.student-account', [
            "accounts" => $accounts,
        ] );
    }

}