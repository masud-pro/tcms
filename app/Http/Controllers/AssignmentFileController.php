<?php

namespace App\Http\Controllers;

use App\Models\AssignmentFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssignmentFileController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AssignmentFile  $assignmentFile
     * @return \Illuminate\Http\Response
     */
    public function show( AssignmentFile $assignmentFile ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AssignmentFile  $assignmentFile
     * @return \Illuminate\Http\Response
     */
    public function edit( AssignmentFile $assignmentFile ) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AssignmentFile  $assignmentFile
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, AssignmentFile $assignmentFile ) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AssignmentFile  $assignmentFile
     * @return \Illuminate\Http\Response
     */
    public function destroy( AssignmentFile $assignmentFile ) {
        
        Storage::delete( $assignmentFile->url );
        $assignmentFile->delete();

        return redirect()->back()->with( "delete", "File deleted successfully" );
    }
}
