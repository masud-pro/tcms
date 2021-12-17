@extends('layouts.cms')

@section('title')
    Responses
@endsection

@push("styles")
    <link href="{{ asset("assets") }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css" rel="stylesheet">
@endpush

@section('content')

<div class="row">
    <div class="col-lg-10">
            
        <form action="{{ route("results.publish",['assessment'=>$assessment->id]) }}" method="POST" class="d-inline">
            @csrf
            @method("PATCH")
            
            <input type="submit" class="btn btn-primary mb-3" value="Publish All Marks"
            onclick="return confirm('Are you sure you want to publish all the marks now?')">
        </form>
        <form action="{{ route("results.unpublish",['assessment'=>$assessment->id]) }}" method="POST" class="d-inline">
            @csrf
            @method("PATCH")

            <input type="submit" class="btn btn-primary mb-3" value="Unpublish All Marks"
            onclick="return confirm('Are you sure you want to unpublish all the marks now?')">
        </form>

        <div class="btn-group mb-3">
            <button 
            class="btn btn-primary dropdown-toggle" 
            type="button" 
            id="dropdownMenuButton" 
            data-toggle="dropdown" 
            aria-haspopup="true" 
            aria-expanded="false">
                Send Results
            </button>

            <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">

                    
            <form class="dropdown-item" action="{{ route("exam.result.sms") }}" method="POST" class="d-inline">
                @csrf

                <input type="hidden" name="assessment_id" value="{{ request()->assessment->id }}">
                <input type="hidden" name="to" value="fathers_phone_no">
                <input type="submit" class="btn btn-link text-dark" value="Send Results To Father"
                onclick="return confirm('Are you sure you want to unpublish all the marks now?')">
            </form>
            <form class="dropdown-item" action="{{ route("exam.result.sms") }}" method="POST" class="d-inline">
                @csrf

                <input type="hidden" name="assessment_id" value="{{ request()->assessment->id }}">
                <input type="hidden" name="to" value="mothers_phone_no">
                <input type="submit" class="btn btn-link text-dark" value="Send Results To Mother"
                onclick="return confirm('Are you sure you want to unpublish all the marks now?')">
            </form>
            <form class="dropdown-item" action="{{ route("exam.result.sms") }}" method="POST" class="d-inline">
                @csrf

                <input type="hidden" name="assessment_id" value="{{ request()->assessment->id }}">
                <input type="hidden" name="to" value="phone_no">
                <input type="submit" class="btn btn-link text-dark" value="Send Results To Student"
                onclick="return confirm('Are you sure you want to unpublish all the marks now?')">
            </form>

                

            </div>
        </div>
    </div>
    <div class="col-lg-2 text-right pt-3 pb-2">
        <a href="{{ route("course.assessments.index",['course'=>request()->assessment->course->id]) }}">Go Back</a>
    </div>
</div>


<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Highest Marks</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $max ?? "Can't calculte yet" }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-double fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Pending Requests Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Average Marks</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $avg ?? "Can't calculte yet" }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

     <!-- Earnings (Annual) Card Example -->
     <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Lowest Marks</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $min ?? "Can't calculte yet" }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-info fa-2x text-gray-300"></i>
                        {{-- <i class="far fa-clock fa-2x text-gray-300"></i> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    
</div>
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
        @if ( session('delete') )
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('delete') }}
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

        <div class="text-right">
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Responses</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Marks</th>
                                <th>Marks Publishment</th>
                                <th>Is Submitted</th>
                                <th>Submitted At</th>
                                <th>Is Late</th>
                                <th class='notexport'>Answer</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Student</th>
                                <th>Marks</th>
                                <th>Marks Publishment</th>
                                <th>Is Submitted</th>
                                <th>Submitted At</th>
                                <th>Is Late</th>
                                <th class='notexport'>Answer</th>
                            </tr>
                        </tfoot>
                        <tbody> 
                            @foreach ($assessment->responses as $response)
                                <tr>
                                    
                                    <td> <a href="{{ route("user.edit",['user'=>$response->user->id]) }}">{{ $response->user->name }}</a></td>
                                    <td>{{ $response->marks ?? "Not Marked" }}</td>
                                    <td>{!! $response->is_marks_published ? "<span class='badge badge-success text-dark'>Published</span>" : "<span class='badge badge-danger'>Not Published</span>" !!}</td>
                                    <td>{!! $response->is_submitted ? "<span class='badge badge-success text-dark'>Submitted</span>" : "<span class='badge badge-danger'>Not Submitted</span>" !!}</td>
                                    <td>{!! $response->updated_at->format("d-M-Y h:i A") !!}</td>
                                    <td>{!! \Carbon\Carbon::parse($response->updated_at)->isBefore($response->assessment->deadline) ? "<span class='badge badge-success text-dark'>In Time</span>" : "<span class='badge badge-danger'>Late</span>" !!}</td>
                                    <td><a class="btn btn-primary" href="{{ route("response.show",['response'=>$response->id]) }}">Show Answer</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

    
@endsection


@push('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset("assets") }}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset("assets") }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>

    <!-- Page level custom scripts -->
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    // 'copy', 
                    'csv', 
                    'excel', 
                    'pdf', 
                    // 'print'
                ],
                // "paging": false,
            });
        });

    </script>
@endpush