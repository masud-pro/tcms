<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Feed;
use App\Notifications\Feed\CreateFeed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class FeedController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index( $course ) {

        $this->authorize( 'view', Course::findOrFail( $course ) );

        $course = Course::withTrashed()->findOrFail( $course );

        return view( "ms.feed.all-feed", [
            "course"    => $course,
            "feeds"     => $course->feeds()->latest()->get(),
            "is_active" => Auth::user()->course()->where( "course_id", $course->id )->pluck( "is_active" )->first(),
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

    public function create_link( Course $course ) {
        return view( "ms.feed.create.create-link", [
            'course' => $course,
        ] );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request, Course $course ) {

        $data = $request->validate( [
            'name'        => 'required|string',
            'description' => 'required',
            'type'        => 'required',
        ] );

        $created = $course->feeds()->create( $data );

        if( $created ){
            $feed['courseName'] = $course->name;
            $feed['url']        = route( "course.feeds.index", ['course' => $course->id] );

            Notification::send( 
                $course->user,
                new CreateFeed($feed)
            );
        }


        return redirect()
            ->route( "course.feeds.index", ["course" => $course->id] )
            ->with( "success", "Feed added Successfully" );
    }

    public function store_link( Request $request, Course $course ) {

        $data = $request->validate( [
            'name' => 'required|string',
            'link' => 'required',
            'type' => 'required',
        ] );

        $created = $course->feeds()->create( $data );

        if( $created ){
            $feed['courseName'] = $course->name;
            $feed['url']        = route( "course.feeds.index", ['course' => $course->id] );

            Notification::send( 
                $course->user,
                new CreateFeed($feed)
            );
        }

        return redirect()
            ->route( "course.feeds.index", ["course" => $course->id] )
            ->with( "success", "Link added Successfully" );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Feed  $feed
     * @return \Illuminate\Http\Response
     */
    public function show( Feed $feed ) {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Feed  $feed
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
     *
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Feed  $feed
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
     * @param  \App\Models\Feed  $feed
     * @return \Illuminate\Http\Response
     */
    public function destroy( Feed $feed ) {
        $feed->delete();
        return redirect()->back()->with( "delete", "Feed Deleted Successfully" );
    }
}
