<?php

namespace App\Http\Livewire\Dashboard;

use Carbon\Carbon;
use App\Models\Account;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TeacherDashboard extends Component {

    /**
     * @var mixed
     */

    public $isHavePendingPayment, $pendingUrl, $isHaveInActiveUsers, $isHaveDuePayment;
    /**
     * @var mixed
     */
    public $authUser, $courses, $total, $reveivedPayments, $revenue, $duePayments, $expense, $totalCourses, $totalStudents, $studentWithBatch, $inActiveUsers, $attendancePercentage, $emoji, $courseView, $PendingPayments;

    public function mount() {

        $user = Auth::user();

        $countPendingPayment = $user->students()->whereHas( 'payment', function ( $query ) {
            $query->where( 'status', 'Pending' );
        } )->get();

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

        $allAccounts = Account::whereHas( 'user', function ( $query ) use ( $user ) {
            $query->where( 'teacher_id', $user->id );
        } )->get();

        $duePayments = $allAccounts->where( "status", "Unpaid" )->sum( "paid_amount" );
        $pending     = $allAccounts->where( "status", "Pending" )->sum( "paid_amount" );
        $netIncome   = Account::where( 'user_id', $user->id )->where( 'status', 'Revenue' )->sum( "paid_amount" );

        $this->reveivedPayments     = $allAccounts->where( "status", "Paid" )->sum( "paid_amount" );
        $this->expense              = Account::where( 'user_id', $user->id )->where( 'status', 'Expense' )->sum( "paid_amount" );
        $this->total                = $netIncome + $this->reveivedPayments;
        $this->revenue              = $this->total - $this->expense;
        $this->duePayments          = $duePayments + $pending;
        $this->totalCourses         = $user->addedCourses()->count();
        $this->totalStudents        = $user->students()->count();
        $this->studentWithBatch     = $user->students()->has( "course" )->count();
        $this->inActiveUsers        = $user->students()->where( "is_active", 0 )->count();
        $this->attendancePercentage = sprintf( "%.1f", $attendancePercentage );
        $this->courseView           = getTeacherSetting( 'dashboard_course_view' )->value;
        $this->PendingPayments      = $countPendingPayment->count();
        $this->pendingUrl           = "/all-batch-accounts?status=Pending";

        $this->isHavePendingPayment = $this->PendingPayments > 0 ? true : false;

        // if ( $this->PendingPayments > 0 ) {
        //     $this->isHavePendingPayment = true;
        // } else {
        //     $this->isHavePendingPayment = false;
        // }

//        dd( $allAccounts->where( "status", "Paid" )->sum( "paid_amount" ) );

        $this->isHaveInActiveUsers = $this->inActiveUsers > 0 ? true : false;

        $this->isHaveDuePayment = $this->duePayments === 0 ? false : true;

    }

    public function render() {
        return view( 'livewire.dashboard.teacher-dashboard' );
    }
}