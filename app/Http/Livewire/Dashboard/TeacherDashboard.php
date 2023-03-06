<?php

namespace App\Http\Livewire\Dashboard;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TeacherDashboard extends Component {

    /**
     * @var mixed
     */
    public $authUser, $courses, $total, $reveivedPayments, $revenue, $duePayments, $expense, $totalCourses, $totalStudents, $studentWithBatch, $inActiveUsers, $attendancePercentage, $emoji, $courseView;

    public function mount() {

        $user = Auth::user();

        // $this->authUser = $user->hasRole( ['Teacher'] );

        $allAttendances = $user->students()->whereHas( 'attendance', function ( $query ) {
            $query->whereMonth( "created_at", Carbon::now() );
        } )->get();

        $allAttendanceCount = $allAttendances->count();

        $present = $user->students()->whereHas( 'attendance', function ( $query ) {
            $query->where( 'attendance', 1 )->whereMonth( "created_at", Carbon::now() );
        } )->count();

        if ( $allAttendanceCount > 0 ) {
            $attendancePercentage = ( $present / $allAttendanceCount ) * 100;
        } else {
            $attendancePercentage = 0;
        }

        $allAccounts = $user->payment()->whereMonth( "created_at", Carbon::now() )->get();
        $duePayments = $allAccounts->where( "status", "Unpaid" )->sum( "paid_amount" );
        $pending     = $allAccounts->where( "status", "Pending" )->sum( "paid_amount" );
        $netIncome   = $allAccounts->where( 'status', 'Revenue' )->sum( "paid_amount" );

        // $this->courses = Course::with( "user" )->get();
        // $student =$user->students();

        $this->reveivedPayments     = $allAccounts->where( "status", "Paid" )->sum( "paid_amount" );
        $this->expense              = $allAccounts->where( 'status', 'Expense' )->sum( "paid_amount" );
        $this->revenue              = $this->total - $this->expense;
        $this->total                = $netIncome + $this->reveivedPayments;
        $this->duePayments          = $duePayments + $pending;
        $this->totalCourses         = $user->addedCourses()->count();
        $this->totalStudents        = $user->students()->count();
        $this->studentWithBatch     = $user->students()->has( "course" )->count();
        $this->inActiveUsers        = $user->students()->where( "is_active", 0 )->count();
        $this->attendancePercentage = sprintf( "%.1f", $attendancePercentage );
        $this->courseView           = getTeacherSetting( 'dashboard_course_view' )->value;
    }

    public function render() {
        return view( 'livewire.dashboard.teacher-dashboard' );
    }
}
