<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Laravel\Jetstream\Jetstream;

class UserController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view( "ms.students.all-students" );
    }

    public function course_students( $course ) {
        $course = Course::withTrashed()->findOrFail( $course );
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
            "batches" => Course::all(),
        ] );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
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
            "phone_no"         => "required|string",
            "fathers_name"     => "nullable|string",
            "fathers_phone_no" => "nullable|string",
            "mothers_name"     => "nullable|string",
            "mothers_phone_no" => "nullable|string",
            "password"         => "required|confirmed|string",
        ] );

        $data['password'] = Hash::make( $data['password'] );

        if ( isset( $data['course_id'] ) ) {
            $corurses = $data['course_id'];
            unset( $data['course_id'] );
        } else {
            $corurses = [];
        }

        $user = User::create( $data );

        $user->course()->sync( $corurses );

        return redirect()->route( "user.index" )->with( "success", "Student created Successfully" );

    }

    public function store_admin( Request $request ) {
        $data = $request->validate( [
            'name'     => ['required', 'string', 'max:255'],
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( User $user ) {
        // dd($user);
        return view( 'ms.students.edit-student', [
            "user"    => $user,
            "batches" => Course::all(),
        ] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, User $user ) {
        // dd($request->all());

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
            "phone_no"         => "required|string",
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
            $corurses = $data['course_id'];
            unset( $data['course_id'] );
        } else {
            $corurses = [];
        }

        $user->update( $data );

        $user->course()->sync( $corurses );

        return redirect()->route( "user.index" )->with( "success", "Student updated Successfully" );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( User $user ) {
        $user->deleteProfilePhoto();
        $user->tokens->each->delete();
        $user->delete();

        return redirect()->route( "user.index" )->with( 'delete', "Account deleted successfully" );
    }

}
