<?php

namespace App\Http\Livewire\Dashboard;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class StudentDashboard extends Component {

    /**
     * @var mixed
     */
    public $courses,
    $pendingPayments,
    $missedAttendance,
    $attendancePercentage,
        $emoji;

    public function mount() {
        $allAttendances     = Auth::user()->attendance()->select( 'attendance' )->whereMonth( "created_at", Carbon::today() )->get();
        $allAttendanceCount = $allAttendances->count();
        $present            = $allAttendances->where( "attendance", 1 )->count();
        $absent             = $allAttendanceCount - $present;
        // dd(getTeacherSetting('emoji_visibility'));
        // $emoji              = getTeacherSetting('emoji_visibility')->value;

        if ( $allAttendanceCount > 0 ) {
            $attendancePercentage = ( $present / $allAttendanceCount ) * 100;
        } else {
            $attendancePercentage = 0;
        }

        $this->courses              = Auth::user()->course;
        $this->pendingPayments      = Auth::user()->payment()->select( 'status' )->where( "status", "Unpaid" )->count();
        $this->missedAttendance     = $allAttendanceCount - $present;
        $this->attendancePercentage = sprintf( "%.1f", $attendancePercentage );
        // $this->emoji                = getTeacherSetting('emoji_visibility')->value;

    }

    public function render() {
        return view( 'livewire.dashboard.student-dashboard' );
    }
}