<?php

namespace App\Http\Livewire\Account;

use App\Models\Account;
use App\Models\Course;
use Livewire\Component;

class StudentAccount extends Component {

    public $batch;

    public $batches;

    public $students;

    public $user;

    protected $queryString = [
        'user'  => ["except" => ""],
        'batch' => ["except" => ""],
    ];

    public function mount() {
        $this->batches  = Course::all();
        $this->students = [];

        if ( $this->batch != "" ) {
            $this->students = Course::findOrFail( $this->batch )->user->sortBy("name");
        }

    }

    public function updatedBatch() {

        if ( $this->batch != "" ) {
            $this->students = Course::findOrFail( $this->batch )->user->sortBy("name");
        } else {
            $this->students = [];
            $this->user  = "";
            $this->batch    = "";
        }

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
