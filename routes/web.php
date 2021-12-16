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
use App\Models\AssignmentFile;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get( '/', function () {
    return view( 'welcome' );
} );

Route::get( "/admin-reg", function () {
    return view( "auth.admin-reg" );
} )->middleware( "guest" );

Route::middleware( ['auth:sanctum', 'verified'] )->get( '/dashboard', [SystemController::class, 'dashboard'] )->name( 'dashboard' );

Route::post( "admin-reg", [UserController::class, "store_admin"] )->name( "store.admin" );

Route::middleware( ['auth:sanctum', 'verified', 'isAdmin'] )->group( function () {

    // Courses
    Route::get( "archived-courses", [CourseController::class, "archived"] )->name( "archived.course" );
    Route::post( "restore/{course}/course", [CourseController::class, "restore"] )->name( "restore.course" );
    Route::get( "course/{course}/authorization-panel", [CourseController::class, "authorization_panel"] )->name( "course.authorize" );
    Route::patch( "course/{course}/authorization-panel", [CourseController::class, "authorize_users"] )->name( "course.users.authorize" );
    Route::post( "course/{course}/reauthorize", [CourseController::class, "reauthorize_users"] )->name( "course.users.reauthorize" );
    Route::get( 'course/{course}/students', [UserController::class, "course_students"] )->name( "course.students" );

    // User
    Route::resource( 'user', UserController::class );

    // Create feed link
    Route::get( 'course/{course}/feeds/create-link', [FeedController::class, 'create_link'] )->name( "course.feeds.create-link" );
    Route::post( 'course/{course}/feeds/create-link', [FeedController::class, 'store_link'] )->name( "course.feeds.store-link" );

    // Edit feed link
    Route::get( 'feed/{feed}/edit-link', [FeedController::class, 'edit_link'] )->name( "feeds.edit-link" );
    Route::patch( 'feed/{feed}/edit-link', [FeedController::class, 'update_link'] )->name( "course.feeds.update-link" );

    // Attendance
    Route::resource( 'course.attendance', AttendanceController::class )->shallow()->except( 'index' );
    Route::get( "attendances", [AttendanceController::class, "index"] )->name( "attendances.index" );
    Route::patch( 'attendances/change', [AttendanceController::class, "change"] )->name( "attendance.change" );
    Route::get( 'attendances/individual-student', [AttendanceController::class, "individual_student"] )->name( "attendance.student-attendance" );
    Route::post( 'attendances/sms-absent-report/{parent}', [AttendanceController::class, "send_sms_absent_report"] )->name( "attendance.sms-report" );

    // Account
    Route::resource( 'course.accounts', AccountController::class )->shallow()->except( "index" );
    Route::patch( 'account/change', [AccountController::class, "change"] )->name( "account.change" );
    Route::get( 'accounts', [AccountController::class, "index"] )->name( "accounts.index" );
    Route::get( 'account/add-manually', [AccountController::class, 'create_manually'] )->name( "account.manual.create" );
    Route::get( 'account/individual-student', [AccountController::class, "individual_account"] )->name( "account.student-account" );
    Route::get( 'account/transactions', [AccountController::class, "transactions"] )->name( "account.transactions" );
    Route::post( 'account/{course}/regenerate', [AccountController::class, "regenerate"] )->name( "account.regenerate" );
    Route::post( 'account/{course}/generate-new', [AccountController::class, "regenerate_new"] )->name( "account.regenerate.new" );
    Route::post( 'account/sms-due-report/{parent}', [AccountController::class, "send_sms_due_report"] )->name( "account.sms-report" );

    // Assignment
    Route::resource( "assignments", AssignmentController::class )->shallow();

    // Assignment Responses
    Route::get( 'assessment/{assessment}/responses', [AssessmentController::class, 'responses'] )->name("assessment.responses");
    Route::patch( 'assessmnet/{assessment}/publish/all', [AssignmentResponseController::class, 'publish_all_results'] )->name("results.publish");
    Route::patch( 'assessmnet/{assessment}/unpublish/all', [AssignmentResponseController::class, 'unpublish_all_results'] )->name("results.unpublish");

    // Settings
    Route::get( "settings", [OptionController::class, 'index'] )->name( 'settings' );
    Route::patch( "settings", [OptionController::class, 'update'] )->name( 'settings.update' );

    //SMS
    Route::post( 'sms', [SMSController::class, 'send'] )->name( 'send.sms' );
    Route::get( 'all-sms', [SMSController::class, 'index'] )->name( 'sms.index' );
    Route::get( 'batch-sms', [SMSController::class, 'create_batch_sms'] )->name( 'batch.sms' );
    Route::post( 'batch-sms', [SMSController::class, 'send_batch_sms'] )->name( 'batch.sms.send' );

    // Filemanager
    Route::get( 'filemanager', function () {
        return view( "ms.filemanager.filemanager" );
    } )->name( "filemanager" );

} );

Route::middleware( ['auth:sanctum'] )->group( function () {

    // Courses
    Route::get( "my-course", [CourseController::class, "my_courses"] )->name( "my.courses" );
    Route::resource( 'course', CourseController::class );
    Route::resource( 'course.feeds', FeedController::class )->shallow();
    Route::get( "display-courses", [CourseController::class, "display"] )->name( "display.course" );
    Route::post( "course/{course}/enroll", [CourseController::class, "enroll"] )->name( "course.enroll" );

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
    Route::delete('assignment/file/{assignmentFile}/delete',[AssignmentFileController::class, 'destroy'])->name('assignment.file.destroy');

} );

// SSLCOMMERZ
Route::post( '/pay', [SslCommerzPaymentController::class, 'index'] );
Route::post( '/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax'] );

Route::post( '/success', [SslCommerzPaymentController::class, 'success'] );
Route::post( '/fail', [SslCommerzPaymentController::class, 'fail'] );
Route::post( '/cancel', [SslCommerzPaymentController::class, 'cancel'] );

Route::post( '/ipn', [SslCommerzPaymentController::class, 'ipn'] );

// Route::get('nibir-api',function(){
//     $url = "http://cecms.test/api/recharge/sms";
//     $data = Http::acceptJson()->withToken("1|PkQcQeRkrwths6VgBGbVTGQBS8qrroMXIla6ZZ7Y")->post($url,[
//         'amount' => 400
//     ]);

//     if($data->ok()){
//         dd($data->json()['status']);
//     }else{
//         dd("not okay");
//     }

// });

// Route::get('sms', function(){
//     return view("ms.sms.test");
// });
