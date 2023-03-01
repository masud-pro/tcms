<?php

namespace App\Http\Controllers;

use App\Models\AssignmentFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssignmentFileController extends Controller {

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