@extends('layouts.cms')

@section('title')
    {{ $assessment->name }}
@endsection



@section('content')

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
    @endforeach
@endif

<div class="row">

    <div class="col-12">
        @if (  \Carbon\Carbon::now()->isAfter(  $assessment->start_time  ) )
            <div id="flipdown" class="flipdown mx-auto mb-5"></div>
        @endif
    </div>

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
        @if ( session('delete') )
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('delete') }}
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
                
                
                @if (  \Carbon\Carbon::now()->isAfter(  $assessment->start_time  ) )
                    <h3>{{ $assessment->name }}</h3>
                    <hr>
                    <div>
                        {!! $assessment->assignment->question !!}
                    </div>

                    <form class="mt-5" method="POST" enctype="multipart/form-data" 
                        action="{{ route("assignment.response.store",["assignment"=>$assessment->assignment->id]) }}">

                        @csrf

                        @if ( 
                            auth()->user()->role == "Admin" ||
                            ( $assessment->is_accepting_submission && !$isSubmitted )
                            
                        )
                            <label for="answer"><b>Your Answer Here:</b></label>
                            
                            <textarea name="answer" id="answer" rows="20" class="form-control">
                                {{ $assignmentResponse->answer ?? "" }}
                            </textarea>

                            <label class="mt-5"><b>Files:</b></label>

                            <ul class="list-unstyled ul-list-file">
                                <li>
                                    <input type="file" name="submission_files[]" class="form-control-file submission-files mt-1 mb-2">
                                </li>
                            </ul>
                            
                            <a href="#" id="add-file">Add more</a>

                            <input type="hidden" name="assessment_id" value="{{ $assessment->id }}">

                            @if ( auth()->user()->role == "Admin" )
                                <p class="mt-4">Only students can submit answer</p>
                            @else
                                <input type="submit" value="Submit" class="text-right btn btn-primary mt-4 d-block ml-auto" 
                                onclick="return confirm('Are you sure you want to submit now?')">
                            @endif
                        @else
                            <div>
                                <label for="answer"><b>Your Answer:</b></label>
                                {!! $assignmentResponse->answer ?? "" !!}
                            </div>
                        @endif

                        @if ( !$assessment->is_accepting_submission )
                            <h5 class="text-danger text-center mt-5">
                                This assignment is not accepting submission
                            </h5>
                        @endif
                        
                @else
                    <div class="text-center">
                        <b>
                            The assignment will start at {{ \Carbon\Carbon::parse($assessment->start_time)->format('d/M/Y h:i A') }}
                        </b>
                    </div>
                @endif

                
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Submission
                </h6>
            </div>
            <div class="card-body">

                <p>
                    <b>Full Marks:</b>  {!! $assessment->assignment->marks !!}
                </p>

                @if ($assignmentResponse && $assignmentResponse->is_marks_published)
                    <div class="text-center">
                        <b style="font-size: 26px">Your Grade: {{ $assignmentResponse->marks }}</b> 
                        <span class="small">(out of {{ $assessment->assignment->marks }})</span>
                    </div>
                    <div class="chart-pie pt-4 pb-2 mb-5">
                        <canvas id="myPieChart"></canvas>
                    </div>
                @endif
                
                <ul class="list-unstyled mb-5">
                    @if ($assignmentResponse != null)
                        <li class="mt-2">
                            <b>
                                Submission - {{ $assignmentResponse->updated_at->format("d-m-Y h:i A") }}
                                @if ( \Carbon\Carbon::parse($assignmentResponse->updated_at)->isAfter($assessment->deadline) )
                                    <span class="text-danger">(Late)</span>
                                @endif
                            </b>
                        </li> 
                    @endif
                </ul>

                
                <ul>
                    @if ($assignmentResponse != null)
                        @if ($assignmentResponse->files->count() > 0 )
                            <b>Files:</b>
                            @forelse ($assignmentResponse->files as $file)
                                <li class="my-3">
                                    <a target="_blank" href="{{ Storage::url( $file->url ) }}">
                                        {{ $file->name }}
                                    </a> 
                                    @if ( $assessment->is_accepting_submission && !$isSubmitted )
                                    - 
                                    <form class="d-inline" method="POST"
                                        action="{{ route("assignment.file.destroy",['assignmentFile'=> $file->id]) }}">

                                        @csrf
                                        @method("DELETE")
                                        <input onclick="return confirm('Are you sure you want to delte the file?')" type="submit" class="btn btn-danger btn-sm" value="Delete">

                                    </form>
                                    @endif
                                </li>
                            @empty
                                
                            @endforelse
                        @endif
                    @endif
                </ul>



                <div class="text-right">
                    @if ( auth()->user()->role == "Student" )    
                        <form action="{{ route("assignment.mark-done") }}" method="POST">
                            @csrf
                            @method("PATCH")
                            <input type="hidden" name="assessment_id" value="{{ $assessment->id }}">
                            <input type="hidden" name="assignment_id" value="{{ $assessment->assignment->id }}">
                            <input type="hidden" name="is_submitted" value="{{ $assignmentResponse && $assignmentResponse->is_submitted == 1 ? 0 : 1 }}">
                            <input {{ !$assignmentResponse ? "disabled" : "" }} type="submit" class="btn btn-success mt-5 mb-2 text-dark" value=" {{ $assignmentResponse && $assignmentResponse->is_submitted == 1 ? "Mark Unone" : "Mark as Done" }} "><br>
                            {!! !$assignmentResponse ? "<span class='small text-info'>Submit Before You Mark as Done</span>" : "" !!}
                            
                        </form>
                    @endif
                </div>
                
            </div>
        </div>

    </div>


</div>

    
@endsection

@push("styles")
    <link rel="stylesheet" href="{{ asset("assets/flipdown/flipdown.min.css") }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
    <script src="{{ asset("assets/flipdown/flipdown.min.js") }}"></script>
    <script src="{{ asset("assets/tinymce/tinymce.min.js") }}" referrerpolicy="origin"></script>
    <script src="{{ asset("assets/vendor/chart.js/Chart.min.js") }}"></script>
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

        new FlipDown({{ \Carbon\Carbon::parse($assessment->deadline)->timestamp }}).start();

        $(document).ready(function(){

            var editor_config = {
            path_absolute : "/",
            selector: 'textarea#answer',
            relative_urls: false,
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars fullscreen",
                "insertdatetime media nonbreaking save directionality",
                "emoticons template paste textpattern"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link",
            
            };       

            tinymce.init(editor_config);

            $('#add-file').click(function(e){
                e.preventDefault();

                $('.ul-list-file').append('<li><input type="file" name="submission_files[]" class="form-control-file submission-files mt-1 mb-2"></li>');
            });


            // Set new default font family and font color to mimic Bootstrap's default styling
            Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#858796';
            
            // Pie Chart Example
            var ctx = document.getElementById("myPieChart");
            var myPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ["Gained Marks", "Remain"],
                datasets: [{
                    data: [{{ $pieMarks['marksOn100'] }}, {{ $pieMarks['marksWithout100'] }}],
                    backgroundColor: ['#1cc88a', '#4e73df'],
                    hoverBackgroundColor: ['#17a673','#2e59d9'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
                },
                legend: {
                display: false
                },
                cutoutPercentage: 80,
            },
            });


        });
  
    </script>
@endpush