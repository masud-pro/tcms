<?php

namespace App\Http\Controllers;

use App\Models\User;
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

        $optionId = Option::where( 'slug', 'front_page_image' )->pluck( 'id' )->toArray();

        Storage::delete( Setting::where( 'user_id', Auth::user()->id )->where( 'option_id', $optionId )->first()->value );

        // Storage::delete( Option::where( "slug", "front_page_image" )->first()->value );

        // Option::where( "slug", "front_page_image" )->update( [
        //     "value" => 0,
        // ] );

        Setting::where( 'user_id', Auth::user()->id )->where( 'option_id', $optionId )->update( [
            'value' => 0,

        ] );

        return redirect()->back()->with( "success", "Images reset successfully" );
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
// return $request->options['manual_payment' ];

        foreach ( $request->options as $slug => $option ) {

            $optionId = Option::where( "slug", $slug )->pluck( 'id' )->toArray();

            if ( $slug == "front_page_image" ) {

                Storage::delete( Setting::where( 'user_id', Auth::user()->id )->where( 'option_id', $optionId )->first()->value );

                $option['value'] = $option['value']->store( 'public/images/front-page' );
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
