<?php

use App\Models\Course;
use App\Models\Option;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\AmarpayController;
use App\Http\Controllers\UddoktaPayController;
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
    $frontPageImage = Option::where( "slug", "front_page_image" )->first()->value;
    $fontColor      = Option::where( "slug", "front_page_font_color" )->first()->value;

    return view( 'welcome', [
        "frontPageImage" => $frontPageImage,
        "fontColor"      => $fontColor,
    ] );
} );

Route::get( "/admin-reg", function () {
    return view( "auth.admin-reg" );
} )->middleware( "guest" );

Route::middleware( ['auth:sanctum', 'verified'] )->get( '/dashboard', [SystemController::class, 'dashboard'] )->name( 'dashboard' );

Route::post( "admin-reg", [UserController::class, "store_admin"] )->name( "store.admin" );

Route::middleware( ['auth:sanctum', 'verified', 'isAdmin'] )->group( function () {

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
Route::post( '/pay', [SslCommerzPaymentController::class, 'index'] );
Route::post( '/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax'] );

Route::post( '/success', [SslCommerzPaymentController::class, 'success'] );
Route::post( '/fail', [SslCommerzPaymentController::class, 'fail'] );
Route::post( '/cancel', [SslCommerzPaymentController::class, 'cancel'] );

Route::post( '/ipn', [SslCommerzPaymentController::class, 'ipn'] );

// Uddoktapay
Route::post( "uddokta-pay", [UddoktaPayController::class, "pay"] );

// Payment
Route::view( "payment-success", "ms.payment-gateway.success" )->name('payment.success');
Route::view( "payment-cancel", "ms.payment-gateway.cancelled" )->name('payment.fail');



// Amar Pay
Route::get('amarpay-payment', [ AmarpayController::class, 'index' ]);
Route::post( "aamarpay-success", [ AmarpayController::class, 'success' ] )->name('aamarpay.success');
Route::post( "aamarpay-fail", [ AmarpayController::class, 'fail' ] )->name('aamarpay.fail');



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

Route::get('nibs', function(){
    dd(Course::with(['students'])->toArray());
});


Route::resource('administrator', AdministratorController::class);







// Route::get('test', function(){});






// 