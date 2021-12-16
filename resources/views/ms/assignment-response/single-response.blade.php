
@extends('layouts.cms')

@section('title')
    {{ $assignmentResponse->assessment->name }} Answer
@endsection



@section('content')

<div class="row">

    <div class="col-md-8">

        @if ( session('success') )
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if ( session('failed') )
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('failed') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
 
        
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Assignment</h6>
            </div>
            <div class="card-body">
                
                
                    <h3>{{ $assignmentResponse->assignment->title }}</h3>
                    <hr>
                    <div class="mt-5">
                        <h5>Question:</h5>
                        {!! $assignmentResponse->assignment->question !!}
                    </div>

                    <div class="mt-3">
                        <label for="answer"><b>Answer:</b></label>
                        {!! $assignmentResponse->answer ?? "" !!}
                    </div>

            </div>
        </div>
    </div>

    <div class="col-md-4">
        
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Grading</h6>
            </div>
            <div class="card-body">

                <b>Deadline:</b> {{ \Carbon\Carbon::parse($assignmentResponse->assessment->deadline)->format("d-M-Y h:i A")  }} 
               
                    
                <br>
                <b>Submitted at:</b> {{ $assignmentResponse->updated_at->format("d-M-Y h:i A")  }} 
                
                {!! \Carbon\Carbon::parse($assignmentResponse->updated_at)->isBefore($assignmentResponse->assessment->deadline) ? 
                "<span class='ml-2 badge badge-success text-dark'>In Time</span>" :
                "<span class='ml-2 badge badge-danger'>Late</span>" !!} 

                <br>

                <form action="{{ route("response.update",['response'=>$assignmentResponse->id]) }}" method="POST" class="mt-3">
                    @csrf
                    @method("PATCH")

                    <label><b>Marks</b> <span class="small">( out of {{ $assignmentResponse->assignment->marks }} )</span></label>
                    <input type="number" name="marks" value="{{ old("marks") ?? $assignmentResponse->marks }}" min="0" max="{{ $assignmentResponse->assignment->marks }}" class="form-control">
                    @error("marks")
                        <span class="small text-danger">{{ $message }}</span>
                    @enderror

                    <div class="custom-control custom-checkbox mt-3">
                        <input @if($assignmentResponse->is_marks_published) checked @endif type="checkbox" name="is_marks_published" class="custom-control-input" id="customCheck1">
                        <label class="custom-control-label" for="customCheck1">Publish</label>
                    </div>

                    <input type="submit" class="btn btn-primary mt-3" value="Grade">
                </form>
                
            </div>
        </div>

    </div>


</div>

    
@endsection

@push("styles")

@endpush

@push('scripts')

    <script>
        // Disable right click
        document.onkeydown = function(e) {
            if(event.keyCode == 123) { return false; }
            if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) { return false; }
            if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) { return false; }
            if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) { return false; }
            if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) { return false; }
        }
        document.addEventListener('contextmenu', event => event.preventDefault());
  
    </script>
@endpush