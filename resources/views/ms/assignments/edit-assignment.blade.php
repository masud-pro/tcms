@extends('layouts.cms')

@section('title')
    Edit Assignment
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        @if ( session('success') )
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Edit Assignment</h6>
            </div>
            <div class="card-body">
                <form action="{{ route("assignments.update",['assignment'=> $assignment->id]) }}" method="POST" enctype="multipart/form-data">

                    @csrf
                    @method("PATCH")

                    <label for="title">Assignment Title</label>
                    <input value="{{ old("title") ?? $assignment->title }}" name="title" class="form-control" id="title" type="text">
                    @error('title')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label for="question" class="mt-3">Question</label>
                    <textarea name="question" id="question" rows="15" class="form-control">{!! old("question") ?? $assignment->question !!}</textarea>
                    @error('description')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label for="type" class="mt-3">Type</label>
                    <select value="{{ old("type") }}" name="type" id="type" class="form-control">
                        <option @if( $assignment->type == "Written" ) selected @endif value="Written">Written</option>
                        <option @if( $assignment->type == "File" ) selected @endif value="File">File</option>
                    </select>
                    @error('type')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label for="marks" class="mt-3">Total Marks</label>
                    <input onscroll="return false" value="{{ old("marks") ?? $assignment->marks }}" name="marks" class="form-control" id="marks" type="number">
                    @error('marks')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    {{-- <label for="start_time" class="mt-3">Start Time</label>
                    <input value="{{ old("start_time") }}" name="start_time" class="form-control" id="start_time" type="text">
                    @error('start_time')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label for="deadline" class="mt-3">Deadline</label>
                    <input value="{{ old("deadline") }}" name="deadline" class="form-control" id="deadline" type="text">
                    @error('deadline')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label for="is_accepting_submission" class="mt-3">Submission</label>
                    <label for="type" class="mt-3">Type</label>
                    <select value="{{ old("is_accepting_submission") }}" name="is_accepting_submission" id="is_accepting_submission" class="form-control">
                        <option value="Accept">Accept</option>
                        <option value="Reject">Reject</option>
                    </select>
                    @error('is_accepting_submission')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror


                    <label for="submit_count" class="mt-3">Submit Count</label>
                    <input onscroll="return false" value="{{ old("submit_count") }}" name="submit_count" class="form-control" id="submit_count" type="number">
                    @error('submit_count')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror --}}

                    <div class="row">
                        <div class="col">
                            <input type="submit" value="Update" class="btn btn-primary mt-4">
                        </div>
                        <div class="col text-right mt-5">
                            <a class="mt-4" href="{{ route("assignments.index") }}">Go Back</a>
                        </div>
                    </div>


                </form>

                <div class="text-right mt-4">
                    <form action="{{ route("assignments.destroy",['assignment'=>$assignment->id]) }}" method="POST">
                        @csrf
                        @method("DELETE")
                        <input type="submit" value="Delete" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this assignment?')">
                    </form>
                </div>
            </div>
        </div>
    </div>    
</div>
    
@endsection



@push('scripts')
    <script src="{{ asset("assets/tinymce/tinymce.min.js") }}" referrerpolicy="origin"></script>
    {{-- <script type="text/javascript" src="http://momentjs.com/downloads/moment-with-locales.min.js"></script> --}}
    {{-- <script src="{{ asset("assets/datetimepicker/bootstrap-material-datetimepicker.js") }}"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script> --}}
    <script>

        var editor_config = {
        path_absolute : "/",
        selector: 'textarea#question',
        relative_urls: false,
        plugins: [
            "advlist table autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save directionality",
            "emoticons template paste textpattern"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
        file_picker_callback (callback, value, meta) {
                let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth
                let y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight

                tinymce.activeEditor.windowManager.openUrl({
                url : '/file-manager/tinymce5',
                title : 'Code Ecstasy File manager',
                width : x * 0.8,
                height : y * 0.8,
                onMessage: (api, message) => {
                        callback(message.content, { text: message.text })
                    }
                })
            }
        };

        tinymce.init(editor_config);

        // $('input#start_time').bootstrapMaterialDatePicker({
        //     "shortTime" : true,
        //     "format" : 'DD/MM/YYYY hh:mm a'
        // });

        // $('input#deadline').bootstrapMaterialDatePicker({
        //     "shortTime" : true,
        //     "format" : 'DD/MM/YYYY hh:mm a'
        // });
    </script>
@endpush
{{-- 
@push("styles")
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset("assets/datetimepicker/bootstrap-material-datetimepicker.css") }}">
    <style>
        .dtp table.dtp-picker-days tr > td > a, .dtp .dtp-picker-time > a{
            font-size: 14px
        }
    </style>
@endpush --}}