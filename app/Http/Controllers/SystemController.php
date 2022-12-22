<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Course;
use App\Models\Option;
use App\Models\Account;
use App\Models\Setting;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class SystemController extends Controller {

    public function dashboard() {

        if ( Auth::user()->hasRole( ['Teacher', 'Super Admin'] ) ) {

            $allAttendances     = Attendance::select( 'attendance' )->whereMonth( "created_at", Carbon::now() )->get();
            $allAttendanceCount = $allAttendances->count();
            $present            = $allAttendances->where( "attendance", 1 )->count();
            // $absent             = $allAttendanceCount - $present;
            $emoji = Option::where( "slug", "emoji_visibility" )->first()->value;

            if ( $allAttendanceCount > 0 ) {
                $attendancePercentage = ( $present / $allAttendanceCount ) * 100;
            } else {
                $attendancePercentage = 0;
            }

            $allAccounts      = Account::whereMonth( "created_at", Carbon::now() )->get();
            $reveivedPayments = $allAccounts->where( "status", "Paid" )->sum( "paid_amount" );
            $duePayments      = $allAccounts->where( "status", "Unpaid" )->sum( "paid_amount" );
            $pending          = $allAccounts->where( "status", "Pending" )->sum( "paid_amount" );
            $due              = $duePayments + $pending;
            $netIncome        = $allAccounts->where( 'status', 'Revenue' )->sum( "paid_amount" );
            $expense          = $allAccounts->where( 'status', 'Expense' )->sum( "paid_amount" );
            $total            = $netIncome + $reveivedPayments;
            $revenue          = $total - $expense;
            $courses          = Course::with( "user" )->get();

            $optionId   = Option::where( "slug", "dashboard_course_view" )->pluck( 'id' );
            $courseView = Setting::where( 'user_id', Auth::user()->id )->where( 'option_id', $optionId )->first()['value'] ?? Option::where( "slug", "dashboard_course_view" )->first()['value'];

            return view( 'dashboard', [
                "courses"              => $courses,
                "total"                => $total,
                "reveivedPayments"     => $reveivedPayments,
                "revenue"              => $revenue,
                "duePayments"          => $due,
                "expense"              => $expense,
                "totalCourses"         => $courses->count(),
                "totalStudents"        => User::where( "role", "Student" )->count(),
                "studentWithBatch"     => User::where( "role", "Student" )->has( "course" )->count(),
                "inActiveUsers"        => User::whereRole( "Student" )->where( "is_active", 0 )->count(),
                "attendancePercentage" => sprintf( "%.1f", $attendancePercentage ),
                "emoji"                => $emoji,
                "courseView"           => $courseView,
            ] );

        } else {

            $allAttendances     = Auth::user()->attendance()->select( 'attendance' )->whereMonth( "created_at", Carbon::today() )->get();
            $allAttendanceCount = $allAttendances->count();
            $present            = $allAttendances->where( "attendance", 1 )->count();
            $absent             = $allAttendanceCount - $present;
            $emoji              = Option::where( "slug", "emoji_visibility" )->first()->value;

            if ( $allAttendanceCount > 0 ) {
                $attendancePercentage = ( $present / $allAttendanceCount ) * 100;
            } else {
                $attendancePercentage = 0;
            }

            return view( 'dashboard', [
                "courses"              => Auth::user()->course,
                "pendingPayments"      => Auth::user()->payment()->select( 'status' )->whereMonth( "created_at", Carbon::today() )->where( "status", "Unpaid" )->count(),
                "missedAttendance"     => $absent,
                "attendancePercentage" => sprintf( "%.1f", $attendancePercentage ),
                "emoji"                => $emoji,
            ] );

        }

    }

}
