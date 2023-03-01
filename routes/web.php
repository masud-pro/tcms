<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\AmarpayController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\UddoktaPayController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\SslCommerzPaymentController;

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
    $user = getSubdomainUser();

    if ( $user ) {
        $frontPageImage = getTeacherSetting( 'front_page_image', $user )->value;
        $fontColor      = getTeacherSetting( 'front_page_font_color', $user )->value;
    } else {
        $fontColor      = 'dark';
        $frontPageImage = 0;
    };

    return view( 'welcome', [
        "frontPageImage" => $frontPageImage,
        "fontColor"      => $fontColor,
        "teacher"        => $user,
    ] );
} );

Route::get( "/admin-reg", function () {
    return view( "auth.admin-reg" );
} )->middleware( "guest" );

Route::post( "admin-reg", [UserController::class, "store_admin"] )->name( "store.admin" );

Route::middleware( ['auth:sanctum', 'verified', 'check_subdomain'] )->get( '/dashboard', [SystemController::class, 'dashboard'] )->name( 'dashboard' );

Route::middleware( ['auth:sanctum', 'verified', 'check_subdomain'] )->group( function () {

    // Linking admin routes
    if ( file_exists( __DIR__ . "/ce-routes/admin-routes.php" ) ) {
        require_once __DIR__ . "/ce-routes/admin-routes.php";
    } else {
        echo "Ooops!! Admin Route Files Not Found!";
    }

    // Linking options routes
    if ( file_exists( __DIR__ . "/ce-routes/option-routes.php" ) ) {
        require_once __DIR__ . "/ce-routes/option-routes.php";
    } else {
        echo "Ooops!! Option Route Files Not Found!";
    }

    //

    Route::resource( 'administrator', AdministratorController::class );

    Route::resource( 'role', UserRoleController::class );
    Route::resource( 'subscription', SubscriptionController::class );
    Route::resource( 'subscriber', SubscriberController::class );

    Route::get( 'subscriber-transaction', [SubscriberController::class, 'subscriberTransaction'] )->name( 'subscriber.transaction' );
    Route::get( 'subscriber-renew', [SubscriberController::class, 'subscriberSubscriptionRenew'] )->name( 'subscriber.subscription.renew' );

    Route::get( 'permission', [UserRoleController::class, 'rolePermission'] )->name( 'role.permission' );

} );

Route::middleware( ['auth:sanctum'] )->group( function () {

// Linking all user routes
    if ( file_exists( __DIR__ . "/ce-routes/admin-student-routes.php" ) ) {
        require_once __DIR__ . "/ce-routes/admin-student-routes.php";
    } else {
        echo "Ooops!! All Users Route Files Not Found!";
    }

} );

// SSLCOMMERZ
Route::view( '/example', 'exampleHosted' );
Route::post( '/pay', [SslCommerzPaymentController::class, 'index'] );

Route::post( '/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax'] );

Route::post( '/success', [SslCommerzPaymentController::class, 'success'] );
Route::post( '/subscription/success', [SslCommerzPaymentController::class, 'subscription_success'] );

Route::post( '/fail', [SslCommerzPaymentController::class, 'fail'] );
Route::post( '/subscription/failed', [SslCommerzPaymentController::class, 'subscription_fail'] );

Route::post( '/cancel', [SslCommerzPaymentController::class, 'cancel'] );
Route::post( '/subscription/cancel', [SslCommerzPaymentController::class, 'subscription_cancel'] );

// SMS Payment
Route::post( '/sms/success', [SslCommerzPaymentController::class, 'sms_success'] );
Route::post( '/sms/failed', [SslCommerzPaymentController::class, 'sms_fail'] );
Route::post( '/sms/cancel', [SslCommerzPaymentController::class, 'sms_cancel'] );

// Subscription Renew Payment
Route::post( '/renew/success', [SslCommerzPaymentController::class, 'renew_success'] );
Route::post( '/renew/failed', [SslCommerzPaymentController::class, 'renew_fail'] );
Route::post( '/renew/cancel', [SslCommerzPaymentController::class, 'renew_cancel'] );

Route::post( '/ipn', [SslCommerzPaymentController::class, 'ipn'] );

// Uddoktapay
Route::post( "uddokta-pay", [UddoktaPayController::class, "pay"] );

// Payment
Route::view( "payment-success", "ms.payment-gateway.success" )->name( 'payment.success' );
Route::view( "payment-cancel", "ms.payment-gateway.cancelled" )->name( 'payment.fail' );

// Amar Pay
Route::get( 'amarpay-payment', [AmarpayController::class, 'index'] );
Route::post( "aamarpay-success", [AmarpayController::class, 'success'] )->name( 'aamarpay.success' );
Route::post( "aamarpay-fail", [AmarpayController::class, 'fail'] )->name( 'aamarpay.fail' );

//

Route::middleware( ['auth:sanctum'] )->group( function () {

    // Route::resource( 'role', UserRoleController::class );
    // Route::resource( 'subscription', SubscriptionController::class );
    // Route::resource( 'subscriber', SubscriberController::class );
    // Route::get( 'permission', [UserRoleController::class, 'rolePermission'] )->name( 'role.permission' );

    Route::group( ['middleware' => ['role:Super Admin']], function () {
        Route::resource( 'role', UserRoleController::class );
        Route::resource( 'subscription', SubscriptionController::class );
        Route::resource( 'subscriber', SubscriberController::class );
        Route::get( 'permission', [UserRoleController::class, 'rolePermission'] )->name( 'role.permission' );
    } );

    Route::get( 'subscriber-transaction', [SubscriberController::class, 'subscriberTransaction'] )->name( 'subscriber.transaction' );
    Route::get( 'subscriber-renew', [SubscriberController::class, 'subscriberSubscriptionRenew'] )->name( 'subscriber.subscription.renew' );

} );

// Route::get('sms', function(){

//     return view("ms.sms.test");
// });

// Route::get( 'nibs', function () {
//     dd( Course::with( ['students'] )->toArray() );
// } );

// Route::get( 'nibir', function () {
//     return Role::findByName( 'Teacher' )->permissions;
// } )->middleware( 'check_access:create.courses' );

Route::get( 'clear', function () {
    Artisan::call( 'view:clear' );
    Artisan::call( 'route:clear' );
    // Artisan::call( 'optimize:clear' );
    Artisan::call( 'cache:clear' );
    Artisan::call( 'config:clear' );
    // session()->forget();
    // session()->flush();
    return "<h4> Everything cache clear </h4>";
} );

// Route::view('test-sms', 'ms.sms.test');
//

// Route::get('test-traits', [TestController::class, 'index']);

Route::get( 'teacher-register', [SystemController::class, 'teacherRegister'] )->name( 'teacher.register' )->middleware( 'guest' );
