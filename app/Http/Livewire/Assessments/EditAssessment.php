<?php

namespace App\Http\Livewire\Assessments;

use App\Models\Assignment;
use Carbon\Carbon;
use Livewire\Component;

class EditAssessment extends Component {

    public $assessments;
    public $assessment;
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
        $this->students = $this->assessment->course->user()->pluck( 'name', 'users.id' );

        $this->form                            = [];
        $this->form['name']                    = $this->assessment->name;
        $this->form['description']             = $this->assessment->description;
        $this->form['start_time']              = Carbon::parse( $this->assessment->start_time )->format( 'd/m/Y h:i a' );
        $this->form['deadline']                = Carbon::parse( $this->assessment->deadline )->format( 'd/m/Y h:i a' );
        $this->form['assignment_id']           = $this->assessment->assignment_id;
        $this->form['is_accepting_submission'] = $this->assessment->is_accepting_submission;
        $this->form['user_id']                 = $this->assessment->user->pluck( 'id' )->toArray();

        $this->assessments = Assignment::all()->pluck( 'title', 'id' );

    }

    public function update() {
        $this->validate();

        $this->form['start_time'] = Carbon::createFromFormat("d/m/Y h:i a", $this->form['start_time'] );
        $this->form['deadline']   = Carbon::createFromFormat("d/m/Y h:i a", $this->form['deadline'] );

        $postTo = $this->form['user_id'];
        unset( $this->form['user_id'] );

        $this->assessment->update( $this->form );

        $this->assessment->user()->sync( $postTo );

        return redirect()->route( 'course.assessments.index', ['course' => $this->assessment->course_id] )->with( "success", "Assessment Updated Successfully" );

    }

    public function render() {
        return view( 'livewire.assessments.edit-assessment' );
    }
}
