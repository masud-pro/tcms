<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Course;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class UddoktaPayController extends Controller {

    public function pay( Request $request ) {

        // dd( $request->all() );

        $data = $request->validate( [
            'name'       => "required|string",
            'email'      => "required|email",
            'address'    => "required",
            'phone_no'   => "required",
            'amount'     => "required|integer|min:10",
            'account_id' => "required|integer",
        ] );

        $hostname = request()->getHost();
        $amount   = Account::findOrFail( $data['account_id'] )->paid_amount;

        $order = Order::create( [
            'name'       => $data['name'],
            'email'      => $data['email'],
            'phone'      => $data['phone_no'],
            'amount'     => $amount,
            'status'     => 'Pending',
            'address'    => $data['address'],
            'currency'   => "BDT",
            'user_id'    => Auth::user()->id,
            'account_id' => $data['account_id'],
        ] );

        $apiData = [
            "full_name"    => $data['name'],
            "email"        => $data['email'],
            "amount"       => $amount,
            "metadata"     => [
                "address"    => $data['address'],
                "phone_no"   => $data['phone_no'],
                "account_id" => $data['account_id'],
                "order_id"   => $order->id,
            ],
            "redirect_url" => "https://{$hostname}/payment-success",
            "cancel_url"   => "https://{$hostname}/payment-cancel",
            "webhook_url"  => env( "UDDOKTAPAY_WEBHOOK_DOMAIN" ) . "/api/uddokta-webhook",
        ];

        $response = Http::withHeaders( [
            'Content-Type'          => 'application/json',
            'RT-UDDOKTAPAY-API-KEY' => env( "UDDOKTAPAY_API_KEY" ),
        ] )
            ->asJson()
            ->withBody( json_encode( $apiData ), "JSON" )
            ->post( env( "UDDOKTAPAY_PAYMENT_DOMAIN" ) . "/api/checkout" );

        if ( $response->successful() ) {
            return redirect( $response->collect()['payment_url'] );
        } else {
            return redirect()->back()->with( "failed", "Something went wrong" );
        }

    }

    public function webhook( Request $request ) {
        $headerApi = isset( getallheaders()['UDDOKTAPAY_API_KEY'] ) ? getallheaders()['UDDOKTAPAY_API_KEY'] : null;

        if ( $headerApi == null ) {
            return response( "Api key not found", 403 );
        }

        if ( $headerApi != env( "UDDOKTAPAY_API_KEY" ) ) {
            return response( "Unauthorized Action", 403 );
        }

        $validatedData = $request->validate( [
            "full_name"           => "required|string",
            "email"               => "required|email",
            "amount"              => "required",
            "invoice_id"          => "required",
            "payment_method"      => "required|string",
            "sender_number"       => "nullable|string",
            "transaction_id"      => "required|string",
            "status"              => "required|string",
            "metadata.order_id"   => "required|integer",
            "metadata.phone_no"   => "nullable|string",
            "metadata.account_id" => "required|integer",
            "metadata.address"    => "nullable",
        ] );

        $status = $validatedData['status'] == "COMPLETED" ? "Paid" : "Unpaid";

        if ( $status != "Paid" ) {
            return;
        }

        $order = Order::findOrFail( $validatedData['metadata']['order_id'] );

        $order->update( [
            'status'          => 'Complete',
            'card_type'       => $validatedData['payment_method'],
            'store_amount'    => $validatedData['amount'],
            'currency_amount' => $validatedData['amount'],
        ] );

        $account  = Account::findOrFail( $validatedData['metadata']['account_id'] );
        $courseID = $account->course_id;
        $user_id  = $account->user_id;

        $account->update( [
            'status' => "Paid",
        ] );

        $course = Course::findOrFail( $courseID );

        $course->user()->updateExistingPivot( $user_id, [
            'is_active' => 1,
        ] );

    }

}
