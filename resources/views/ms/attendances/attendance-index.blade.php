@extends('layouts.cms')

@section('title')
    Attendance
@endsection

@push("styles")
    <link href="{{ asset("assets") }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

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

        {{-- <a class="btn btn-primary mb-4" href="{{ route("course.create") }}">Add Course</a> --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Attendance for {{ \Carbon\Carbon::today()->format('d-M-Y') }}</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <form action="{{ route("attendance.change") }}" method="POST">
                        @csrf
                        @method("PATCH")
                        <table class="table table-hover table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Attendance</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Attendance</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($attendances as $attendance)
                                    <tr>
                                        <td>{{ $attendance->user ? $attendance->user->name : "Not Found" }}</td>
                                        <td>{{ $attendance->user ? $attendance->user->email : "Not Found" }}</td>
                                        <td>
                                            <input type="hidden" name="ids[]" value="{{ $attendance->id }}">
                                            <div class="custom-control custom-checkbox">
                                                <input {{ $attendance->attendance == 1 ? "checked" : "" }}  name="attendance[]" value="{{ $attendance->id }}" type="checkbox" class="custom-control-input" id="customCheck{{ $attendance->id }}">
                                                <label class="custom-control-label" for="customCheck{{ $attendance->id }}">Present</label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <input type="hidden" name="course_id" value="{{ request()->course->id }}">
                        <input type="submit" class="btn btn-primary" value="Submit Attendance">
                        <div class="text-right">
                            <a href="{{ route("course.feeds.index",["course"=>request()->course]) }}">Back</a>
                        </div>
                    </form>
                    
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