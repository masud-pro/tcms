<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Course;
use App\Models\Account;
use Illuminate\Http\Request;

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

    public function transactions() {
        return view("ms.transactions.all-transactions",[
            "transactions" => Order::latest()->simplePaginate(20)
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( Course $course ) {
        $accounts = Account::whereMonth( "month", Carbon::today() )->where( "course_id", $course->id )->get();

        if ( $accounts->count() <= 0 ) {
            $students = $course->user;

            foreach ( $students as $student ) {
                Account::create( [
                    'user_id'     => $student->id,
                    'course_id'   => $course->id,
                    'paid_amount' => $student->waiver ? $course->fee - $student->waiver : $course->fee,
                    'status'      => "Unpaid",
                    'month'       => Carbon::today(),
                ] );
            }

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
        // dd("Account e hit korse");
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
