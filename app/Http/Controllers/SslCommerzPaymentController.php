<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Course;
use App\Models\Account;
use App\Models\AdminAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Library\SslCommerz\SslCommerzNotification;

class SslCommerzPaymentController extends Controller {

    public function exampleEasyCheckout() {
        return view( 'exampleEasycheckout' );
    }

    public function exampleHostedCheckout() {
        return view( 'exampleHosted' );
    }

    public function index( Request $request ) {

        // $data = $request->validate( [
        //     'name'       => "required|string",
        //     'email'      => "required|email",
        //     'address'    => "required",
        //     'phone_no'   => "required",
        //     'amount'     => "required|integer|min:10",
        //     'account_id' => "required|integer",
        // ] );

        # Here you have to receive all the order data to initiate the payment.

        # Let's say, your oder transaction information's are saving in a table called "orders"
        # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data                 = array();
        $post_data['total_amount'] = 10; # You cant not pay less than 10
        $post_data['currency']     = "BDT";
        $post_data['tran_id']      = md5( uniqid() );

        // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name']     = 'asd';
        $post_data['cus_email']    = 'asd';
        $post_data['cus_add1']     = 'asd';
        $post_data['cus_add2']     = "";
        $post_data['cus_city']     = "";
        $post_data['cus_state']    = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country']  = "Bangladesh";
        $post_data['cus_phone']    = 'sad';
        $post_data['cus_fax']      = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name']     = "No Shipping";
        $post_data['ship_add1']     = "Dhaka";
        $post_data['ship_add2']     = "Dhaka";
        $post_data['ship_city']     = "Dhaka";
        $post_data['ship_state']    = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone']    = "";
        $post_data['ship_country']  = "Bangladesh";

        $post_data['shipping_method']  = "NO";
        $post_data['product_name']     = "Tuition Fee";
        $post_data['product_category'] = "Fee";
        $post_data['product_profile']  = "virtual-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = 'asd';
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        #Before  going to initiate the payment order status need to insert or update as Pending.
        // $update_product = DB::table( 'orders' )
        //     ->where( 'transaction_id', $post_data['tran_id'] )
        //     ->updateOrInsert( [
        //         'name'           => $post_data['cus_name'],
        //         'email'          => $post_data['cus_email'],
        //         'phone'          => $post_data['cus_phone'],
        //         'amount'         => $post_data['total_amount'],
        //         'status'         => 'Pending',
        //         'address'        => $post_data['cus_add1'],
        //         'transaction_id' => $post_data['tran_id'],
        //         'currency'       => $post_data['currency'],
        //         'user_id'        => Auth::user()->id,
        //         'account_id'     => $data['account_id'],
        //         'created_at'     => Carbon::now(),
        //         'updated_at'     => Carbon::now(),
        //     ] );

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment( $post_data, 'hosted' );

        if ( ! is_array( $payment_options ) ) {
            print_r( $payment_options );
            $payment_options = array();
        }

    }

    public function payViaAjax( Request $request ) {

        # Here you have to receive all the order data to initate the payment.

        # Lets your oder trnsaction informations are saving in a table called "orders"
        # In orders table order uniq identity is "transaction_id","status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data                 = array();
        $post_data['total_amount'] = '10'; # You cant not pay less than 10
        $post_data['currency']     = "BDT";
        $post_data['tran_id']      = md5( uniqid() );

        // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name']     = 'Customer Name';
        $post_data['cus_email']    = 'customer@mail.com';
        $post_data['cus_add1']     = 'Customer Address';
        $post_data['cus_add2']     = "";
        $post_data['cus_city']     = "";
        $post_data['cus_state']    = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country']  = "Bangladesh";
        $post_data['cus_phone']    = '8801XXXXXXXXX';
        $post_data['cus_fax']      = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name']     = "Store Test";
        $post_data['ship_add1']     = "Dhaka";
        $post_data['ship_add2']     = "Dhaka";
        $post_data['ship_city']     = "Dhaka";
        $post_data['ship_state']    = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone']    = "";
        $post_data['ship_country']  = "Bangladesh";

        $post_data['shipping_method']  = "NO";
        $post_data['product_name']     = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile']  = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        #Before  going to initiate the payment order status need to update as Pending.
        $update_product = DB::table( 'orders' )
            ->where( 'transaction_id', $post_data['tran_id'] )
            ->updateOrInsert( [
                'name'           => $post_data['cus_name'],
                'email'          => $post_data['cus_email'],
                'phone'          => $post_data['cus_phone'],
                'amount'         => $post_data['total_amount'],
                'status'         => 'Pending',
                'address'        => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency'       => $post_data['currency'],
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ] );

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment( $post_data, 'checkout', 'json' );

        if ( ! is_array( $payment_options ) ) {
            print_r( $payment_options );
            $payment_options = array();
        }

    }

    public function success( Request $request ) {
        $account        = $request->input( 'value_a' );
        $tran_id        = $request->input( 'tran_id' );
        $amount         = $request->input( 'amount' );
        $currency       = $request->input( 'currency' );
        $cardType       = $request->input( 'card_type' );
        $storeAmount    = $request->input( 'store_amount' );
        $currencyAmount = $request->input( 'currency_amount' );

        $sslc = new SslCommerzNotification();

        #Check order status in order tabel against the transaction id or order id.
        $order_detials = DB::table( 'orders' )
            ->where( 'transaction_id', $tran_id )
            ->select( 'transaction_id', 'status', 'currency', 'amount' )->first();

        if ( $order_detials->status == 'Pending' ) {
            $validation = $sslc->orderValidate( $request->all(), $tran_id, $amount, $currency );

            if ( $validation == TRUE ) {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                 */
                $update_product = DB::table( 'orders' )
                    ->where( 'transaction_id', $tran_id )
                    ->update( [
                        'status'          => 'Complete',
                        'card_type'       => $cardType,
                        'store_amount'    => $storeAmount,
                        'currency_amount' => $currencyAmount,
                    ] );

                $account  = Account::findOrFail( $account );
                $courseID = $account->course_id;
                $user_id  = $account->user_id;
                $account->update( [
                    'status' => "Paid",
                ] );

                $course = Course::findOrFail( $courseID );

                $course->user()->updateExistingPivot( $user_id, [
                    'is_active' => 1,
                ] );
                
                return view( "ms.payment-gateway.success" );
            } else {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel and Transation validation failed.
                Here you need to update order status as Failed in order table.
                 */
                $update_product = DB::table( 'orders' )
                    ->where( 'transaction_id', $tran_id )
                    ->update( ['status' => 'Failed'] );
                // echo "validation Fail";
                return view( "ms.payment-gateway.failed" );
            }

        } else

        if ( $order_detials->status == 'Processing' || $order_detials->status == 'Complete' ) {

            /*
            That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
            */
            // echo "Transaction is successfully Completed";
            return view( "ms.payment-gateway.success" );
        } else {

            #That means something wrong happened. You can redirect customer to your product page.
            // echo "Invalid Transaction";
            return view( "ms.payment-gateway.invalid" );
        }

    }

    public function fail( Request $request ) {
        $tran_id = $request->input( 'tran_id' );

        $order_detials = DB::table( 'orders' )
            ->where( 'transaction_id', $tran_id )
            ->select( 'transaction_id', 'status', 'currency', 'amount' )->first();

        if ( $order_detials->status == 'Pending' ) {
            $update_product = DB::table( 'orders' )
                ->where( 'transaction_id', $tran_id )
                ->update( ['status' => 'Failed'] );
            // echo "Transaction is Falied";
            return view( "ms.payment-gateway.failed" );
        } else

        if ( $order_detials->status == 'Processing' || $order_detials->status == 'Complete' ) {
            // echo "Transaction is already Successful";
            return view( "ms.payment-gateway.success" );
        } else {
            // echo "Transaction is Invalid";
            return view( "ms.payment-gateway.invalid" );
        }

    }

    public function cancel( Request $request ) {
        $tran_id = $request->input( 'tran_id' );

        $order_detials = DB::table( 'orders' )
            ->where( 'transaction_id', $tran_id )
            ->select( 'transaction_id', 'status', 'currency', 'amount' )->first();

        if ( $order_detials->status == 'Pending' ) {
            $update_product = DB::table( 'orders' )
                ->where( 'transaction_id', $tran_id )
                ->update( ['status' => 'Canceled'] );
            // echo "Transaction is Cancel";
            return view( "ms.payment-gateway.cancelled" );
        } else

        if ( $order_detials->status == 'Processing' || $order_detials->status == 'Complete' ) {
            // echo "Transaction is already Successful";
            return view( "ms.payment-gateway.success" );
        } else {
            // echo "Transaction is Invalid";
            return view( "ms.payment-gateway.invalid" );
        }

    }

    public function ipn( Request $request ) {

        #Received all the payement information from the gateway
        if ( $request->input( 'tran_id' ) ) #Check transation id is posted or not. { { { { { { { { { { {
        $tran_id = $request->input( 'tran_id' );
    

        #Check order status in order tabel against the transaction id or order id.
        $order_details = DB::table( 'orders' )
            ->where( 'transaction_id', $tran_id )
            ->select( 'transaction_id', 'status', 'currency', 'amount' )->first();

        if ( $order_details->status == 'Pending' ) {
            $sslc       = new SslCommerzNotification();
            $validation = $sslc->orderValidate( $request->all(), $tran_id, $order_details->amount, $order_details->currency );

            if ( $validation == TRUE ) {
                /*
                That means IPN worked. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successful transaction to customer
                */
                $update_product = DB::table( 'orders' )
                    ->where( 'transaction_id', $tran_id )
                    ->update( ['status' => 'Processing'] );

                // echo "Transaction is successfully Completed";
                return view( "ms.payment-gateway.success" );
            } else {
                /*
                That means IPN worked, but Transation validation failed.
                Here you need to update order status as Failed in order table.
                */
                $update_product = DB::table( 'orders' )
                    ->where( 'transaction_id', $tran_id )
                    ->update( ['status' => 'Failed'] );

                // echo "validation Fail";
                return view( "ms.payment-gateway.failed" );
            }

        } else

        if ( $order_details->status == 'Processing' || $order_details->status == 'Complete' ) {

            #That means Order status already updated. No need to udate database.

            // echo "Transaction is already successfully Completed";
            return view( "ms.payment-gateway.success" );
        } else {

            #That means something wrong happened. You can redirect customer to your product page.

            // echo "Invalid Transaction";
            return view( "ms.payment-gateway.failed" );
        }

    }


    public static function subscription_payment( $request ) {
        $data = $request;
        # Here you have to receive all the order data to initiate the payment.

        # Let's say, your oder transaction information's are saving in a table called "orders"
        # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data                 = array();
        $post_data['total_amount'] = $data['amount']; # You cant not pay less than 10
        $post_data['currency']     = "BDT";
        $post_data['tran_id']      = md5( uniqid() );

        // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name']     = $data['name'];
        $post_data['cus_email']    = $data['email'];
        $post_data['cus_add1']     = $data['address'];
        $post_data['cus_add2']     = "";
        $post_data['cus_city']     = "";
        $post_data['cus_state']    = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country']  = "Bangladesh";
        $post_data['cus_phone']    = $data['phone_no'];
        $post_data['cus_fax']      = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name']     = "No Shipping";
        $post_data['ship_add1']     = "Dhaka";
        $post_data['ship_add2']     = "Dhaka";
        $post_data['ship_city']     = "Dhaka";
        $post_data['ship_state']    = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone']    = "";
        $post_data['ship_country']  = "Bangladesh";

        $post_data['shipping_method']  = "NO";
        $post_data['product_name']     = "Teacher Subscription";
        $post_data['product_category'] = "Subcription";
        $post_data['product_profile']  = "virtual-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = $data['admin_account_id'];
        $post_data['value_b'] = $data['user_id'];
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        # Before  going to initiate the payment order status need to insert or update as Pending.
        // dd($post_data);
        $sslc = new SslCommerzNotification('subscription');
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment( $post_data );

        return $payment_options;

        if ( ! is_array( $payment_options ) ) {
            print_r( $payment_options );
            $payment_options = array();
        }

    }

    public function subscription_success(Request $request){

        $admin_account_id  = $request->input( 'value_a' );
        $user_id        = $request->input( 'value_b' );
        $tran_id        = $request->input( 'tran_id' );
        $amount         = $request->input( 'amount' );
        $currency       = $request->input( 'currency' );
        $cardType       = $request->input( 'card_type' );
        $storeAmount    = $request->input( 'store_amount' );
        $currencyAmount = $request->input( 'currency_amount' );

        $sslc = new SslCommerzNotification();

        $validation = $sslc->orderValidate( $request->all(), $tran_id, $amount, $currency );

        if ( $validation == TRUE ) {
            $adminAccount = AdminAccount::find( $admin_account_id );
            $adminAccount->update( ['status' => 1] );

            $adminAccount->subscriptionUser->update( ['status' => 1] );

            $user = User::find( $user_id );

            Auth::login( $user );
            return redirect()->route( 'dashboard' );
        }else{
            return view( "ms.payment-gateway.failed" );
        }
    }

    public function subscription_fail() {
        return view( "ms.payment-gateway.failed" );
    }

    public function subscription_cancel() {
        return view( "ms.payment-gateway.cancel" );
    }


   public static function sms_payment( $request)
   {
        $data = $request;
        # Here you have to receive all the order data to initiate the payment.

        # Let's say, your oder transaction information's are saving in a table called "orders"
        # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data                 = array();
        $post_data['total_amount'] = $data['amount']; # You cant not pay less than 10
        $post_data['currency']     = "BDT";
        $post_data['tran_id']      = md5( uniqid() );

        // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name']     = $data['name'];
        $post_data['cus_email']    = $data['email'];
        $post_data['cus_add1']     = $data['address'];
        $post_data['cus_add2']     = "";
        $post_data['cus_city']     = "";
        $post_data['cus_state']    = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country']  = "Bangladesh";
        $post_data['cus_phone']    = $data['phone_no'];
        $post_data['cus_fax']      = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name']     = "No Shipping";
        $post_data['ship_add1']     = "Dhaka";
        $post_data['ship_add2']     = "Dhaka";
        $post_data['ship_city']     = "Dhaka";
        $post_data['ship_state']    = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone']    = "";
        $post_data['ship_country']  = "Bangladesh";

        $post_data['shipping_method']  = "NO";
        $post_data['product_name']     = "Teacher Buy SMS";
        $post_data['product_category'] = "Buy SMS";
        $post_data['product_profile']  = "virtual-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = $data['admin_account_id'];
        $post_data['value_b'] = $data['sms_amount'];
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        # Before  going to initiate the payment order status need to insert or update as Pending.
        // dd($post_data);

    
        $sslc = new SslCommerzNotification('sms');
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payment gateway here )
        $payment_options = $sslc->makePayment( $post_data );

        return $payment_options;

        if ( ! is_array( $payment_options ) ) {
            print_r( $payment_options );
            $payment_options = array();
        }
    
   }

   public function sms_success(Request $request){

    $admin_account_id  = $request->input( 'value_a' );
    $smsAmount         = $request->input( 'value_b' );
    $tran_id           = $request->input( 'tran_id' );
    $amount            = $request->input( 'amount' );
    $currency          = $request->input( 'currency' );
    $cardType          = $request->input( 'card_type' );
    $storeAmount       = $request->input( 'store_amount' );
    $currencyAmount    = $request->input( 'currency_amount' );

    $sslc = new SslCommerzNotification();

    $validation = $sslc->orderValidate( $request->all(), $tran_id, $amount, $currency );

    if ( $validation == TRUE ) {
        $adminAccount = AdminAccount::find( $admin_account_id );
        $adminAccount->update( ['status' => 1] );

        $user = User::find( $adminAccount->subscriptionUser->user_id  );
        Auth::login( $user );

        $setting = getTeacherSetting( 'remaining_sms' );
        $afterBuyNowSms['value'] = $setting->value + $smsAmount;
        $setting->update( $afterBuyNowSms );
        session()->flash( 'success', 'You Purchased ' . $smsAmount . ' SMS Successfully.' );
        return redirect()->route( 'sms.index' );
    }else{
        return view( "ms.payment-gateway.failed" );
    }
 }

    public function sms_fail() {        
        return view( "ms.payment-gateway.failed" );
    }

    public function sms_cancel() {
        return view( "ms.payment-gateway.cancel" );
    }


    /**
     * subscription Renew of subscriber endpoint
     * 
     * 
     */

    public static function renew_subscription_payment( $request){
        $data = $request;
        # Here you have to receive all the order data to initiate the payment.

        # Let's say, your oder transaction information's are saving in a table called "orders"
        # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data                 = array();
        $post_data['total_amount'] = $data['amount']; # You cant not pay less than 10
        $post_data['currency']     = "BDT";
        $post_data['tran_id']      = md5( uniqid() );

        // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name']     = $data['name'];
        $post_data['cus_email']    = $data['email'];
        $post_data['cus_add1']     = $data['address'];
        $post_data['cus_add2']     = "";
        $post_data['cus_city']     = "";
        $post_data['cus_state']    = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country']  = "Bangladesh";
        $post_data['cus_phone']    = $data['phone_no'];
        $post_data['cus_fax']      = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name']     = "No Shipping";
        $post_data['ship_add1']     = "Dhaka";
        $post_data['ship_add2']     = "Dhaka";
        $post_data['ship_city']     = "Dhaka";
        $post_data['ship_state']    = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone']    = "";
        $post_data['ship_country']  = "Bangladesh";

        $post_data['shipping_method']  = "NO";
        $post_data['product_name']     = "Teacher Subscription Renew";
        $post_data['product_category'] = "Subscription Renew";
        $post_data['product_profile']  = "virtual-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = $data['admin_account_id'];
        $post_data['value_b'] = $data['user_id'];
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        # Before  going to initiate the payment order status need to insert or update as Pending.
        // dd($post_data);

    
        $sslc = new SslCommerzNotification('renew');
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payment gateway here )
        $payment_options = $sslc->makePayment( $post_data );

        return $payment_options;

        if ( ! is_array( $payment_options ) ) {
            print_r( $payment_options );
            $payment_options = array();
        }
    
   }

    public function renew_success(Request $request){

        $admin_account_id  = $request->input( 'value_a' );
        $user_id           = $request->input( 'value_b' );
        $tran_id           = $request->input( 'tran_id' );
        $amount            = $request->input( 'amount' );
        $currency          = $request->input( 'currency' );
        $cardType          = $request->input( 'card_type' );
        $storeAmount       = $request->input( 'store_amount' );
        $currencyAmount    = $request->input( 'currency_amount' );

        $sslc = new SslCommerzNotification();

        $validation = $sslc->orderValidate( $request->all(), $tran_id, $amount, $currency );

        // dd( $validation );

        if ( $validation == TRUE ) {
            $adminAccount = AdminAccount::find( $admin_account_id );
            $adminAccount->update( ['status' => 1] );

            $user = User::find( $user_id  );
            Auth::login( $user );

            // $setting = getSettingValue( 'remaining_sms' );
            // $afterBuyNowSms['value'] = $setting->value + $smsAmount;
            // $setting->update( $afterBuyNowSms );
            // session()->flash( 'success', 'You Purchased ' . $smsAmount . ' SMS Successfully.' );
            return redirect()->route( 'my.transactions' );
        }else{
            return view( "ms.payment-gateway.failed" );
        }
    }

    public function renew_fail() {        
        return view( "ms.payment-gateway.failed" );
    }

    public function renew_cancel() {
        return view( "ms.payment-gateway.cancel" );
    }










































    
}