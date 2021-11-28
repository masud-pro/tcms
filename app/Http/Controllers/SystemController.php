<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SystemController extends Controller {
    public function dashboard() {

        if ( Auth::user()->role == "Admin" ) {

            $allAttendances       = Attendance::whereMonth( "created_at", Carbon::now() )->get();
            $allAttendanceCount   = $allAttendances->count();
            $present              = $allAttendances->where( "attendance", 1 )->count();
            $absent               = $allAttendanceCount - $present;
            if( $allAttendanceCount > 0  ){
                $attendancePercentage = ( $present / $allAttendanceCount ) * 100;
            }else{
                $attendancePercentage = 0;
            }
            $account = Account::whereMonth( "created_at", Carbon::now() )->get();
            $courses = Course::all();

            return view( 'dashboard', [
                "courses"              => $courses,
                "reveivedPayments"     => $account->where( "status", "Paid" )->sum( "paid_amount" ),
                "duePayments"          => $account->where( "status", "Unpaid" )->sum( "paid_amount" ),
                "totalCourses"         => $courses->count(),
                "totalStudents"        => User::where( "role", "Student" )->count(),
                "absentCount"          => $absent,
                "attendancePercentage" => sprintf("%.1f",$attendancePercentage) ,
            ] );

        } else {

            $allAttendances       = Auth::user()->attendance()->whereMonth( "created_at", Carbon::today() )->get();
            $allAttendanceCount   = $allAttendances->count();
            $present              = $allAttendances->where( "attendance", 1 )->count();
            $absent               = $allAttendanceCount - $present;
            
            if( $allAttendanceCount > 0  ){
                $attendancePercentage = ( $present / $allAttendanceCount ) * 100;
            }else{
                $attendancePercentage = 0;
            }

            return view( 'dashboard', [
                "courses"              => Auth::user()->course,
                "pendingPayments"      => Auth::user()->payment()->whereMonth( "created_at", Carbon::today() )->where( "status", "Unpaid" )->count(),
                "missedAttendance"     => $absent,
                "attendancePercentage" => sprintf("%.1f",$attendancePercentage) ,
            ] );

        }

    }

}
