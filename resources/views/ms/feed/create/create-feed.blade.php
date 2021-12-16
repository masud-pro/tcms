@extends('layouts.cms')

@section('title')
    Post to {{ $course->name ?? "" }}
@endsection

{{-- @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush --}}

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Create A Post</h6>
            </div>
            <div class="card-body">
                <form action="{{ route("course.feeds.store",["course"=>$course->id]) }}" method="POST">

                    @csrf

                    <label for="name">Name</label>
                    <input value="{{ old("name") }}" name="name" class="form-control" id="name" type="text">
                    @error('name')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label for="description" class="mt-3">Description</label>
                    <textarea name="description" id="description" rows="15" class="form-control">{!! old("description") !!}</textarea>
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
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }}</option>
                        @endforeach
                    </select>
                    <a class="small" href="#" id="select_all">Select All</a>
                    @error('user_id')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror --}}

                    <input type="hidden" name="type" value="post">

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

    
</script>
@endpush

