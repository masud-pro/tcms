@extends('layouts.cms')

@section('title')
    Batch / Course
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
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Archived Courses</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Fee</th>
                                <th>Type</th>
                                <th>Subject</th>
                                <th>No of Students</th>
                                <th>Created At</th>
                                <th>Students</th>
                                <th>Feed</th>
                                <th>Restore</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Fee</th>
                                <th>Type</th>
                                <th>Subject</th>
                                <th>No of Students</th>
                                <th>Created At</th>
                                <th>Students</th>
                                <th>Feed</th>
                                <th>Restore</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($courses as $course)
                                <tr>
                                    <td>{{ $course->name }}</td>
                                    <td>{{ $course->fee }}</td>
                                    <td>{{ $course->type }}</td>
                                    <td>{{ $course->subject }}</td>
                                    <td>{{ $course->user ? $course->user()->count() : 0 }}</td>
                                    <td>{{ $course->created_at->format("d-M-Y") }}</td>
                                    <td><a class="btn btn-primary" href="{{ route("course.students",["course"=>$course->id ]) }}">Show Students</a></td>
                                    <td><a class="btn btn-primary" href="{{ route("course.feeds.index",["course"=> $course->id]) }}">Feed</a></td>
                                    <td>
                                        <form action="{{ route("restore.course",["course"=> $course->id]) }}" method="POST">
                                            @csrf
                                            <input type="submit" class="btn btn-success" value="Restore">
                                        </form>
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