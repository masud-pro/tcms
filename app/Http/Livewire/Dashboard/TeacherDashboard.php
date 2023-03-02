<?php

namespace App\Http\Livewire\Dashboard;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Course;
use App\Models\Account;
use Livewire\Component;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class TeacherDashboard extends Component
{

    public $authUser,
        $courses,
        $total,
        $reveivedPayments,
        $revenue,
        $duePayments,
        $expense,
        $totalCourses,
        $totalStudents,
        $studentWithBatch,
        $inActiveUsers,
        $attendancePercentage,
        $emoji,
        $courseView;

    public function mount()
    {
        $this->authUser = Auth::user()->hasRole(['Teacher']);

        $allAttendances     = Attendance::select('attendance')->whereMonth("created_at", Carbon::now())->get();
        $allAttendanceCount = $allAttendances->count();
        $present            = $allAttendances->where("attendance", 1)->count();

        if ($allAttendanceCount > 0) {
            $attendancePercentage = ($present / $allAttendanceCount) * 100;
        } else {
            $attendancePercentage = 0;
        }

        $allAccounts      = Account::whereMonth("created_at", Carbon::now())->get();
        $duePayments      = $allAccounts->where("status", "Unpaid")->sum("paid_amount");
        $pending          = $allAccounts->where("status", "Pending")->sum("paid_amount");
        $netIncome        = $allAccounts->where('status', 'Revenue')->sum("paid_amount");
        $courses          = Course::with("user")->get();


        $this->courses              = Course::with("user")->get();
        $this->reveivedPayments     = $allAccounts->where("status", "Paid")->sum("paid_amount");
        $this->expense              = $allAccounts->where('status', 'Expense')->sum("paid_amount");;
        $this->revenue              = $this->total - $this->expense;
        $this->total                = $netIncome + $this->reveivedPayments;
        $this->duePayments          = $duePayments + $pending;
        $this->totalCourses         = $courses->count();
        $this->totalStudents        =  User::where("role", "Student")->count();
        $this->studentWithBatch     =  User::where("role", "Student")->has("course")->count();
        $this->inActiveUsers        = User::whereRole("Student")->where("is_active", 0)->count();
        $this->attendancePercentage = sprintf("%.1f", $attendancePercentage);
        $this->emoji                = getTeacherSetting('emoji_visibility')->value;
        $this->courseView           = getTeacherSetting('dashboard_course_view')->value;;
    }


    public function render()
    {
        return view('livewire.dashboard.teacher-dashboard');
    }
}