<?php

namespace App\Http\Livewire\Attendance;

use App\Models\Course;
use Livewire\Component;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class IndividualStudent extends Component {

    public $month;

    public $student;

    protected $queryString = [
        'month',
    ];

    public function mount() {
        $this->student = Auth::user()->id;
    }

    public function render() {

        if ( isset( $this->student ) && isset( $this->month ) && $this->student != "" ) {
            $attendances = Attendance::with( "user" )->when( $this->student, function ( $query, $student ) {
                $query->where( "user_id", $student );
            } )->when( $this->month, function ( $query, $month ) {
                $query->whereMonth( "date", $month );
            } )->get();
        } else {
            $attendances = [];
        }

        return view( 'livewire.attendance.individual-student',[
            'attendances' => $attendances
        ] );
    }

}
