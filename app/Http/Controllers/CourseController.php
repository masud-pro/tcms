<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Account;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class CourseController extends Controller {

    public function __construct() {
        $this->middleware('isAdmin')->only([
            'edit',
            'index',
            'archived',
            'authorization_panel',
            'authorize_users',
            'reauthorize_users',
            'create',
            'edit',
            'update',
            'destroy',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view( "ms.courses.all-courses", [
            "courses" => Course::latest()->get(),
        ] );
    }

    public function archived() {
        return view( "ms.courses.archived-courses", [
            "courses" => Course::onlyTrashed()->get(),
        ] );
    }

    public function display() {
        return view( "ms.courses.display-courses", [
            'courses' => Course::whereDoesntHave( 'user', function ( $q ) {
                $q->where( 'user_id', Auth::user()->id );
            } )->get(),
        ] );
    }

    public function my_courses() {
        return view( "ms.courses.my-courses", [
            'courses' => Auth::user()->course,
        ] );
    }

    public function enroll( Course $course ) {

        if ( $course->capacity > $course->user()->count() ) {
            $course->user()->attach( Auth::user()->id );
            
            Account::create([
                'user_id' => Auth::user()->id,
                'course_id' => $course->id,
                'status' => "Unpaid",
                'paid_amount' => $course->fee - Auth::user()->waiver,
                'month' => Carbon::now(),
            ]);

            return redirect()->route( "dashboard" )->with( "success", "Course Enrolled Successfully, Please Pay The Tuition Fee To See The Course Content" );
        } else {
            return redirect()->route( "dashboard" )->with( "full", "Course Capacity is Full" );
        }

    }

    public function authorization_panel( Course $course ) {
        return view( "ms.authorization.authorization-panel", [
            "students" => $course->user,
        ] );
    }

    public function authorize_users( Request $request, Course $course ) {
        $data = $request->validate( [
            "ids"      => "required|array",
            "students" => "nullable|array",
        ] );

        if ( isset( $data['students'] ) ) {
            $authorized   = $data['students'];
            $unauthorized = array_diff( $data['ids'], $data['students'] );

            $course->user()->updateExistingPivot( $authorized, [
                'is_active' => 1,
            ] );
            

        } else {
            $course->user()->updateExistingPivot( $data["ids"], [
                'is_active' => 0,
            ] );
        }

        return redirect()->back()->with( "success", "Authorization updated successfully" );

    }

    public function reauthorize_users( Course $course ) {

        $users = $course->user;

        foreach ( $users as $user ) {
            $unpaidPayments = $user->payment()->where( "status", "unpaid" )->count();

            if ( $unpaidPayments > 0 ) {
                $course->user()->updateExistingPivot( $user->id, [
                    'is_active' => 0,
                ] );
            } else {
                $course->user()->updateExistingPivot( $user->id, [
                    'is_active' => 1,
                ] );
            }

        }

        return redirect()->back()->with( "success", "Reauthorization Successfull" );

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view( "ms.courses.create-course" );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {

        $data = $request->validate( [
            "name"        => "required|string",
            "description" => "nullable|string",
            "fee"         => "required|integer",
            "type"        => "required|string",
            "time"        => "nullable|string",
            "capacity"    => "required|integer",
            "section"     => "nullable|string",
            "subject"     => "required|string",
            "room"        => "nullable|string",
            "address"     => "nullable|string",
            "image"       => "nullable|image",
        ] );

        if ( isset( $data['image'] ) ) {
            $image = $data['image']->store( 'batch-images' );

            $data['image'] = $image;
        }

        Course::create( $data );

        return redirect()->route( "course.index" )->with( "success", "Course created successfully" );

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show( Course $course ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit( Course $course ) {
        return view( "ms.courses.edit-course", [
            "course" => $course,
        ] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, Course $course ) {

        $data = $request->validate( [
            "name"        => "required|string",
            "description" => "nullable|string",
            "fee"         => "required|integer",
            "type"        => "required|string",
            "time"        => "nullable|string",
            "capacity"    => "required|integer",
            "section"     => "nullable|string",
            "subject"     => "required|string",
            "room"        => "nullable|string",
            "address"     => "nullable|string",
            "image"       => "nullable|image",
        ] );

        if ( isset( $data['image'] ) ) {

            if ( $course->image ) {
                // dd("storage/" . $course->image);
                File::delete( "storage/" . $course->image );
                // unlink( asset("storage".$course->image) );
            }

            $image = $data['image']->store( 'batch-images' );

            $data['image'] = $image;
        }

        $course->update( $data );

        return redirect()->back()->with( "success", "Course created successfully" );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy( Course $course ) {
        $course->delete();

        return redirect()->route( "course.index" )->with( "delete", "Course Archived Successfuly" );
    }

    public function restore( $course ) {
        Course::withTrashed()->findOrFail( $course )->restore();

        return redirect()->route( "course.index" )->with( "success", "Course Unarchived Successfuly" );
    }

}
