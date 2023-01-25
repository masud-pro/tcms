<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\SMS;
use App\Models\User;
use App\Models\Order;
use App\Models\Course;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller {

    public function __construct() {
        $this->middleware( 'check_access:accounts.update', ['only' => ['all_batch_accounts']] );
        $this->middleware( 'check_access:accounts.course_update', ['only' => ['index', 'create_manually']] );
        $this->middleware( 'check_access:accounts.individual_student', ['only' => ['individual_account']] );
        $this->middleware( 'check_access:accounts.overall_user_account', ['only' => ['overall_account']] );

        $this->middleware( 'check_access:transactions.user_online_transactions', ['only' => ['transactions']] );
    }

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

    /**
     * @param Account $account
     */
    public function student_pay( Account $account ) {

        $this->authorize( "view", $account );

        return view( "ms.account.pay", [
            'account' => $account,
        ] );
    }

    /**
     * @param $account
     */
    public function mark_unpaid( $account ) {
        Account::findOrFail( $account )->update( ["status" => "Unpaid"] );

        return redirect()->back()->with( "success", "Payment Mark As Unpaid" );
    }

    public function regenerate_all() {
        $courses = Auth::user()->addedCourses()->latest()->get();

        foreach ( $courses as $course ) {
            $students = $course->user;

            $this->regenerate_engine( $students, $course );
        }

        return redirect()->back()->with( "success", "Payments Re-Generated Successfully For This Month" );
    }

    /**
     * @param $students
     * @param $course
     */
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

    /**
     * @param Course $course
     */
    public function regenerate( Course $course ) {

        $students = $course->user;

        $this->regenerate_engine( $students, $course );

        return redirect()->back()->with( "success", "Regenerated Successfully" );

    }

    /**
     * @param Course $course
     */
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

    /**
     * @param Account $account
     */
    public function student_pay_offline( Account $account ) {
        $this->authorize( "view", $account );

        $bkashNumber  = getTeacherSetting( 'bkash_number' )->value;
        $rocketNumber = getTeacherSetting( 'rocket_number' )->value;
        $nagadNumber  = getTeacherSetting( 'nagad_number' )->value;

        return view( "ms.account.pay-offline", [
            'account'      => $account,
            'bkashNumber'  => $bkashNumber ?? "Not Avaiable",
            'rocketNumber' => $rocketNumber ?? "Not Avaiable",
            'nagadNumber'  => $nagadNumber ?? "Not Avaiable",
        ] );
    }

    /**
     * @param Request $request
     */
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
        $data['teacher_id'] = Auth::user()->teacher_id;
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
            "transactions" => Order::where('teacher_id', auth()->user()->id)->latest()->simplePaginate( 20 ),
        ] );

    }

    /**
     * @param  $row
     * @param  $course
     * @return mixed
     */
    public function get_phone_numbers( $row, $course ) {
        $accounts = Account::where( "course_id", $course )
            ->whereMonth( "month", Carbon::today() )
            ->where( "status", "Unpaid" )
            ->get();

        $numbers = [];

        foreach ( $accounts as $account ) {
            $account->user->$row;

            if ( $account->user->$row ) {
                $numbers[] = $account->user->$row;
            }

        }

        return $numbers;
    }

    /**
     * @param Request   $request
     * @param $parent
     */
    public function send_sms_due_report( Request $request, $parent ) {

        if ( $parent == "father" ) {
            $numbers = $this->get_phone_numbers( "fathers_phone_no", $request->course_id );

        } elseif ( $parent == "mother" ) {
            $numbers = $this->get_phone_numbers( "mothers_phone_no", $request->course_id );
        }

        $numberCount = count( $numbers );

        $smsrow        = getTeacherSetting( 'remaining_sms' );
        $remaining_sms = (int) $smsrow->value;

        if ( $remaining_sms < $numberCount ) {
            return redirect()->back()->with( "failed", "1Not Enough SMS" );
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

    /**
     * @param $send_to
     */
    public function all_students_account_sms( $send_to ) {
        $students = User::where( 'role', 'Student' )->whereHas( 'payment', function ( $query ) {
            $query->where( 'status', 'Unpaid' );
        } )->get();
        // dd($students[1]->payment);

        $numberCount = count( $students );

        // $smsId = Option::where( "slug", "remaining_sms" )->first()['id'];

        //$smsrow = Auth::user()->load( 'settings.option' )->settings->where( "option_id",  $smsId )->first();

        $smsrow = getTeacherSetting( 'remaining_sms' );

        // dd( $smsrow );

        $remaining_sms = (int) $smsrow->value;

        if ( $remaining_sms < $numberCount ) {
            return redirect()->back()->with( "failed", "Not Enough SMS" );
        }

        // dd( $remaining_sms );
        foreach ( $students as $student ) {
            $message  = "সম্মানিত অভিভাবক, আপনার সন্তানের ";
            $payments = $student->payment;
            foreach ( $payments as $payment ) {
                $message .= Carbon::parse( $payment->month )->format( "M-Y" ) . ", ";
            }
            $message .= " মাসের পেমেন্ট বাকি আছে - " . env( "APP_NAME" );

            // dd($message );
            $number = $student->$send_to;
            SMSController::send_sms( $number, $message );

        }

        $remaining_sms = $remaining_sms - $numberCount;

        SMS::create( [
            'for'     => "Overall Account Report",
            'count'   => $numberCount,
            'message' => $message,
        ] );

        $smsrow->update( [
            'value' => $remaining_sms,
        ] );

        return redirect()->back()->with( 'success', 'All guardian informed successfully' );

    }

    public function generate_all_payments() {
        $courses = Course::all( ["id", "fee"] );

        foreach ( $courses as $course ) {
            $accounts = Account::whereMonth( "month", Carbon::today() )->where( "course_id", $course->id )->pluck( "id" );

            $this->generate_payments( $course, $accounts );
        }

        return redirect()->back()->with( "success", "Payments For This Month Generated Successfully" );
    }

    /**
     * @param $course
     * @param $accounts
     */
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
        return view( "ms.account.all-batch-accounts" );
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
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account         $account
     * @return \Illuminate\Http\Response
     */
    public function show( Account $account ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account         $account
     * @return \Illuminate\Http\Response
     */
    public function edit( Account $account ) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @param  \App\Models\Account         $account
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
            "ids"        => "required|array",
            "status"     => "nullable|array",
            "course"     => "nullable|integer",
            "reauth"     => "nullable|integer",
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
        if ( isset( $data['reauth'] ) && $data['reauth'] == 1 ) {
            $courseController = new CourseController();
            $courseController->reauthorize_users( Course::find( $data['course'] ) );
        }

        // Reauth all users is globally called
        if ( isset( $data['reauth_all'] ) && $data['reauth_all'] == 1 ) {
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
     * @param  \App\Models\Account         $account
     * @return \Illuminate\Http\Response
     */
    public function destroy( Account $account ) {
        //
    }

}
