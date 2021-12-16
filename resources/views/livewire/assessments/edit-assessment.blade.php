<div>
    
    <form wire:submit.prevent="update">

        @csrf

        <label for="name">Name</label>
        <input value="{{ old("name") }}" wire:model.defer="form.name" class="form-control" 
            id="name" type="text">
        @error('name')
            <p class="text-danger small mt-1">{{ $message }}</p>
        @enderror
        
        <div wire:ignore>
            
            <label for="description" class="mt-3">Description</label>
            <textarea id="description" rows="15" class="form-control">
                {!! old("description") ?? $form['description'] !!}
            </textarea>

            @error('description')
                <p class="text-danger small mt-1">{{ $message }}</p>
            @enderror
       
            <label class="mt-3" for="user_id">Post to</label>
            <select 
                class="form-control" 
                multiple="multiple" 
                id="user_id"
            >
                @foreach ($students as $id => $name)

                    @if ( in_array( $id, $form['user_id']) )  

                        <option selected value="{{ $id }}">{{ $name }}</option>

                    @else

                        <option value="{{ $id }}">{{ $name }}</option>

                    @endif

                @endforeach
            </select>
            <a class="small" href="#" id="select_all">Select All</a> <br>

            @error('user_id')
                <p class="text-danger small mt-1">{{ $message }}</p>
            @enderror

            <label class="mt-3" for="assessment">Post to</label>
            <select 
                class="form-control"
                id="assessment"
            >
                <option>Select Assessment</option>

                @foreach ($assessments as $key => $s_assessment)
                    @if ( $assessment->assignment_id == $key )

                        <option selected value="{{ $key }}">{{ $key }} - {{ $s_assessment }}</option>
                    @else

                        <option value="{{ $key }}">{{ $key }} - {{ $s_assessment }}</option>
                    @endif
                @endforeach

            </select>

            @error('assessment')
                <p class="text-danger small mt-1">{{ $message }}</p>
            @enderror

            <label for="start_time" class="mt-3">Start Time</label>
            <input value="{{ old("start_time") }}" wire:model="form.start_time" class="form-control" 
                id="start_time" type="text">

            @error('start_time')
                <p class="text-danger small mt-1">{{ $message }}</p>
            @enderror

            <label for="deadline" class="mt-3">Deadline</label>
            <input value="{{ old("deadline") }}" wire:model="form.deadline" class="form-control" 
                id="deadline" type="text">

            @error('deadline')
                <p class="text-danger small mt-1">{{ $message }}</p>
            @enderror

        </div>

        <label for="is_accepting_submission" class="mt-3">Submission</label>

        <select value="{{ old("is_accepting_submission") }}" wire:model.defer="form.is_accepting_submission" 
            id="is_accepting_submission" class="form-control">

            <option value="1">Accept</option>
            <option value="0">Reject</option>

        </select>

        @error('is_accepting_submission')
            <p class="text-danger small mt-1">{{ $message }}</p>
        @enderror


        {{-- <label for="submit_count" class="mt-3">Submit Count</label>
        <input onscroll="return false" value="{{ old("submit_count") }}" wire:model="form.submit_count" 
            class="form-control" id="submit_count" type="number">
        @error('submit_count')
            <p class="text-danger small mt-1">{{ $message }}</p>
        @enderror --}}

        @if ($errors->any())

            <div class="alert alert-danger mt-4">
                <li>Please fillup all the fields</li>
            </div>

        @endif

        <div class="row">

            <div class="col text-left">
                <input type="submit" value="Update Assessment" class="btn btn-primary mt-4">
            </div>

            <div class="col text-right mt-4">
                <a href="{{ route("course.assessments.index",['course'=>$assessment->course_id]) }}">
                    Go Back
                </a>
            </div>

        </div>
    </form>

    <form method="POST" action="{{ route('assessments.destroy',['assessment'=>$assessment->id]) }}" class="text-center">

        @csrf
        @method("DELETE")

        <input type="submit" class="btn btn-danger" value="Delete Assessment" 
            onclick="return confirm('Are you sure you want to delete this assessment')">

    </form>
</div>

@push('styles')
    @livewireStyles()
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset("assets/datetimepicker/bootstrap-material-datetimepicker.css") }}">
    <style>
        .dtp table.dtp-picker-days tr > td > a, .dtp .dtp-picker-time > a{
            font-size: 14px
        }
    </style>
@endpush
@push('scripts')
    @livewireScripts()
    <script src="{{ asset("assets/tinymce/tinymce.min.js") }}" referrerpolicy="origin"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript" src="http://momentjs.com/downloads/moment-with-locales.min.js"></script> 
    <script src="{{ asset("assets/datetimepicker/bootstrap-material-datetimepicker.js") }}"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    
    <script>

        $(document).ready(function(){

            var editor_config = {
            path_absolute : "/",
            selector: 'textarea#description',
            relative_urls: false,
            setup: function(editor) {
                editor.on('change', function(e) {
                    @this.set('form.description',e.level.content);
                });
            },
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

            

        });
  
    </script>

<script>
    $(document).ready(function(){


        $('#assessment').select2();

        $('#user_id').select2();
        
        $("#select_all").click(function(){
            
            $("#user_id > option").prop("selected","selected"); // Select All Options
            $("#user_id").trigger("change"); // Trigger change to select 2

            return false;
            
        });

        
        $('#user_id').change(function(){
            var users = $('#user_id').val();
            @this.set('form.user_id',users);
        });

        $('#assessment').change(function(){
            var assessment = $('#assessment').val();
            @this.set('form.assignment_id',assessment);
        });

        $('#start_time').change(function(){
            var start_time = $('#start_time').val();
            @this.set('form.start_time',start_time);
        });

        $('#deadline').change(function(){
            var deadline = $('#deadline').val();
            @this.set('form.deadline',deadline);
        });

        $('input#start_time').bootstrapMaterialDatePicker({
            "shortTime" : true,
            "format" : 'DD/MM/YYYY hh:mm a'
        });

        $('input#deadline').bootstrapMaterialDatePicker({
            "shortTime" : true,
            "format" : 'DD/MM/YYYY hh:mm a'
        });


        
    });
        
</script>

@endpush


