<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\Option;
use App\Models\SMS;
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
            $students       = $course->user;
            $newAttendances = [];

            foreach ( $students as $student ) {

                if ( $student->is_active == 1 ) {
                    $newAttendances[] = [
                        'user_id'    => $student->id,
                        'course_id'  => $course->id,
                        'attendance' => false,
                        'date'       => Carbon::today(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }

            }

            Attendance::insert( $newAttendances );

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
        return view( "ms.attendances.student-individual-attendance" );
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

    public function get_phone_numbers( $column, $course ) {

        $attendances = Attendance::where( "course_id", $course )->where( "date", Carbon::today() )->where( "attendance", 0 )->get();
        $numbers     = [];

        foreach ( $attendances as $attendance ) {
            $attendance->user->$column;

            if ( $attendance->user->$column ) {
                $numbers[] = $attendance->user->$column;
            }

        }

        return $numbers;
    }

    public function send_sms_absent_report( Request $request, $parent ) {

        if ( $parent == "father" ) {
            $numbers = $this->get_phone_numbers( "fathers_phone_no", $request->course_id );

        } elseif ( $parent == "mother" ) {
            $numbers = $this->get_phone_numbers( "mothers_phone_no", $request->course_id );
        }

        $numberCount = count( $numbers );

        $smsrow        = Option::where( "slug", "remaining_sms" )->first();
        $remaining_sms = (int) $smsrow->value;

        if ( $remaining_sms < $numberCount ) {
            return redirect()->back()->with( "failed", "Not Enough SMS" );
        }

        if ( $numberCount > 0 ) {
            $numbers = implode( ",", $numbers );
            $message = "Your child is absent today - Date: " . Carbon::today()->format( "d-M-Y" ) . " - " . env( "APP_NAME" );

            $status = SMSController::send_sms( $numbers, $message );

            if ( $status ) {

                $remaining_sms = $remaining_sms - $numberCount;

                SMS::create( [
                    'for'       => "Attendance Report",
                    'course_id' => $request->course_id,
                    'count'     => $numberCount,
                    'message'   => $message,
                ] );

                $smsrow->update( [
                    'value' => $remaining_sms,
                ] );

                return redirect()->back()->with( "success", "All guardian reported successfully" );
            } else {
                return redirect()->back()->with( "failed", "Report failed for unknown reasosns, Check all studnets phone no is correct or not!" );
            }

        } else {
            return redirect()->back()->with( "failed", "Numbers not found, everyone may be present" );
        }

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
