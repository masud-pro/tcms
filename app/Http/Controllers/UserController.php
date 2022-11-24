<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Course;
use App\Models\Account;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Jetstream\Jetstream;
use App\Models\AssignmentResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {

    // public function __construct() {
    //     // $this->middleware( 'isAdmin' )->only( [
    //     //     'edit',
    //     //     'index',
    //     //     'archived',
    //     //     'authorization_panel',
    //     //     'authorize_users',
    //     //     'reauthorize_users',
    //     //     'create',
    //     //     'edit',
    //     //     'update',
    //     //     'destroy',
    //     // ] );

    //     $this->middleware( 'permission:courses.index', ['only' => ['index']] );
    //     $this->middleware( 'permission:courses.edit', ['only' => ['edit', 'update']] );
    //     $this->middleware( 'permission:courses.update', ['only' => ['edit', 'update']] );
    //     $this->middleware( 'permission:courses.destroy', ['only' => ['edit', 'update']] );
    //     $this->middleware( 'permission:courses.archived', ['only' => ['show']] );
    //     $this->middleware( 'permission:courses.authorization_panel', ['only' => ['edit', 'update']] );
    //     $this->middleware( 'permission:courses.authorize_users', ['only' => ['edit', 'update']] );
    // }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view( "ms.students.all-students" );
    }

    /**
     * @param $course
     */
    public function course_students( $course ) {
        $course = Course::withTrashed()->findOrFail( $course );

        $this->authorize( 'view', $course );

        return view( "ms.students.bulk-students", [
            "users"  => $course->user,
            "course" => $course,
        ] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view( "ms.students.create-student", [
            "batches" => Auth::user()->addedCourses()->latest()->get(),
        ] );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {

        $data = $request->validate( [
            "name"             => "required|string",
            "email"            => "required|string|email|max:255|unique:users",
            "course_id"        => "nullable|array",
            "role"             => "required",
            "address"          => "required",
            "dob"              => "required|date",
            "gender"           => "required|string",
            "is_active"        => "required",
            "class"            => "nullable|integer",
            "roll"             => "nullable|integer",
            "reg_no"           => "nullable|integer",
            "waiver"           => "required|integer",
            "phone_no"         => "required|string|max:11|min:11|unique:users,phone_no",
            "fathers_name"     => "nullable|string",
            "fathers_phone_no" => "nullable|string|max:11|min:11",
            "mothers_name"     => "nullable|string",
            "mothers_phone_no" => "nullable|string|max:11|min:11",
            "password"         => "required|confirmed|string",
        ] );

        $data['password'] = Hash::make( $data['password'] );

        if ( isset( $data['course_id'] ) ) {
            $courses = $data['course_id'];
            unset( $data['course_id'] );
        } else {
            $courses = [];
        }

        $user = User::create( $data );

        $user->course()->sync( $courses );

        $accounts = [];

        foreach ( $courses as $course ) {

            $course = Course::findOrFail( $course, ["id", "fee"] );

            // Generate payment first
            $accountsCount = Account::whereMonth( "month", Carbon::today() )
                ->where( "course_id", $course->id )
                ->count();

            if ( $accountsCount == 0 ) {

                $allaccounts = Account::whereMonth( "month", Carbon::today() )
                    ->where( "course_id", $course->id )
                    ->pluck( "id" );

                $accountController = new AccountController();
                $accountController->generate_payments( $course, $allaccounts );
                continue; // Generate paments and iterate to the next execution
            }

            // Add the account if payment is generated previously
            if ( $user->is_active == 1 ) {
                $accounts[] = [
                    'user_id'     => $user->id,
                    'course_id'   => $course->id,
                    'status'      => "Unpaid",
                    'paid_amount' => $course->fee - $user->waiver,
                    'month'       => Carbon::now(),
                    'created_at'  => Carbon::now(),
                    'updated_at'  => Carbon::now(),
                ];
            }
        }

        Account::insert( $accounts );

        return redirect()->route( "user.index" )->with( "success", "Student created Successfully" );

    }

    /**
     * @param Request $request
     */
    public function store_admin( Request $request ) {
        $data = $request->validate( [
            'name'     => ['required', 'string', 'max:255'],
            'phone_no' => ['required', 'max:11', 'min:11'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed'],
            'terms'    => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
            'role'     => ['required'],
        ] );

        $data['password'] = Hash::make( $data['password'] );

        $user = User::create( $data );

        Auth::login( $user );

        return redirect()->route( "dashboard" );
    }

    /**
     * Display the specified resource.
     *
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function edit( User $user ) {
        // dd($user);
        return view( 'ms.students.edit-student', [
            "user"    => $user,
            "batches" => Auth::user()->addedCourses()->latest()->get(),
        ] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, User $user ) {

        $data = $request->validate( [
            "name"             => "required|string",
            "email"            => ['required', 'email', 'max:255', Rule::unique( 'users' )->ignore( $user->id )],
            "course_id"        => "nullable|array",
            "address"          => "required",
            "role"             => "required",
            "dob"              => "required|date",
            "gender"           => "required|string",
            "is_active"        => "required",
            "class"            => "nullable|integer",
            "roll"             => "nullable|integer",
            "reg_no"           => "nullable|integer",
            "waiver"           => "required|integer",
            "phone_no"         => ["required", 'min:11', 'max:11', Rule::unique( 'users', 'phone_no' )->ignore( $user->id )],
            "fathers_name"     => "nullable|string",
            "fathers_phone_no" => "nullable|string",
            "mothers_name"     => "nullable|string",
            "mothers_phone_no" => "nullable|string",
            "password"         => "nullable|confirmed|string",
        ] );

        if ( $data['password'] ) {
            $data['password'] = Hash::make( $data['password'] );
        } else {

            unset( $data['password'] );
        }

        if ( isset( $data['course_id'] ) ) {
            $courses = $data['course_id'];
            unset( $data['course_id'] );
        } else {
            $courses = [];
        }

        $user->update( $data );

        $user->course()->sync( $courses );

        $accounts = [];

        foreach ( $courses as $course ) { // Creating account based on chosen courses
            $course = Course::findOrFail( $course, ["id", "fee"] );

            $accountsCount = Account::whereMonth( "month", Carbon::today() )
                ->where( "course_id", $course->id )
                ->count();

            // Generate the payments for the course first
            if ( $accountsCount == 0 ) {

                $allaccounts = Account::whereMonth( "month", Carbon::today() )
                    ->where( "course_id", $course->id )
                    ->pluck( "id" );

                $accountController = new AccountController();
                $accountController->generate_payments( $course, $allaccounts );
                continue; // Generate paments and iterate to the next execution
            }

            // Check if the account is already exists
            $accountcount = Account::whereMonth( "month", Carbon::today() )
                ->where( "user_id", $user->id )
                ->where( "course_id", $course->id )
                ->count();

            // Add the account if payment is generated previously
            if ( $accountcount == 0 && $user->is_active == 1 ) {
                $accounts[] = [
                    'user_id'     => $user->id,
                    'course_id'   => $course->id,
                    'status'      => "Unpaid",
                    'paid_amount' => $course->fee - $user->waiver,
                    'month'       => Carbon::now(),
                    'created_at'  => Carbon::now(),
                    'updated_at'  => Carbon::now(),
                ];
            }

        }

        Account::insert( $accounts );

        return redirect()->route( "user.index" )->with( "success", "Student updated Successfully" );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( User $user ) {

        $user->course()->detach();
        Account::where( 'user_id', $user->id )->delete();
        Attendance::where( 'user_id', $user->id )->delete();
        AssignmentResponse::where( 'user_id', $user->id )->delete();
        
        $user->deleteProfilePhoto();
        $user->tokens->each->delete();
        $user->delete();

        return redirect()->route( "user.index" )->with( 'delete', "Account deleted successfully" );
    }

}