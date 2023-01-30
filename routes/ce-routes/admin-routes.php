<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SMSController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\AssignmentResponseController;

// Courses
Route::get( "archived-courses", [CourseController::class, "archived"] )->name( "archived.course" );
Route::post( "restore/{course}/course", [CourseController::class, "restore"] )->name( "restore.course" );
Route::get( "course/{course}/authorization-panel", [CourseController::class, "authorization_panel"] )->name( "course.authorize" );
Route::patch( "course/{course}/authorization-panel", [CourseController::class, "authorize_users"] )->name( "course.users.authorize" );
Route::post( "course/{course}/reauthorize", [CourseController::class, "reauthorize_users"] )->name( "course.users.reauthorize" );
Route::get( "reauthorize-all", [CourseController::class, "reauthorize_all"] )->name( "reauthorize.all" );

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
Route::get( 'account/transactions', [AccountController::class, "transactions"] )->name( "student.transactions" );
Route::post( 'account/{course}/regenerate', [AccountController::class, "regenerate"] )->name( "account.regenerate" );
Route::post( 'account/{course}/generate-new', [AccountController::class, "regenerate_new"] )->name( "account.regenerate.new" );
Route::post( 'account/sms-due-report/{parent}', [AccountController::class, "send_sms_due_report"] )->name( "account.sms-report" );
Route::post( 'account/update-and-reauth', [AccountController::class, "change_and_reauthorize"] )->name( "account.update-and-reauth" );
Route::get( 'account/overall-accounts', [AccountController::class, "overall_account"] )->name( "account.overall-account" );
Route::get( 'account/{account}/mark-unpaid', [AccountController::class, "mark_unpaid"] )->name( "account.mark-unpaid" );
Route::get( 'generate-payments', [AccountController::class, "generate_all_payments"] )->name( "payments.generate" ); // Generate all payments
Route::get( 'regenerate-all', [AccountController::class, "regenerate_all"] )->name( "payments.regenerate-all" );
Route::get( 'all-batch-accounts', [AccountController::class, "all_batch_accounts"] )->name( "account.all-batch-accounts" );

// Assignment
Route::resource( "assignments", AssignmentController::class )->shallow();

// Assignment Responses
Route::get( 'assessment/{assessment}/responses', [AssessmentController::class, 'responses'] )->name( "assessment.responses" );
Route::patch( 'assessmnet/{assessment}/publish/all', [AssignmentResponseController::class, 'publish_all_results'] )->name( "results.publish" );
Route::patch( 'assessmnet/{assessment}/unpublish/all', [AssignmentResponseController::class, 'unpublish_all_results'] )->name( "results.unpublish" );

// Settings
Route::get( "settings", [OptionController::class, 'index'] )->name( 'settings' );
Route::get( "settings/course-payment-generate-options", [OptionController::class, 'course_payment_generate_options'] )->name( 'settings.generate-course-payments' );
Route::post( "settings/course-payment-generate-options", [OptionController::class, 'change_course_generate_payments'] )->name( 'settings.change-course-generate-payments' );
Route::patch( "settings", [OptionController::class, 'update'] )->name( 'settings.update' );

//SMS
Route::post( 'sms', [SMSController::class, 'send'] )->name( 'send.sms' );
Route::get( 'all-sms', [SMSController::class, 'index'] )->name( 'sms.index' );
Route::get( 'batch-sms', [SMSController::class, 'create_batch_sms'] )->name( 'sms.batch' );
Route::post( 'batch-sms', [SMSController::class, 'send_batch_sms'] )->name( 'batch.sms.send' );
Route::post( 'send/results', [SMSController::class, 'send_exam_results'] )->name( 'exam.result.sms' );
Route::post( 'send-all-absent-sms,{send_to}', [AccountController::class, 'all_students_account_sms'] )->name( 'send.all.student.account.sms' );

// Filemanager
Route::get( 'filemanager', function () {
    if(!isSuperAdmin()){
        return view( "ms.filemanager.user-filemanager" );
    }
    return view( "ms.filemanager.filemanager" );
} )->name( "filemanager" )->middleware('check_access:file_manager.individual_teacher');

// Own Account Transaction
Route::get( 'my-transactions', [SubscriberController::class, 'subscriberOwnTransaction'] )->name( 'my.transactions' );

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
