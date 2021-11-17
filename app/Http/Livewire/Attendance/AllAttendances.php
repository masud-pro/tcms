<?php

namespace App\Http\Livewire\Attendance;

use App\Models\Attendance;
use App\Models\Course;
use Livewire\Component;

class AllAttendances extends Component {

    public $batch;

    public $date;

    public $batches;

    protected $queryString = [
        "date"  => ["except" => ""],
        "batch" => ["except" => ""],
    ];

    public function mount() {
        $this->batches = Course::all();
    }

    public function render() {

        if ( isset( $this->batch ) && isset( $this->date ) ) {
            // dd($this->date);
            $attendances = Attendance::with( "user" )
                ->when( $this->batch, function ( $query, $batch ) {
                    $query->where( "course_id", $batch );
                } )->when( $this->date, function ( $query, $date ) {
                $query->where( "date", $date );
            } )
                ->get();
        } else {
            $attendances = [];
        }

        return view( 'livewire.attendance.all-attendances', [
            "attendances" => $attendances,
        ] );
    }

}
