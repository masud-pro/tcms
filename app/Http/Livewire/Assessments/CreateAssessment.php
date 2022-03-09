<?php

namespace App\Http\Livewire\Assessments;

use App\Models\Assessment;
use App\Models\Assignment;
use App\Models\User;
use App\Notifications\Assessment\CreateAssessment as AssessmentCreateAssessment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class CreateAssessment extends Component {

    public $course;
    public $assessments;
    public $students;
    public $form;
    public $user_id;

    protected $rules = [
        'form.name'                    => 'required',
        'form.description'             => 'nullable',
        'form.user_id'                 => 'required|array',
        'form.start_time'              => 'required',
        'form.is_accepting_submission' => 'required',
        'form.deadline'                => 'required',
        'form.assignment_id'           => 'required|integer',
    ];

    public function mount() {
        $this->form                            = [];
        $this->form['is_accepting_submission'] = 1;
        $this->form['type']                    = "Assignment";
        $this->assessments                     = Assignment::all()->pluck( 'title', 'id' );
    }

    public function create() {
        $this->validate();

        $this->form['start_time'] = Carbon::createFromFormat( "d/m/Y h:i a", $this->form['start_time'] );
        $this->form['deadline']   = Carbon::createFromFormat( "d/m/Y h:i a", $this->form['deadline'] );

        $postTo = $this->form['user_id'];
        unset( $this->form['user_id'] );

        $this->form['course_id'] = $this->course->id;

        $assessment = Assessment::create( $this->form );

        $assessment->user()->sync( $postTo );

        if ( $assessment ) {
            $notificationInfromation['courseName'] = $this->course->name;
            $notificationInfromation['url']        = route( "course.assessments.index", ['course' => $this->course->id] );

            Notification::send(
                User::whereIn( 'id', $postTo )->get(),
                new AssessmentCreateAssessment( $notificationInfromation )
            );
        }

        return redirect()->route( 'course.assessments.index', ['course' => $this->course->id] )->with( "success", "Assessment Created Successfully" );

    }

    public function render() {
        $this->dispatchBrowserEvent( 'contentChanged' );
        return view( 'livewire.assessments.create-assessment' );
    }

}
