<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OptionController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view( "ms.option.option", [
            "options" => Option::all(),
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {
        //
    }

    public function reset_frontpage_image() {

        Storage::delete( Option::where( "slug", "front_page_image" )->first()->value );

        Option::where("slug","front_page_image")->update([
            "value" => 0,
        ]);

        return redirect()->back()->with("success","Images reset successfully");
    }


    public function change_course_generate_payments(Request $request)
    {
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
     * @param  \App\Models\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function show( Option $option ) {
        //
    }

    public function course_payment_generate_options()
    {
        return view('ms.option.payment-generate',[
            'courses' => Course::all('id','name','should_generate_payments')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function edit( Option $option ) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request ) {

        foreach ( $request->options as $slug => $option ) {

            if ( $slug == "front_page_image" ) {

                Storage::delete( Option::where( "slug", "front_page_image" )->first()->value );

                $option['value'] = $option['value']->store( 'images/front-page' );
            }

            Option::where( "slug", $slug )->update( [
                'value' => $option['value'],
            ] );
        }

        return redirect()->back()->with( "success", "Options Updated Successfully" );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function destroy( Option $option ) {
        //
    }

}
