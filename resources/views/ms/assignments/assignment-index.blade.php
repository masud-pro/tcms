@extends('layouts.cms')

@section('title')
    Assignments
@endsection

@push("styles")
    <link href="{{ asset("assets") }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
{{-- <span class="invalid-feedback" role="alert">
    <strong>The password confirmation does not match.</strong>
</span> --}}

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


        <a class="btn btn-primary mb-4" href="{{ route("assignments.create") }}">Create New Assignment</a>


        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Assignmets</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Marks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Marks</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody> 
                            @foreach ($assignments as $assignment)
                                <tr>
                                    
                                    <td>{{ $assignment->id }}</td>
                                    <td>{{ $assignment->title ?? "" }}</td>
                                    <td>{{ $assignment->type ?? "" }}</td>
                                    <td>{{ $assignment->marks ?? "" }}</td>
                                    <td>
                                        <a class="btn btn-primary" href="{{ route("assignments.edit",['assignment'=>$assignment->id]) }}">Edit</a>
                                        <a class="btn btn-primary" href="{{ route("assignments.show",['assignment'=>$assignment->id]) }}">Show</a>
                                    </td>

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

    <!-- Page level custom scripts -->
    <script src="{{ asset("assets") }}/js/demo/datatables-demo.js"></script>
@endpush