<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\AssignmentResponse;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssessmentController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Course $course ) {        
        return view( "ms.assessments.course-assessments", [
            'course' => $course,
        ] );

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( Course $course ) {
        return view( "ms.assessments.create-assessment", [
            'course'   => $course,
            'students' => $course->user()->where( 'users.is_active', 1 )->pluck( 'name', 'users.id' ),
        ] );
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

    public function submit_assessment( Request $request, $assessmnet ) {
        dd( "Hit korse" );
    }

    public function responses( Assessment $assessment ) {
        return view( "ms.assignment-response.assignment-responses", [
            'assessment' => $assessment,
            'min'        => $assessment->responses()->min('marks'),
            'max'        => $assessment->responses()->max('marks'),
            'avg'        => $assessment->responses()->avg('marks'),
        ] );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Assessment  $assessment
     * @return \Illuminate\Http\Response
     */
    public function show( Assessment $assessment ) {
        $this->authorize( 'view', $assessment );

        if ( Auth::user()->role == "Student" ) {
            $assignmentResponse = AssignmentResponse::where( "assessment_id", $assessment->id )
                ->where( "assignment_id", $assessment->assignment->id )
                ->where( "user_id", Auth::user()->id )->first();
        } else {
            $assignmentResponse = null;
        }

        if ( $assignmentResponse != null ) {
            $marks      = $assignmentResponse->marks;
            $totalMarks = $assignmentResponse->assignment->marks;

            $marksOn100      = (int) ceil(  ( $marks / $totalMarks ) * 100 );
            $marksWithout100 = 100 - $marksOn100;

            $pieMarks = [
                'marksOn100'      => $marksOn100,
                'marksWithout100' => $marksWithout100,
            ];

            $isSubmitted = $assignmentResponse->is_submitted;
        } else {
            $pieMarks = [
                'marksOn100'      => 0,
                'marksWithout100' => 0,
            ];

            $isSubmitted = false;
        }

        return view( "ms.assessments.assessment-page", [
            'assessment'         => $assessment,
            'assignmentResponse' => $assignmentResponse,
            'pieMarks'           => $pieMarks,
            'isSubmitted'        => $isSubmitted,
        ] );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Assessment  $assessment
     * @return \Illuminate\Http\Response
     */
    public function edit( Assessment $assessment ) {
        return view( "ms.assessments.edit-assessment", [
            'assessment' => $assessment,
        ] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Assessment  $assessment
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, Assessment $assessment ) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Assessment  $assessment
     * @return \Illuminate\Http\Response
     */
    public function destroy( Assessment $assessment ) {

        $course_id = $assessment->course_id;

        $assessment->responses()->delete();

        $assessment->user()->sync( [] );

        $assessment->files()->delete();

        Storage::deleteDirectory( 'assignments/assessment_' . $assessment->id );

        $assessment->delete();

        return redirect()
            ->route( 'course.assessments.index', ['course' => $course_id] )
            ->with( "delete", "Assessment Deleted Successfully" );
    }

}
