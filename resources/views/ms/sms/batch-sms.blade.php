@extends('layouts.cms')

@section('title')
    Send Batch SMS
@endsection

@section('content')
@if ( session('failed') )
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('failed') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Send SMS</h6>
            </div>
            <div class="card-body">
                <form action="" method="POST">

                    @csrf

                    <label for="for">SMS For</label>
                    <input value="{{ old("for") }}" name="for" class="form-control" id="for" type="text">
                    @error('for')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label for="course_id" class="mt-3">Course</label>
                    <select class="form-control" name="course_id">
                        @forelse ($courses as $key => $course)
                            <option value="{{ $key }}">{{ $course }}</option>
                        @empty
                            
                        @endforelse
                    </select>
                    @error('course_id')
                        <p class="text-danger small mt-1">{{ $course_id }}</p>
                    @enderror

                    <label for="send_to" class="mt-3">SMS to</label>
                    <select class="form-control" name="send_to">
                        <option value="phone_no">Students</option>
                        <option value="fathers_phone_no">Father</option>
                        <option value="fathers_phone_no">Mother</option>
                    </select>
                    @error('send_to')
                        <p class="text-danger small mt-1">{{ $course_id }}</p>
                    @enderror

                    <label for="message" class="mt-3">Message</label>
                    <textarea name="message" id="message" rows="2" class="form-control">{!! old("message") !!}</textarea>
                    <p id="count" class="text-info small mt-1">160 characters count 1 SMS, if your character count is more than 160 it will count as 2 SMS (For bangla SMS you will be charged more)</p>
                    @error('message')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <div class="row">
                        <div class="col text-left">
                            <input type="submit" value="Send" class="btn btn-primary mt-4">
                        </div>
                        <div class="col text-right mt-4">
                            {{-- <a href="{{ route("course.feeds.index",['course'=>request()->course]) }}">Go Back</a> --}}
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>    
</div>
    
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $('#message').on("input",function(){
                var message = $('#message').val();
                var numberOrSMS = Math.ceil( message.length / 160 );
                $('#count').text("SMS Count: " + numberOrSMS);
            }); 
        });
    </script>
@endpush


