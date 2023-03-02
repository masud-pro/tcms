<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CourseSearch extends Component {

    /**
     * @var mixed
     */
    public $courses;
    /**
     * @var mixed
     */
    public $search;
    /**
     * @var mixed
     */
    public $filteredCourses;

    public function mount() {

        $this->courses = Auth::user()->addedCourses()->with( "user" )->latest()->get();

        $this->filteredCourses = $this->courses;

    }

    /**
     * @return mixed
     */
    public function updatedSearch() {
        if ( $this->search ) {
            $this->filteredCourses = $this->courses->filter( function ( $course ) {
                if ( stristr( $course->name, $this->search ) ) {
                    return true;
                } else {
                    return false;
                }

            } );
        } else {
            $this->filteredCourses = $this->courses;
        }
    }

    public function render() {
        return view( 'livewire.dashboard.course-search' );
    }
}