@extends('layouts.cms')

@section('title')
    Course Generate Payments Settings
@endsection

@push("styles")
    {{-- <link href="{{ asset("assets") }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet"> --}}
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
                <h6 class="m-0 font-weight-bold text-primary">Select Which Course Should Generate Payments</h6>
            </div>
            <div class="card-body">
                <table class="table table-hover table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Courses</th>
                            <th>Should Generate Payments</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Courses</th>
                            <th>Should Generate Payments</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($courses as $course)
                            <tr>
                                <td>{{ $course->name }}</td>
                                <td>
                                    {{-- <form action="{{ route("course.generate-payments") }}" method="POST"> --}}
                                    <form action="{{ route("settings.change-course-generate-payments") }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                                        <input type="hidden" name="should_generate_payments" value="{{ $course->should_generate_payments }}">
                                        <input type="submit" class="btn btn-{{ $course->should_generate_payments ? "success" : "danger" }}" value="{{ $course->should_generate_payments ? "Yes" : "No" }}">
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

    
@endsection


@push('scripts')
    
@endpush
