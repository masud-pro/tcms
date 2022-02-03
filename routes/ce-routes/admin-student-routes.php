<?php 

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AssignmentFileController;
use App\Http\Controllers\AssignmentResponseController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\SMSController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\UserController;
use App\Models\Option;
use Illuminate\Support\Facades\Route;


// Courses
Route::get( "my-course", [CourseController::class, "my_courses"] )->name( "my.courses" );
Route::resource( 'course', CourseController::class );
Route::resource( 'course.feeds', FeedController::class )->shallow();
Route::get( "display-courses", [CourseController::class, "display"] )->name( "display.course" );
Route::post( "course/{course}/enroll", [CourseController::class, "enroll"] )->name( "course.enroll" );
Route::get( 'course/{course}/students', [UserController::class, "course_students"] )->name( "course.students" )->middleware("canSeeStudents");

// Attendance
Route::get( 'attendance/student/individual', [AttendanceController::class, "student_individual_attendance"] )->name( "attendance.student.individual" );

// Account
Route::get( 'account/student/individual', [AccountController::class, "student_individual_account"] )->name( "account.student.individual" );
Route::get( "payment/{account}/pay", [AccountController::class, "student_pay"] )->name( "student.pay" );
Route::get( "payment/{account}/pay-offline", [AccountController::class, "student_pay_offline"] )->name( "student.pay.offline" );
Route::post( "payment/pay-offline", [AccountController::class, "student_pay_offline_store"] )->name( "student.pay.offline.store" );

// Assessment
Route::resource( "course.assessments", AssessmentController::class )->shallow();

// Assignment
Route::patch( "assignment-response.mark-as-done", [AssignmentResponseController::class, "assignment_mark_done"] )->name( "assignment.mark-done" );
Route::resource( "assignment.response", AssignmentResponseController::class )->shallow();

// Assignment FIles
Route::delete( 'assignment/file/{assignmentFile}/delete', [AssignmentFileController::class, 'destroy'] )->name( 'assignment.file.destroy' );
