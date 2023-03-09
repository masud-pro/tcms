<?php

namespace App\Http\Livewire\Account;

use Carbon\Carbon;
use App\Models\Course;
use App\Models\Account;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ManualAccount extends Component {
    /**
     * @var mixed
     */
    public $batch, $month, $student, $batches, $students, $paid_amount, $status;

    /**
     * @var array
     */
    protected $rules = [
        'student'     => 'required',
        'batch'       => 'required',
        'month'       => 'required',
        'paid_amount' => 'required|integer',
        'status'      => 'required',
    ];

    /**
     * @var array
     */
    protected $queryString = [
        'student' => ["except" => ""],
        'batch'   => ["except" => ""],
        'month',
    ];

    public function mount() {
        $this->batches  = Auth::user()->addedCourses()->latest()->get();
        $this->students = [];
        $this->status   = "Unpaid";

        if ( $this->batch != "" ) {
            $this->students = Course::findOrFail( $this->batch )->user->sortBy( "name" );
        }

    }

    public function add() {

        $validatedData = $this->validate();

        unset( $validatedData['batch'] );

        $validatedData['user_id']   = $this->student;
        $validatedData['course_id'] = $this->batch;

        // Format the month
        $month = "01" . "-" . $validatedData['month'];
        $month = Carbon::createFromFormat( 'd-m-Y', $month );

        $validatedData['month'] = $month;

        Account::create( $validatedData );

        return redirect()->route( "course.accounts.create", ['course' => $this->batch] )->with( "success", "Account Added Successfully" );
    }

    public function updatedBatch() {

        if ( $this->batch != "" ) {
            $this->students = Course::findOrFail( $this->batch )->user->sortBy( "name" );
        } else {
            $this->students = [];
            $this->student  = "";
            $this->batch    = "";
        }
    }

    public function updated() {
        $this->dispatchBrowserEvent( 'reInitJquery' );
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