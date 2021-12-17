<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Assignment;
use App\Models\AssignmentFile;
use App\Models\AssignmentResponse;
use App\Notifications\AssessmentResultNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentResponseController extends Controller {
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

    public function allowed_file_types() {
        return [
            'pdf',
            'docx',
            'doc',
            'png',
            'jpg',
            'jpeg',
            'webp',
            'xls',
            'xlsx',
            'txt',
            'giff',
            'mp3',
            'mp4',
            'mpeg',
            'mpg',
            'wav',
            'wav',
            'ppt',
            'pptx',
            'zip',
            'rar',
            'tar',
            '7z',
        ];
    }

    public function upload_files( $files, $data, $response ) {

        $insertFile = [];

        foreach ( $files as $file ) {

            if ( in_array( $file->extension(), $this->allowed_file_types() ) ) {
                $filename = uniqid() . "_" . $file->getClientOriginalName();

                $url = "assignments/" .
                "assessment_" .
                $data['assessment_id'] .
                "/" .
                str_replace( " ", "_", Auth::user()->name ) .
                "_" .
                Auth::user()->id;

                $uploaded = $file->storeAs( $url, $filename );

                $insertFile[] = [
                    'name'                   => $file->getClientOriginalName(),
                    'url'                    => $uploaded,
                    'assignment_response_id' => $response->id,
                    'assignment_id'          => $data['assignment_id'],
                    'assessment_id'          => $data['assessment_id'],
                    'created_at'             => Carbon::now(),
                    'updated_at'             => Carbon::now(),
                ];
            } else {
                return false;
            }

        }

        AssignmentFile::insert( $insertFile );

        return true;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request, $assignment ) {

        $data = $request->validate( [
            "answer"           => "nullable",
            "assessment_id"    => "required|integer",
            "submission_files" => "nullable|array",
        ] );

        $assessment              = Assessment::select( 'id', 'is_accepting_submission' )->findOrFail( $data['assessment_id'] );
        $is_accepting_submission = $assessment->is_accepting_submission;

// Return if not accepting submission
        if ( ! $is_accepting_submission ) {
            return redirect()->back()->with( "failed", "Submission closed" );
        }

// Check files are uploaded or not
        if ( isset( $data['submission_files'] ) ) {
            $files = $data['submission_files'];
            unset( $data['submission_files'] );
        } else {
            $files = null;
        }

        $data['assignment_id'] = $assignment;
        $data['user_id']       = Auth::user()->id;

        // Checking whether submitted earlier or not
        $assignmentResponse = AssignmentResponse::where( "assessment_id", $assessment->id )
            ->where( "assignment_id", $assignment )
            ->where( "user_id", Auth::user()->id )->first();

        if ( $assignmentResponse ) {
            $assignmentResponse->update( [
                'answer' => $data['answer'],
            ] );

            if ( is_array( $files ) ) {
                $uploaded = $this->upload_files( $files, $data, $assignmentResponse );

                if ( ! $uploaded ) {

                    return redirect()->back()->with( "failed", "This type of files are not allowed to upload, Please zip the file" );
                }

            }

        } else {
            $createdResponse = AssignmentResponse::create( $data );

            if ( is_array( $files ) ) {

                $uploaded = $this->upload_files( $files, $data, $createdResponse );

                if ( ! $uploaded ) {
                    return redirect()->back()->with( "failed", "This type of files are not allowed to upload, Please zip the file" );
                }

            }

        }

        return redirect()->back()->with( "success", "Your Assignment Submitted Successfully" );

    }

    public function assignment_mark_done( Request $request ) {
        $data = $request->validate( [
            'assignment_id' => 'required',
            'assessment_id' => 'required',
            'is_submitted'  => 'required',
        ] );

        AssignmentResponse::where( "assessment_id", $data['assessment_id'] )
            ->where( "assignment_id", $data['assignment_id'] )
            ->where( "user_id", Auth::user()->id )->update( [
            'is_submitted' => $data['is_submitted'],
        ] );

        return redirect()->back()->with( "success", "Your Assignment Status Updated" );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AssignmentResponse  $assignmentResponse
     * @return \Illuminate\Http\Response
     */
    public function show( $assignmentResponse ) {
        return view( "ms.assignment-response.single-response", [
            "assignmentResponse" => AssignmentResponse::findOrFail( $assignmentResponse ),
        ] );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AssignmentResponse  $assignmentResponse
     * @return \Illuminate\Http\Response
     */
    public function edit( AssignmentResponse $assignmentResponse ) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AssignmentResponse  $assignmentResponse
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, $assignmentResponse ) {

        $response = AssignmentResponse::findOrFail( $assignmentResponse );
        $data     = $request->validate( [
            'marks'              => ['required', 'numeric', 'min:0', 'max:' . (int) $response->assignment->marks],
            'is_marks_published' => ['nullable'],
        ] );

        if ( isset( $data['is_marks_published'] ) ) {
            $data['is_marks_published'] = 1;

        } else {
            $data['is_marks_published'] = 0;
        }

        $updated = $response->update( $data );

        if ( $updated && $data['is_marks_published'] == 1 ) {
            $result['name'] = $response->assessment->name;
            $result['marks'] = $data['marks'];
            $result['fullmarks'] = $response->assignment->marks;
            $result['url'] = route("assessments.show",['assessment'=>$response->assessment->id]);

            $response->user->notify(new AssessmentResultNotification($result));
        }

        return redirect()->route( "assessment.responses", ['assessment' => $response->assessment->id] )->with( "success", "Marks Updated" );

    }

    public function publish_all_results( Assessment $assessment ) {
        $responses = $assessment->responses()->whereNotNull( 'marks' )->orWhere( "is_marks_published", 0 );

        
        $responses->update( [
            'is_marks_published' => 1,
        ] );

        foreach ($responses->get() as $response) {
            $result['name'] = $response->assessment->name;
            $result['marks'] = $response->marks;
            $result['fullmarks'] = $response->assignment->marks;
            $result['url'] = route("assessments.show",['assessment'=>$response->assessment->id]);

            $response->user->notify(new AssessmentResultNotification($result));
        }

        return redirect()->back()->with( "success", "All marks has been published" );
    }

    public function unpublish_all_results( Assessment $assessment ) {
        $assessment->responses()->whereNotNull( 'marks' )->update( [
            'is_marks_published' => 0,
        ] );

        return redirect()->back()->with( "success", "All marks has been unpublished" );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AssignmentResponse  $assignmentResponse
     * @return \Illuminate\Http\Response
     */
    public function destroy( AssignmentResponse $assignmentResponse ) {
        //
    }

}
