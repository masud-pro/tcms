<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller {

    public function __construct() {
        $this->middleware( 'check_access:exam_question.index', ['only' => ['index']] );
        $this->middleware( 'check_access:exam_question.create', ['only' => ['create', 'store']] );
        $this->middleware( 'check_access:exam_question.edit', ['only' => ['edit', 'update']] );
        $this->middleware( 'check_access:exam_question.destroy', ['only' => ['destroy']] );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view( "ms.assignments.assignment-index", [
            'assignments' => Assignment::latest()->get(),
        ] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view( "ms.assignments.create-assignment" );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {

        $validatedData = $request->validate( [
            "title"    => "required",
            "question" => "required",
            // "type"     => "required",
            "marks"    => "required|numeric",
        ] );

        Assignment::create( $validatedData );

        return redirect()->route( "assignments.index" )->with( "success", "Assignment Created Successfully" );

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Assignment      $assignment
     * @return \Illuminate\Http\Response
     */
    public function edit( Assignment $assignment ) {
        return view( "ms.assignments.edit-assignment", [
            'assignment' => $assignment,
        ] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @param  \App\Models\Assignment      $assignment
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, Assignment $assignment ) {
        $validatedData = $request->validate( [
            "title"    => "required",
            "question" => "required",
            "marks"    => "required|numeric",
        ] );

        $assignment->update( $validatedData );

        return redirect()->back()->with( "success", "Assignment Updated Successfully" );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Assignment      $assignment
     * @return \Illuminate\Http\Response
     */
    public function destroy( Assignment $assignment ) {
        $assessment = $assignment->assessment();

        foreach ( $assessment->get() as $signleAssessment ) {
            $signleAssessment->user()->sync( [] );
            Storage::deleteDirectory( 'assignments/assessment_' . $signleAssessment->id );
        }

        $assessment->delete();
        $assignment->response()->delete();
        $assignment->files()->delete();

        $assignment->delete();

        return redirect()->route( "assignments.index" )->with( "delete", "Assignment Deleted Successfully" );
    }

}
