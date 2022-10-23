<?php

namespace App\Http\Livewire\Attendance;

use App\Models\Course;
use Livewire\Component;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttendanceIndividualStudentExport;

class StudentAttendance extends Component {

    public $batch;

    public $month;

    public $student;

    public $batches;

    public $students;

    protected $queryString = [
        'student' => ["except" => ""],
        'batch'   => ["except" => ""],
        'month',
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
            $this->student  = "";
            $this->batch    = "";
        }

    }

         
    public function downloadPDF() {
        return Excel::download(new AttendanceIndividualStudentExport($this->student, $this->month), 'Attendance - ' . $this->month . '.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }

    public function render() {

        if ( isset( $this->student ) && isset( $this->batch ) && isset( $this->month ) && $this->student != "" ) {
            $attendances = Attendance::with( "user" )->when( $this->student, function ( $query, $student ) {
                $query->where( "user_id", $student );
            } )->when( $this->month, function ( $query, $month ) {
                $query->whereMonth( "date", $month );
            } )->get();
        } else {
            $attendances = [];
        }

        return view( 'livewire.attendance.student-attendance', [
            "attendances" => $attendances,
        ] );
    }

}
