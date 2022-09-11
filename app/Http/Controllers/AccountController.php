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

    public function overall_account() {
        return view( "ms.account.overall-account" );
    }

    public function student_pay( Account $account ) {

        $this->authorize( "view", $account );

        return view( "ms.account.pay", [
            'account' => $account,
        ] );
    }

    public function mark_unpaid( $account ) {
        Account::findOrFail( $account )->update( ["status" => "Unpaid"] );

        return redirect()->back()->with( "success", "Payment Mark As Unpaid" );
    }

    public function regenerate_all() {
        $courses = Course::all();

        foreach ( $courses as $course ) {
            $students = $course->user;

            $this->regenerate_engine( $students, $course );
        }

        return redirect()->back()->with( "success", "Payments Re-Generated Successfully For This Month" );
    }

    public function regenerate_engine( $students, $course ) {

        if ( $course->type == "Monthly" ) {

            // If monthly then generate for month

            $newAccount = [];

            foreach ( $students as $student ) {

                if ( $student->is_active == 1 ) {

                    $account = Account::whereMonth( "month", Carbon::now() )
                        ->where( "user_id", $student->id )
                        ->where( "course_id", $course->id )
                        ->count();

                    if ( $account == 0 ) {
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

            }

            Account::insert( $newAccount );

        } else {

            // If onetime then only check
            $newAccount = [];

            foreach ( $students as $student ) {

                if ( $student->is_active == 1 ) {

                    $account = Account::where( "user_id", $student->id )
                        ->where( "course_id", $course->id )
                        ->count();

                    if ( $account == 0 ) {
                        $newAccount = [
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

            }

            Account::insert( $newAccount );

        }

    }

    public function regenerate( Course $course ) {

        $students = $course->user;

        $this->regenerate_engine( $students, $course );

        return redirect()->back()->with( "success", "Regenerated Successfully" );

    }

    public function regenerate_new( Course $course ) {

        if ( $course->type == "Monthly" ) {

            Account::whereMonth( "month", Carbon::now() )->where( 'course_id', $course->id )->delete();

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

            Account::insert( $newAccount );

        } else {

            Account::where( 'course_id', $course->id )->delete();

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

            Account::insert( $newAccount );

        }

        return redirect()->back()->with( "success", "All Accounts Created Newly For This Month" );
    }

    public function student_pay_offline( Account $account ) {
        $this->authorize( "view", $account );

        $bkashNumber  = Option::where( "slug", "bkash_number" )->pluck( 'value' )->first();
        $rocketNumber = Option::where( "slug", "rocket_number" )->pluck( 'value' )->first();
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

        Account::find( $data['account_id'] )->update( [
            "status" => "Pending",
        ] );

        return redirect()->route( "dashboard" )->with( "success", "Your payment is received, You will be able to access everything after confirmation" );
    }

    public function transactions() {
        return view( "ms.transactions.all-transactions", [
            "transactions" => Order::latest()->simplePaginate( 20 ),
        ] );

    }

    public function get_phone_numbers( $row, $course ) {
        $accounts = Account::where( "course_id", $course )
            ->whereMonth( "month", Carbon::today() )
            ->where( "status", "Unpaid" )
            ->get();

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

            $message = "সম্মানিত অভিভাবক, আপনার সন্তানের" . Carbon::today()->format( "M-Y" ) . " মাসের পেমেন্ট বাকি আছে - " . env( "APP_NAME" );
            // $message = "Dear Parent, Your child have a payment due on month: " . Carbon::today()->format( "M-Y" ) . " - " . env( "APP_NAME" );

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

    public function generate_all_payments() {
        $courses = Course::all( ["id", "fee"] );

        foreach ( $courses as $course ) {
            $accounts = Account::whereMonth( "month", Carbon::today() )->where( "course_id", $course->id )->pluck("id");

            $this->generate_payments( $course, $accounts );
        }

        return redirect()->back()->with( "success", "Payments For This Month Generated Successfully" );
    }

    public function generate_payments( $course, $accounts ) {

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

            Account::insert( $newAccount );

            return true;
        } else {
            return false;
        }

    }

    public function all_batch_accounts() {
        return view( "ms.account.all-batch-accounts");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( Course $course ) {

        if ( $course->type == "Monthly" ) {

            $accounts = Account::whereMonth( "month", Carbon::today() )->where( "course_id", $course->id )->get();

            $generated = $this->generate_payments( $course, $accounts );

            if ( $generated ) { // If generated then show them the page

                return view( "ms.account.account-index", [
                    "accounts" => Account::select( ["accounts.*", "accounts.id as account_id", "users.name as user_name", "users.email as user_email"] )
                        ->with( "user" )
                        ->leftJoin( "users", "accounts.user_id", "=", "users.id" )
                        ->orderBy( "users.name", "asc" )
                        ->whereMonth( "month", Carbon::today() )
                        ->where( "course_id", $course->id )
                        ->get(),
                ] );

            } else { // or show the previous

                return view( "ms.account.account-index", [
                    "accounts" => Account::select( ["accounts.*", "accounts.id as account_id", "users.name as user_name", "users.email as user_email"] )
                        ->with( "user" )
                        ->leftJoin( "users", "accounts.user_id", "=", "users.id" )
                        ->orderBy( "users.name", "asc" )
                        ->whereMonth( "month", Carbon::today() )
                        ->where( "course_id", $course->id )
                        ->get(),
                ] );

            }

        } else {

            $accounts = Account::where( "course_id", $course->id )->get();

            $generated = $this->generate_payments( $course, $accounts );

            if ( $generated ) { // If generated then show them a page

                return view( "ms.account.account-index", [
                    "accounts" => Account::where( "course_id", $course->id )->get(),
                ] );

            } else { // or show the previous

                return view( "ms.account.account-index", [
                    "accounts" => $accounts,
                ] );

            }

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
            "course" => "nullable|integer",
            "reauth" => "nullable|integer",
            "reauth_all" => "nullable|integer",
        ] );

        if ( isset( $data['status'] ) ) {

            $paid   = $data['status'];
            $unpaid = array_diff( $data['ids'], $data['status'] );

            Account::whereIn( "id", $paid )
                ->update( ["status" => "Paid"] );

            Account::whereIn( "id", $unpaid )
                ->whereNotIn( "status", ["Pending"] )
                ->update( ["status" => "Unpaid"] );
            // Account::whereIn( "id", $unpaid )->update( ["status" => "Unpaid"] );

        } else {
            Account::whereIn( "id", $data["ids"] )->update( ["status" => "Unpaid"] );
        }

        // Reauthorize if called to be reauthorize
        if ( isset($data['reauth'] ) && $data['reauth'] == 1 ) {
            $courseController = new CourseController();
            $courseController->reauthorize_users( Course::find( $data['course'] ) );
        }

        // Reauth all users is globally called
        if ( isset($data['reauth_all'] ) && $data['reauth_all'] == 1 ) {
            $courseController = new CourseController();
            $courseController->reauthorize_all();
        }

        return redirect()->back()->with( "success", "Account updated successfully" );

    }

    /*
    public function change_and_reauthorize( Request $request ) {

    $data = $request->validate( [
    "ids"    => "required|array",
    "status" => "nullable|array",
    "course" => "nullable|integer",
    ] );

    if ( isset( $data['status'] ) ) {
    $paid   = $data['status'];
    $unpaid = array_diff( $data['ids'], $data['status'] );

    Account::whereIn( "id", $paid )->update( ["status" => "Paid"] );
    Account::whereIn( "id", $unpaid )->update( ["status" => "Unpaid"] );

    } else {
    Account::whereIn( "id", $data["ids"] )->update( ["status" => "Unpaid"] );
    }

    // return redirect()->back()->with( "success", "Account updated successfully" );

    }
     */

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
