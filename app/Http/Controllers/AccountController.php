<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Course;
use App\Models\Option;
use App\Models\Order;
use App\Models\SMS;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view( "ms.account.all-accounts" );
    }

    public function student_pay( Account $account ) {

        $this->authorize( "view", $account );

        return view( "ms.account.pay", [
            'account' => $account,
        ] );
    }

    public function regenerate( Course $course ) {

        $students = $course->user;

        foreach ( $students as $student ) {

            if ( $student->is_active == 1 ) {

                $account = Account::whereMonth( "month", Carbon::now() )
                    ->where( "user_id", $student->id )
                    ->where( "course_id", $course->id )
                    ->count();

                if ( $account == 0 ) {
                    Account::create( [
                        'user_id'     => $student->id,
                        'course_id'   => $course->id,
                        'paid_amount' => $student->waiver ? $course->fee - $student->waiver : $course->fee,
                        'status'      => "Unpaid",
                        'month'       => Carbon::today(),
                    ] );
                }

            }

        }

        return redirect()->back()->with( "success", "Regenerated Successfully" );

    }

    public function regenerate_new( Course $course ) {

        Account::whereMonth( "month", Carbon::now() )->delete();

        $students = $course->user;

        foreach ( $students as $student ) {

            if ( $student->is_active == 1 ) {
                Account::create( [
                    'user_id'     => $student->id,
                    'course_id'   => $course->id,
                    'paid_amount' => $student->waiver ? $course->fee - $student->waiver : $course->fee,
                    'status'      => "Unpaid",
                    'month'       => Carbon::today(),
                ] );
            }

        }

        return redirect()->back()->with( "success", "All Accounts Created Newly For This Month" );
    }

    public function student_pay_offline( Account $account ) {
        $this->authorize( "view", $account );

        $bkashNumber  = Option::where( "slug", "rocket_number" )->pluck( 'value' )->first();
        $rocketNumber = Option::where( "slug", "bkash_number" )->pluck( 'value' )->first();
        $nagadNumber  = Option::where( "slug", "nagad_number" )->pluck( 'value' )->first();

        return view( "ms.account.pay-offline", [
            'account'      => $account,
            'bkashNumber'  => $bkashNumber ?? "Not Avaiable",
            'rocketNumber' => $rocketNumber ?? "Not Avaiable",
            'nagadNumber'  => $nagadNumber ?? "Not Avaiable",
        ] );
    }

    public function student_pay_offline_store( Request $request ) {
        $data = $request->validate( [
            'name'           => "required|string",
            'email'          => "required|email",
            'address'        => "required",
            'phone'          => "required",
            'card_type'      => "required",
            'transaction_id' => "required",
            'amount'         => "required",
            'account_id'     => "required",
        ] );

        $data['user_id'] = Auth::user()->id;
        $data['status']  = "Pending";
        $data['amount']  = Account::findOrFail( $data['account_id'] )->paid_amount;

        Order::create( $data );

        return redirect()->route( "dashboard" )->with( "success", "Your payment is received, You will be able to access everything after confirmation" );
    }

    public function transactions() {
        return view( "ms.transactions.all-transactions", [
            "transactions" => Order::latest()->simplePaginate( 20 ),
        ] );

    }

    public function get_phone_numbers( $row, $course ) {

        $accounts = Account::where( "course_id", $course )->where( "month", Carbon::today() )->where( "status", "Unpaid" )->get();
        $numbers  = [];

        foreach ( $accounts as $account ) {
            $account->user->$row;

            if ( $account->user->$row ) {
                $numbers[] = $account->user->$row;
            }

        }

        return $numbers;
    }

    public function send_sms_due_report( Request $request, $parent ) {

        if ( $parent == "father" ) {
            $numbers = $this->get_phone_numbers( "fathers_phone_no", $request->course_id );

        } elseif ( $parent == "mother" ) {
            $numbers = $this->get_phone_numbers( "mothers_phone_no", $request->course_id );
        }

        $numberCount = count( $numbers );

        $smsrow        = Option::where( "slug", "remaining_sms" )->first();
        $remaining_sms = (int) $smsrow->value;

        if ( $remaining_sms < $numberCount ) {
            return redirect()->back()->with( "failed", "Not Enough SMS" );
        }

        if ( $numberCount > 0 ) {
            $numbers = implode( ",", $numbers );
            $message = "You have a payment due on month: " . Carbon::today()->format( "M-Y" ) . " - " . env( "APP_NAME" );

            $status = SMSController::send_sms( $numbers, $message );

            if ( $status ) {

                $remaining_sms = $remaining_sms - $numberCount;

                SMS::create( [
                    'for'       => "Account Report",
                    'course_id' => $request->course_id,
                    'count'     => $numberCount,
                    'message'   => $message,
                ] );

                $smsrow->update( [
                    'value' => $remaining_sms,
                ] );

                return redirect()->back()->with( "success", "All guardian reported successfully" );
            } else {
                return redirect()->back()->with( "failed", "Report failed for unknown reasosns, Check all studnets phone no is correct or not!" );
            }

        } else {
            return redirect()->back()->with( "failed", "Numbers not found, everyone may be have paid" );
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( Course $course ) {
        $accounts = Account::whereMonth( "month", Carbon::today() )->where( "course_id", $course->id )->get();

        if ( $accounts->count() <= 0 ) {
            $students   = $course->user;
            $newAccount = [];

            foreach ( $students as $student ) {

                if ( $student->is_active == 1 ) {
                    $newAccount[] = [
                        'user_id'     => $student->id,
                        'course_id'   => $course->id,
                        'paid_amount' => $student->waiver ? $course->fee - $student->waiver : $course->fee,
                        'status'      => "Unpaid",
                        'month'       => Carbon::today(),
                        'created_at'  => Carbon::now(),
                        'updated_at'  => Carbon::now(),
                    ];
                }

            }

            Account::insert($newAccount);

            return view( "ms.account.account-index", [
                "accounts" => Account::whereMonth( "month", Carbon::today() )->where( "course_id", $course->id )->get(),
            ] );
        } else {
            return view( "ms.account.account-index", [
                "accounts" => $accounts,
            ] );
        }

    }

    public function student_individual_account() {
        return view( "ms.account.student-individual-account" );
    }

    public function create_manually() {
        return view( "ms.account.manual-account" );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show( Account $account ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit( Account $account ) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, Account $account ) {
        //
    }

    /**
     *
     * Change the account status
     *
     */
    public function change( Request $request ) {

        $data = $request->validate( [
            "ids"    => "required|array",
            "status" => "nullable|array",
        ] );

        if ( isset( $data['status'] ) ) {
            $paid   = $data['status'];
            $unpaid = array_diff( $data['ids'], $data['status'] );

            Account::whereIn( "id", $paid )->update( ["status" => "Paid"] );
            Account::whereIn( "id", $unpaid )->update( ["status" => "Unpaid"] );

        } else {
            Account::whereIn( "id", $data["ids"] )->update( ["status" => "Unpaid"] );
        }

        return redirect()->back()->with( "success", "Account updated successfully" );

    }

    public function individual_account() {
        return view( "ms.account.student-account" );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy( Account $account ) {
        //
    }

}
