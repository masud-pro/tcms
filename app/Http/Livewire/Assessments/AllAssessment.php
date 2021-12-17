<?php

namespace App\Http\Livewire\Assessments;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AllAssessment extends Component {

    public $course;
    public $perpage = 15;

    public function loadmore() {
        $this->perpage += 15;
    }

    public function render() {
        $user = Auth::user();

        if ( $user->role == "Admin" ) {
            $assessments = $this->course
                ->assessment()
                ->latest()
                ->take( $this->perpage )
                ->get();

            $total = $this->course
                ->assessment()
                ->count();
        } else {
            $assessments = $user->assessment()
                ->where( "course_id", $this->course->id )
                ->latest()
                ->take( $this->perpage )
                ->get();

            $total = $user->assessment()
                ->where( "course_id", $this->course->id )
                ->count();
        }

        return view( 'livewire.assessments.all-assessment', [
            'assessments' => $assessments,
            'total'       => $total,
        ] );
    }

}
