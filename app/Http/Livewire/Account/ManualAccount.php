<?php

namespace App\Http\Livewire\Account;

use App\Models\Account;
use App\Models\Course;
use Carbon\Carbon;
use Livewire\Component;

class ManualAccount extends Component {
    public $batch;

    public $month;

    public $student;

    public $batches;

    public $students;

    public $paid_amount;

    public $status;

    protected $rules = [
        'student'     => 'required',
        'batch'       => 'required',
        'month'       => 'required',
        'paid_amount' => 'required|integer',
        'status'      => 'required',
    ];

    protected $queryString = [
        'student' => ["except" => ""],
        'batch'   => ["except" => ""],
        'month',
    ];

    public function mount() {
        $this->batches  = Course::all();
        $this->students = [];
        $this->status   = "Unpaid";

        if ( $this->batch != "" ) {
            $this->students = Course::findOrFail( $this->batch )->user;
        }

    }

    public function add() {

        $validatedData = $this->validate();

        unset( $validatedData['batch'] );

        $validatedData['user_id']   = $this->student;
        $validatedData['course_id'] = $this->batch;

        // Format the month
        $month                      = "01" . "-" . $validatedData['month'];
        $month                      = Carbon::createFromFormat( 'd-m-Y', $month );

        $validatedData['month']     = $month;
        
        Account::create( $validatedData );

        return redirect()->route( "course.accounts.create", ['course' => $this->batch] )->with( "success", "Account Added Successfully" );
    }

    public function updatedBatch() {

        if ( $this->batch != "" ) {
            $this->students = Course::findOrFail( $this->batch )->user;
        } else {
            $this->students = [];
            $this->student  = "";
            $this->batch    = "";
        }

    }

    public function render() {

        if (
            isset( $this->batch ) &&
            isset( $this->student ) &&
            isset( $this->month ) &&
            $this->batch != "" &&
            $this->student != ""
        ) {
            $showForm = true;
        } else {
            $showForm = false;
        }

        return view( 'livewire.account.manual-account', [
            'showForm' => $showForm,
        ] );
    }

}
