@extends('layouts.cms')

@section('title')
    Batch / Course
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        {{-- @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}
        @if ( session('success') )
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Create Course</h6>
            </div>
            <div class="card-body">
                <form action="{{ route("course.update",["course"=>$course->id]) }}" method="POST" enctype="multipart/form-data">

                    @csrf
                    @method("PATCH")

                    <label for="name">Course Name</label>
                    <input value="{{ old("name") ?? $course->name }}" name="name" class="form-control" id="name" type="text">
                    @error('name')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label for="description" class="mt-3">Description</label>
                    <textarea name="description" id="description" rows="2" class="form-control">{!! old("description") ?? $course->description !!}</textarea>
                    @error('description')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label for="fee" class="mt-3">Fee</label>
                    <input value="{{ old("fee") ?? $course->fee }}" name="fee" class="form-control" id="fee" type="number">
                    @error('fee')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label for="type" class="mt-3">Type</label>
                    <select value="{{ old("type") ?? $course->type }}" name="type" id="type" class="form-control">
                        <option value="Monthly">Monthly</option>
                        <option value="One Time">One Time</option>
                    </select>
                    @error('type')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label for="time" class="mt-3">Course Date and Time</label>
                    <input value="{{ old("time") ?? $course->time }}" name="time" class="form-control" id="time" type="text">
                    @error('time')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label for="capacity" class="mt-3">Capacity</label>
                    <input onscroll="return false" value="{{ old("capacity") ?? $course->capacity }}" name="capacity" class="form-control" id="capacity" type="number">
                    @error('capacity')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror


                    <label for="section" class="mt-3">Section</label>
                    <input value="{{ old("section") ?? $course->section }}" name="section" class="form-control" id="section" type="text">
                    @error('section')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label for="subject" class="mt-3">Subject</label>
                    <input value="{{ old("subject") ?? $course->subject }}" name="subject" class="form-control" id="subject" type="text">
                    @error('subject')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label for="room" class="mt-3">Room no</label>
                    <input value="{{ old("room") ?? $course->room }}" name="room" class="form-control" id="room" type="text">
                    @error('room')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label for="address" class="mt-3">Address</label>
                    <textarea name="address" id="address" rows="1" class="form-control">{{ old("address") ?? $course->address }}</textarea>
                    @error('address')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label for="address" class="mt-3">Image</label>
                    <input onchange="readURL(this);" name="image" type="file" class="form-control-file">
                    <div class="small">A landscape image is preferable</div>
                    <img width="200" id="batchImage" class="mt-3" src="{{ $course->image ? asset("storage/".$course->image) : "" }}" alt=""> <br>


                    <div class="row">
                        <div class="col text-left">
                            <input type="submit" value="Update" class="btn btn-primary mt-4">
                        </div>
                    </form>
                        <div class="col text-right">
                            <form action="{{ route("course.destroy",["course"=>$course->id]) }}" method="POST">
                                @csrf
                                @method("DELETE")
                                <input type="submit" onclick="return confirm('Are you sure you want to delete {{ $course->name }}?')" value="Archive Course" class="btn btn-danger mt-4">
                            </form>
                        </div>
                    </div>

                
            </div>
        </div>
    </div>    
</div>
    
@endsection



@push('scripts')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#batchImage')
                        .attr('src', e.target.result)
                        .width(200);
                        // .height(250);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush

