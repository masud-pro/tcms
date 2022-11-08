<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Course;
use Livewire\Component;

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
        // $this->courses = cache()->remember( 'course', 60 * 60, function () {
        //     Course::with( "user" )->get();

        // } );

        $this->courses = Course::with( "user" )->get();

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
        // dd( $this->filteredCourses );
    }

    public function render() {
        return view( 'livewire.dashboard.course-search' );
    }
}