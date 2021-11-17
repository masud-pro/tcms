<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        // dd("Hit korse");
        return view( "ms.attendances.all-attendances" );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( Course $course ) {

        $attendances = Attendance::whereDate( "date", Carbon::today() )->where( "course_id", $course->id )->get();

        if ( $attendances->count() <= 0 ) {
            $students = $course->user;

            foreach ( $students as $student ) {
                Attendance::create( [
                    'user_id'    => $student->id,
                    'course_id'  => $course->id,
                    'attendance' => false,
                    'date'       => Carbon::today(),
                ] );
            }

            return view( "ms.attendances.attendance-index", [
                "attendances" => Attendance::whereDate( "date", Carbon::today() )
                    ->where( "course_id", $course->id )
                    ->get(),
            ] );
        } else {
            return view( "ms.attendances.attendance-index", [
                "attendances" => $attendances,
            ] );
        }

    }

    public function student_individual_attendance() {
        // dd("Hit korse");
        return view("ms.attendances.student-individual-attendance");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show( Attendance $attendance ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit( Attendance $attendance ) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, Attendance $attendance ) {
        //
    }

    public function individual_student() {
        return view( "ms.attendances.student-attendance" );
    }

    public function change( Request $request ) {
        $data = $request->validate( [
            "ids"        => "required|array",
            "attendance" => "nullable|array",
        ] );

        if ( isset( $data['attendance'] ) ) {
            $present = $data['attendance'];
            $absent  = array_diff( $data['ids'], $data['attendance'] );

            Attendance::whereIn( "id", $present )->update( ["attendance" => 1] );
            Attendance::whereIn( "id", $absent )->update( ["attendance" => 0] );

        } else {
            Attendance::whereIn( "id", $data["ids"] )->update( ["attendance" => 0] );
        }

        return redirect()->back()->with( "success", "Attendance updated successfully" );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy( Attendance $attendance ) {
        //
    }

}
