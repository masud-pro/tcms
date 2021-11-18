@extends('layouts.cms')

@section('title')
    Link for {{ $course->name ?? "" }}
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Create A Link</h6>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route("course.feeds.store-link",["course"=>$course->id]) }}" method="POST">

                    @csrf

                    <label for="name">Name</label>
                    <input value="{{ old("name") }}" name="name" class="form-control" id="name" type="text">
                    @error('name')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label for="link" class="mt-3">link</label>
                    <input type="text" value="{{ old("link") }}" name="link" id="link" class="form-control" />
                    @error('link')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    {{-- <label class="mt-3" for="user_id">Post to</label>
                    <select 
                        class="form-control" 
                        name="user_id[]" 
                        multiple="multiple" 
                        id="user_id"
                    >
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }}</option>
                        @endforeach
                    </select>
                    <a class="small" href="#" id="select_all">Select All</a>
                    @error('user_id')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror --}}


                    <input type="hidden" name="type" value="link">

                    <div class="row">
                        <div class="col text-left">
                            <input type="submit" value="Create" class="btn btn-primary mt-4">
                        </div>
                        <div class="col text-right mt-4">
                            <a href="{{ route("course.feeds.index",['course'=>request()->course]) }}">Go Back</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>    
</div>
    
@endsection

{{-- 
@push('scripts')

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#user_id').select2();
        });

        $('#select_all').click(function(){

            $("#user_id > option").prop("selected","selected");
            $("#user_id").trigger("change");

            return false;
        });


    </script>
@endpush

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush --}}