@extends('layouts.cms')

@section('title')
    Batch / Course
@endsection

@push('styles')
    <link href="{{ asset('assets') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (session('delete'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('delete') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row">
                <div class="col">
                    <a class="btn btn-primary mb-4" href="{{ route('course.create') }}">Add Course</a>
                </div>
                <div class="col text-right">
                    <a class="btn btn-info mb-4" href="{{ route('archived.course') }}">Archived Courses</a>
                </div>
            </div>

            <div class="text-right">
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">All Courses</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Fee</th>
                                    <th>Type</th>
                                    <th>Subject</th>
                                    <th>Capacity</th>
                                    <th>Students</th>
                                    <th>Created At</th>
                                    <th>Feed</th>
                                    <th>Actions</th>
                                    <th>Students</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Fee</th>
                                    <th>Type</th>
                                    <th>Subject</th>
                                    <th>Capacity</th>
                                    <th>Students</th>
                                    <th>Created At</th>
                                    <th>Feed</th>
                                    <th>Actions</th>
                                    <th>Students</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($courses as $course)
                                    <tr>

                                        <td>{!! $course->image
                                            ? "<a href='" . Storage::url($course->image) . "'><img width='100' src='" . Storage::url($course->image) . "' />"
                                            : '' !!}</td>
                                        <td>{{ $course->name ?? '' }}</td>
                                        <td>{{ $course->fee ?? '' }}</td>
                                        <td>{{ $course->type ?? '' }}</td>
                                        <td>{{ $course->subject ?? '' }}</td>
                                        <td>{{ $course->capacity ?? '' }}</td>
                                        <td>{{ $course->user ? $course->user()->count() : 0 }}</td>
                                        <td>{{ $course->created_at->format('d-M-Y') }}</td>
                                        <td><a class="btn btn-primary"
                                                href="{{ route('course.feeds.index', ['course' => $course->id]) }}">Feed</a>
                                        </td>
                                        <td><a class="btn btn-primary"
                                                href="{{ route('course.edit', ['course' => $course->id]) }}">Edit</a></td>
                                        <td><a class="btn btn-primary"
                                                href="{{ route('course.students', ['course' => $course->id]) }}">Students</a>
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
    <script src="{{ asset('assets') }}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('assets') }}/js/demo/datatables-demo.js"></script>
@endpush
