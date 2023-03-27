<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Course;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller {

    public function __construct() {

        $this->middleware( 'check_access:courses.index', ['only' => ['index']] );
        $this->middleware( 'check_access:courses.create', ['only' => ['create', 'store']] );
        $this->middleware( 'check_access:courses.edit', ['only' => ['edit', 'update']] );
        $this->middleware( 'check_access:courses.destroy', ['only' => ['destroy']] );
        $this->middleware( 'check_access:courses.archived', ['only' => ['archived', 'restore']] );
        $this->middleware( 'check_access:courses.authorization_panel', ['only' => ['authorization_panel']] );
        $this->middleware( 'check_access:courses.authorize_users', ['only' => ['authorize_users', 'reauthorize_all']] );
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {

        $courses = Auth::user()->addedCourses()->latest()->get();

        return view( "ms.courses.all-courses", compact( 'courses' ) );
    }

    public function archived() {
        return view( "ms.courses.archived-courses", [
            "courses" => Course::onlyTrashed()->get(),
        ] );
    }

    public function display() {
        // return view( "ms.courses.display-courses", [
        //     'courses' => Course::whereDoesntHave( 'user', function ( $q ) {
        //         $q->where( 'user_id', Auth::user()->id );
        //     } )->get(),
        // ] );

        //  $courses = Course::whereDoesntHave( 'user', function ( $q ) {
        //     $q->where( 'teacher_id', Auth::user()->id );
        // } )->get();

        $teacherId = Auth::user()->teacher_id;
        $courses   = Course::where( 'teacher_id', $teacherId )->get();

        $studentEnrolledCourse = Auth::user()->course;

        $studentCanEnroll = $courses->diff($studentEnrolledCourse);

    //    dd( $studentCanEnroll);


        // dd( $studentEnrollCourse );
        // dd( collect( $studentEnrolledCourse ) );
        // dd($courses);

        return view( "ms.courses.display-courses", compact( 'courses','studentCanEnroll' ) );
    }

    public function my_courses() {
        return view( "ms.courses.my-courses", [
            'courses' => Auth::user()->course,
        ] );
    }

    /**
     * Enroll a student
     *
     * @param  Course $course
     * @return void
     */
    public function enroll( Course $course ) {

        if ( $course->capacity > $course->user->where( "is_active", 1 )->count() ) {

            // If student enroll and the payment is not generated yet it will first check and generate the payment
            $accountsCount = Account::whereMonth( "month", Carbon::today() )
                ->where( "course_id", $course->id )
                ->count();

            if ( $accountsCount == 0 ) { // Generating payments

                $accounts = Account::whereMonth( "month", Carbon::today() )
                    ->where( "course_id", $course->id )
                    ->pluck( "id" );

                if ( $accounts->count() == 0 ) {
                    generate_payments( $course );
                }

            }

            // Enrol the student
            $course->user()->attach( Auth::user()->id );

            // Create an account for the student
            Account::create( [
                'user_id'     => Auth::user()->id,
                'course_id'   => $course->id,
                'status'      => "Unpaid",
                'paid_amount' => $course->fee - Auth::user()->waiver,
                'month'       => Carbon::now(),
            ] );

            return redirect()->route( "account.student.individual", ["status" => "Unpaid"] )->with( "success", "Course Enrolled Successfully, Please Pay The Tuition Fee To See The Course Content" );
        } else {
            return redirect()->route( "dashboard" )->with( "full", "Course Capacity is Full" );
        }

    }

    /**
     * @param Course $course
     */
    // public function authorization_panel( Course $course ) {
    //     return view( "ms.authorization.authorization-panel", [
    //         "students" => $course->user()->orderBy( "name", "asc" )->get(),
    //     ] );
    // }

    /**
     * @param Request $request
     * @param Course  $course
     */
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

            $course->user()->updateExistingPivot( $unauthorized, [
                'is_active' => 0,
            ] );

        } else {
            $course->user()->updateExistingPivot( $data["ids"], [
                'is_active' => 0,
            ] );
        }

        return redirect()->back()->with( "success", "Authorization updated successfully" );

    }

    /**
     * @param $course
     * @param $users
     */
    public function reauthorize_engine( $course, $users ) {

        foreach ( $users as $user ) {

            if ( !$user->is_active ) {
                $course->user()->updateExistingPivot( $user->id, [
                    'is_active' => 0,
                ] );

                continue; // If the user is not active then set authorization to 0 and continue to next iteration
            }

            $unPaid = $user->payment()
                           ->where( "course_id", $course->id )
                           ->where( "status", "Unpaid" )
                           ->whereMonth( "created_at", Carbon::today() )
                           ->count();

            // if( $user->id == 2 ){
            //     dd($unPaid);
            // }

            if ( $unPaid > 0 ) {
                $course->user()->updateExistingPivot( $user->id, [
                    'is_active' => 0,
                ] );
            } else {
                $course->user()->updateExistingPivot( $user->id, [
                    'is_active' => 1,
                ] );
            }

        }

    }

    /**
     * @param Course $course
     */
    public function reauthorize_users( Course $course ) {

        $users = $course->user;

        $this->reauthorize_engine( $course, $users );

        return redirect()->back()->with( "success", "Reauthorization Successfull" );

    }

    public function reauthorize_all() {
        $courses = Auth::user()->addedCourses()->latest()->get();

        foreach ( $courses as $course ) {
            $users = $course->user;

            $this->reauthorize_engine( $course, $users );
        }

        return redirect()->back()->with( "success", "Reauthorization Successful" );

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
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {

        $data = $request->validate( [
            "name"        => "required|string",
            "description" => "nullable|string",
            "class_link"  => "nullable|string",
            "fee"         => "required|integer",
            "type"        => "required|string",
            "time"        => "required|string",
            "capacity"    => "required|integer",
            "section"     => "nullable|string",
            "subject"     => "required|string",
            "room"        => "nullable|string",
            "address"     => "nullable|string",
            "image"       => "nullable|image",
        ] );

        if ( isset( $data['image'] ) ) {

            $url = config( 'lfm.folder_categories.file.folder_name' ) . '/' . getUsername() . '/images/batch-images';

            $image = $data['image']->store( $url );

            $data['image'] = $image;
        }

        $data['teacher_id'] = Auth::user()->id;

        Course::create( $data );

        return redirect()->route( "course.index" )->with( "success", "Course created successfully" );

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course          $course
     * @return \Illuminate\Http\Response
     */
    public function show( Course $course ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course          $course
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
     * @param  \Illuminate\Http\Request    $request
     * @param  \App\Models\Course          $course
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, Course $course ) {

        $data = $request->validate( [
            "name"        => "required|string",
            "description" => "nullable|string",
            "class_link"  => "nullable|string",
            "fee"         => "required|integer",
            "type"        => "required|string",
            "time"        => "required|string",
            "capacity"    => "required|integer",
            "section"     => "nullable|string",
            "subject"     => "required|string",
            "room"        => "nullable|string",
            "address"     => "nullable|string",
            "image"       => "nullable|image",
        ] );

        if ( isset( $data['image'] ) ) {

            if ( $course->image ) {
                Storage::delete( $course->image );
            }

            $url = config( 'lfm.folder_categories.file.folder_name' ) . '/' . getUsername() . '/images/batch-images';

            $image = $data['image']->store( $url );

            $data['image'] = $image;
        }

        $course->update( $data );

        return redirect()->back()->with( "success", "Course updated successfully" );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course          $course
     * @return \Illuminate\Http\Response
     */
    public function destroy( Course $course ) {
        $course->delete();

        return redirect()->route( "course.index" )->with( "delete", "Course Archived Successfuly" );
    }

    /**
     * @param $course
     */
    public function restore( $course ) {
        Course::withTrashed()->findOrFail( $course )->restore();

        return redirect()->route( "course.index" )->with( "success", "Course Unarchived Successfuly" );
    }

}
