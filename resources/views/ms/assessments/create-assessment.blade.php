@extends('layouts.cms')

@section('title')
    Assessment to {{ $course->name ?? "" }}
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Create Assessment</h6>
            </div>
            <div class="card-body">

                @livewire('assessments.create-assessment',[
                    'course' => $course,
                    'students' => $students
                ])

                
            </div>
        </div>
    </div>    
</div>
    
@endsection



