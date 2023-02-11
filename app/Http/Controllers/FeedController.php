<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use App\Models\Course;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\Feed\CreateFeed;
use Illuminate\Support\Facades\Notification;

class FeedController extends Controller {

    public function __construct() {
        $this->middleware( 'check_access:feed.index', ['only' => ['index']] );
        $this->middleware( 'check_access:feed.create', ['only' => ['create', 'store']] );
        $this->middleware( 'check_access:feed.edit', ['only' => ['edit', 'update']] );
        $this->middleware( 'check_access:feed.destroy', ['only' => ['destroy']] );
        $this->middleware( 'check_access:feed.create_link', ['only' => ['create_link', 'store_link']] );
        $this->middleware( 'check_access:feed.edit_link', ['only' => ['edit_link', 'update_link']] );

        // $this->middleware( 'check_access:feed.destroy_link', ['only' => ['destroy']] );

        // 'feed.index',
        // 'feed.create',
        // 'feed.edit',
        // 'feed.destroy',
        // 'feed.create_link',
        // 'feed.edit_link',

        // 'exam_question.index',
        // 'exam_question.create',
        // 'exam_question.edit',
        // 'exam_question.destroy',
        // 'exam_question.assigned_course',

        // 'attendance.course_students',
        // 'attendance.individual_students',

        // 'accounts.update',
        // 'accounts.course_update',
        // 'accounts.overall_user_account',
        // 'accounts.individual_student',

        // 'transactions.user_online_transactions',

        // 'file_manager.individual_teacher',

        // 'settings.individual_teacher',
    }

    // public function __construct() {
    //     $this->middleware( "isAdmin" )
    //          ->only( [
    //              "feed.edit",
    //              "feed.destroy",
    //              "feed.create",
    //              "feed.create_link",
    //              "feed.store",
    //              "feed.store_link",
    //              "feed.edit_link",
    //              "feed.update",
    //              "feed.update_link",
    //          ] );
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index( $course ) {

        $this->authorize( 'view', Course::findOrFail( $course ) );

        $course = Course::with( "user" )->withTrashed()->findOrFail( $course );

        if ( Auth::user()->role == "Admin" ) {
            $present      = $course->attendance->where( "attendance", 1 )->count();
            $allAtendance = $course->attendance->count();

            if ( $allAtendance > 0 ) {
                $attendancePercentage = ( $present / $allAtendance ) * 100;
            } else {
                $attendancePercentage = 0;
            }

            $totalStudents = $course->user->count();
            $paid          = $course->account->where( "status", "Paid" )->count();
            $unpaid        = $course->account->where( "status", "Unpaid" )->count();
        } else {
            $attendancePercentage = 0;
            $totalStudents        = 0;
            $paid                 = 0;
            $unpaid               = Account::where( "user_id", auth()->user()->id )
                ->where( "course_id", $course->id )
                ->where( "status", "Unpaid" )
                ->count();
            $accountStatus = Account::where( "user_id", auth()->user()->id )
                ->where( "course_id", $course->id )
                ->where( "status", "Pending" )
                ->count();
        }

        return view( "ms.feed.all-feed", [
            "course"               => $course,
            "feeds"                => $course->feeds()->latest()->get(),
            "is_active"            => auth()->user()->course()->where( "course_id", $course->id )->pluck( "is_active" )->first(),
            "canSeeFriends"        => getTeacherSetting( 'can_student_see_friends' )->value ?? 0,
            "attendancePercentage" => sprintf( "%.1f", $attendancePercentage ),
            "totalStudents"        => $totalStudents,
            "paid"                 => $paid,
            "unpaid"               => $unpaid,
            "accountStatus"        => $accountStatus ?? 0,
        ] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( Course $course ) {
        return view( 'ms.feed.create.create-feed', [
            'course' => $course,
            // 'students' => $course->user,
        ] );
    }

    /**
     * @param Course $course
     */
    public function create_link( Course $course ) {
        return view( "ms.feed.create.create-link", [
            'course' => $course,
        ] );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request, Course $course ) {

        $data = $request->validate( [
            'name'        => 'required|string',
            'description' => 'required',
            'type'        => 'required',
        ] );

        $data['user_id'] = Auth::user()->id;

        $created = $course->feeds()->create( $data );

        if ( $created ) {
            $feed['courseName'] = $course->name;
            $feed['url']        = route( "course.feeds.index", ['course' => $course->id] );

            Notification::send(
                $course->user,
                new CreateFeed( $feed )
            );
        }

        return redirect()
            ->route( "course.feeds.index", ["course" => $course->id] )
            ->with( "success", "Feed added Successfully" );
    }

    /**
     * @param Request $request
     * @param Course  $course
     */
    public function store_link( Request $request, Course $course ) {

        $data = $request->validate( [
            'name' => 'required|string',
            'link' => 'required',
            'type' => 'required',
        ] );

        $data['user_id'] = Auth::user()->id;

        $created = $course->feeds()->create( $data );

        if ( $created ) {
            $feed['courseName'] = $course->name;
            $feed['url']        = route( "course.feeds.index", ['course' => $course->id] );

            Notification::send(
                $course->user,
                new CreateFeed( $feed )
            );
        }

        return redirect()
            ->route( "course.feeds.index", ["course" => $course->id] )
            ->with( "success", "Link added Successfully" );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Feed            $feed
     * @return \Illuminate\Http\Response
     */
    public function show( Feed $feed ) {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Feed            $feed
     * @return \Illuminate\Http\Response
     */
    public function edit( Feed $feed, Request $request ) {
        return view( 'ms.feed.edit.edit-feed', [
            'feed'   => $feed,
            'course' => Course::findOrFail( $request->course ),
        ] );
    }

    /**
     *
     * Edit feed links
     *
     * @param $request, $feed
     */
    public function edit_link( Feed $feed, Request $request ) {
        // dd($request->course);
        return view( 'ms.feed.edit.edit-link', [
            'feed'   => $feed,
            'course' => Course::findOrFail( $request->course ),
        ] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @param  \App\Models\Feed            $feed
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, Feed $feed ) {
        $data = $request->validate( [
            'name'        => 'required|string',
            'description' => 'required',
            'type'        => 'required',
            'course_id'   => 'required|integer',
        ] );

        $feed->update( $data );

        return redirect()
            ->route( "course.feeds.index", ["course" => $data['course_id']] )
            ->with( "success", "Feed upated Successfully" );
    }

    /**
     * @param Request $request
     * @param Feed    $feed
     */
    public function update_link( Request $request, Feed $feed ) {
        $data = $request->validate( [
            'name'      => 'required|string',
            'link'      => 'required',
            'type'      => 'required',
            'course_id' => 'required|integer',
        ] );

        $feed->update( $data );

        return redirect()
            ->route( "course.feeds.index", ["course" => $data['course_id']] )
            ->with( "success", "Link upated Successfully" );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Feed            $feed
     * @return \Illuminate\Http\Response
     */
    public function destroy( Feed $feed ) {
        $feed->delete();
        return redirect()->back()->with( "delete", "Feed Deleted Successfully" );
    }

}
