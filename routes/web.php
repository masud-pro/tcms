<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\UserController;
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

    Route::get( "archived-courses", [CourseController::class, "archived"] )->name( "archived.course" );
    Route::post( "restore/{course}/course", [CourseController::class, "restore"] )->name( "restore.course" );
    Route::get( "course/{course}/authorization-panel", [CourseController::class, "authorization_panel"] )->name( "course.authorize" );
    Route::patch( "course/{course}/authorization-panel", [CourseController::class, "authorize_users"] )->name( "course.users.authorize" );
    Route::post( "course/{course}/reauthorize", [CourseController::class, "reauthorize_users"] )->name( "course.users.reauthorize" );

    Route::resource( 'user', UserController::class );

    //create feed link
    Route::get( 'course/{course}/feeds/create-link', [FeedController::class, 'create_link'] )->name( "course.feeds.create-link" );
    Route::post( 'course/{course}/feeds/create-link', [FeedController::class, 'store_link'] )->name( "course.feeds.store-link" );

    // edit feed link
    Route::get( 'feed/{feed}/edit-link', [FeedController::class, 'edit_link'] )->name( "feeds.edit-link" );
    Route::patch( 'feed/{feed}/edit-link', [FeedController::class, 'update_link'] )->name( "course.feeds.update-link" );

    Route::get( 'course/{course}/students', [UserController::class, "course_students"] )->name( "course.students" );

    Route::resource( 'course.attendance', AttendanceController::class )->shallow()->except( 'index' );
    Route::get( "attendances", [AttendanceController::class, "index"] )->name( "attendances.index" );
    Route::patch( 'attendances/change', [AttendanceController::class, "change"] )->name( "attendance.change" );
    Route::get( 'attendances/individual-student', [AttendanceController::class, "individual_student"] )->name( "attendance.student-attendance" );

    Route::resource( 'course.accounts', AccountController::class )->shallow()->except( "index" );
    Route::patch( 'account/change', [AccountController::class, "change"] )->name( "account.change" );
    Route::get( 'accounts', [AccountController::class, "index"] )->name( "accounts.index" );
    Route::get( 'account/add-manually', [AccountController::class, 'create_manually'] )->name( "account.manual.create" );
    Route::get( 'account/individual-student', [AccountController::class, "individual_account"] )->name( "account.student-account" );
    Route::get( 'account/transactions', [AccountController::class, "transactions"] )->name( "account.transactions" );

} );

Route::middleware( ['auth:sanctum'] )->group( function () {
    Route::get( "my-course", [CourseController::class, "my_courses"] )->name( "my.courses" );
    Route::resource( 'course', CourseController::class );
    Route::resource( 'course.feeds', FeedController::class )->shallow();
    Route::get( "display-courses", [CourseController::class, "display"] )->name( "display.course" );
    Route::post( "course/{course}/enroll", [CourseController::class, "enroll"] )->name( "course.enroll" );


    Route::get( 'attendance/student/individual', [AttendanceController::class, "student_individual_attendance"] )->name( "attendance.student.individual" );
    Route::get( 'account/student/individual', [AccountController::class, "student_individual_account"] )->name( "account.student.individual" );
    Route::get( "payment/{account}/pay", [AccountController::class, "student_pay"] )->name( "student.pay" );
} );

// SSLCOMMERZ Start
// Route::get( '/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout'] );
Route::get( '/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout'] );

Route::post( '/pay', [SslCommerzPaymentController::class, 'index'] );
Route::post( '/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax'] );

Route::post( '/success', [SslCommerzPaymentController::class, 'success'] );
Route::post( '/fail', [SslCommerzPaymentController::class, 'fail'] );
Route::post( '/cancel', [SslCommerzPaymentController::class, 'cancel'] );

Route::post( '/ipn', [SslCommerzPaymentController::class, 'ipn'] );
//SSLCOMMERZ END
