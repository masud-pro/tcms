<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Option;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OptionController extends Controller {

    public function __construct() {
        $this->middleware( 'check_access:settings.individual_teacher', ['only' => ['index', 'update']] );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        // dd(User::with('settings.option')->find(2));

        return view( "ms.option.option", [
            "settings" => Auth::user()->load( 'settings.option' )->settings,
            // "settings" => Setting::all(),
            // "options" => Setting::all(),
            // "options" => Option::all(),
        ] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
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

    public function reset_frontpage_image() {

        $frontPageImage = getTeacherSetting('front_page_image')->value;

        Storage::delete( $frontPageImage );

        setTeacherSetting('front_page_image', auth()->user()->id);
        
        return redirect()->back()->with( "success", "Images reset successfully" );
    }


    public function change_course_generate_payments(Request $request) { // change if course should generate payments
        $validatedData = $request->validate([
            'course_id' => 'required',
            'should_generate_payments' => 'required',
        ]);

        Course::find($validatedData['course_id'])->update([
            'should_generate_payments' => !$validatedData['should_generate_payments']
        ]);

        return redirect()->back()->with('success','Course payment generation status changed successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Option          $option
     * @return \Illuminate\Http\Response
     */
    public function show( Option $option ) {
        //
    }

    public function course_payment_generate_options()
    {
        return view('ms.option.payment-generate',[
            // 'courses' => Course::all('id','name','should_generate_payments')
            'courses' => Auth::user()->addedCourses()->latest()->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Option          $option
     * @return \Illuminate\Http\Response
     */
    public function edit( Option $option ) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @param  \App\Models\Option          $option
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request ) {
        // dd($request->all());

        foreach ( $request->options as $slug => $option ) {

            $optionId = Option::where( "slug", $slug )->pluck( 'id' )->toArray();

            if ( $slug == "front_page_image" ) {
                Storage::delete( Setting::where( 'user_id', Auth::user()->id )->where( 'option_id', $optionId )->first()->value );

                $option['value'] = $option['value']->store( config('lfm.folder_categories.file.folder_name') . '/' .getUsername().'/images/front-page' );
                // dd($option['value']);
            }

            Setting::where( 'user_id', Auth::user()->id )->where( 'option_id', $optionId )->update( [
                'value' => $option['value'],
            ] );

            // Option::where( "slug", $slug )->update( [
            //     'value' => $option['value'],
            // ] );
        }

        return redirect()->back()->with( "success", "Options Updated Successfully" );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Option          $option
     * @return \Illuminate\Http\Response
     */
    public function destroy( Option $option ) {
        //
    }

}
