<?php

namespace App\Http\Livewire\Attendance;

use App\Models\Course;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;


class TakeAttendance extends Component {

    public $batches;
    public $search;
    public $filteredBatches;

    public function mount() {
        $this->batches = cache()->remember( 'course', 60 * 60, function () {
            return Auth::user()->addedCourses()->latest()->get();
        } );

        $this->filteredBatches = $this->batches;

    }

    public function updatedSearch() {

        if ( $this->search ) {
            $this->filteredBatches = $this->batches->filter( function ( $batch ) {

                if ( stristr( $batch->name, $this->search ) ) {
                    return true;
                }

                return false;
            } );
        } else {
            $this->filteredBatches = $this->batches;
        }

    }

    public function render() {
        return view( 'livewire.attendance.take-attendance' );
    }
}
