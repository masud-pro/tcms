@extends('layouts.cms')

@section('title')
    Responses
@endsection

@push("styles")
    <link href="{{ asset("assets") }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css" rel="stylesheet">
@endpush

@section('content')

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