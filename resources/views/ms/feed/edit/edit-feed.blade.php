@extends('layouts.cms')

@section('title')
    Edit {{ $feed->name }}
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Edit Post</h6>
            </div>
            <div class="card-body">
                <form action="{{ route("feeds.update",["feed"=>$feed->id]) }}" method="POST">

                    @csrf
                    @method("PATCH")

                    <label for="name">Name</label>
                    <input value="{{ old("name") ?? $feed->name }}" name="name" class="form-control" id="name" type="text">
                    @error('name')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label for="description" class="mt-3">Description</label>
                    <textarea name="description" id="description" rows="10" class="form-control">{!! old("description") ?? $feed->description !!}</textarea>
                    @error('description')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror


                    {{-- <label class="mt-3" for="user_id">Post to</label>
                    <select 
                        class="form-control" 
                        name="user_id[]" 
                        multiple="multiple" 
                        id="user_id"
                    >
                        @foreach ($course->user as $student)
                            @if ( in_array($student->id , $attached_students) )
                                <option selected value="{{ $student->id }}">{{ $student->name }}</option>
                            @else
                                <option value="{{ $student->id }}">{{ $student->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    <a class="small" href="#" id="select_all">Select All</a>
                    @error('user_id')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror --}}


                    <input type="hidden" name="type" value="post">
                    <input type="hidden" name="course_id" value="{{ $course->id }}">

                    <div class="row">
                        <div class="col text-left">
                            <input type="hidden" name="type" value="post">
                            <input type="submit" value="Update" class="btn btn-primary mt-4">
                        </div>
                        <div class="col text-right">
                            @if (request()->feed->course)
                                <a class="d-inline-block mt-4" href="{{ route("course.feeds.index",["course"=>request()->feed->course->id]) }}">Go Back</a>
                            @endif
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>    
</div>
    
@endsection


@push('scripts')

    
    <script src="{{ asset("assets/tinymce/tinymce.min.js") }}" referrerpolicy="origin"></script>
    <script>

    var editor_config = {
    path_absolute : "/",
    selector: 'textarea',
    relative_urls: false,
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save directionality",
        "emoticons template paste textpattern"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
    file_picker_callback (callback, value, meta) {
            let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth
            let y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight

            tinymce.activeEditor.windowManager.openUrl({
            url : '/file-manager/tinymce5',
            title : 'Laravel File manager',
            width : x * 0.8,
            height : y * 0.8,
            onMessage: (api, message) => {
                callback(message.content, { text: message.text })
            }
            })
        }
    };

    tinymce.init(editor_config);

        
    </script>
@endpush

