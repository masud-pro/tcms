@extends('layouts.cms')

@section('title')
    Students {{ $course->name ? "from " . $course->name : "" }}
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

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Students {{ $course->name ? "from " . $course->name : "" }}</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                @if ( Auth::user()->role == "Admin" )
                                    <th>ID</th>
                                @endif
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                @if ( Auth::user()->role == "Admin" )
                                    <th>Class</th>
                                    <th>Phone No</th>
                                    <th>Fathers No</th>
                                    <th>Mothers No</th>
                                    <th>Batch / Course</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                @if ( Auth::user()->role == "Admin" )
                                    <th>ID</th>
                                @endif
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                @if ( Auth::user()->role == "Admin" )
                                    <th>Class</th>
                                    <th>Phone No</th>
                                    <th>Fathers No</th>
                                    <th>Mothers No</th>
                                    <th>Batch / Course</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                @endif
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    @if ( Auth::user()->role == "Admin" )
                                        <td>{{ $user->id ?? "Not Found" }}</td>
                                    @endif
                                    <td class="text-center">
                                        @if ( Auth::user()->role == "Admin" )
                                            <a target="_blank" href="{{ $user->profile_photo_url ?? "" }}">
                                                <img width="40" class="img-profile rounded-circle" src="{{ $user->profile_photo_url ?? "" }}">
                                            </a>
                                        @else
                                            <img width="40" class="img-profile rounded-circle" src="{{ $user->profile_photo_url ?? "" }}">
                                        @endif
                                    </td>
                                    <td><b>{{ $user->name ?? "Not Found" }}</b></td>
                                    <td>{{ $user->email ?? "Not Found" }}</td>
                                    @if ( Auth::user()->role == "Admin" )
                                        <td>{{ $user->class ?? "Not Found" }}</td>
                                        <td>{{ $user->phone_no }}</td>
                                        <td>{{ $user->fathers_phone_no ?? "Not Found" }}</td>
                                        <td>{{ $user->mothers_phone_no ?? "Not Found" }}</td>
                                        <td>
                                            @forelse ($user->course as $course)
                                                <b>
                                                    <a href="{{ route("course.feeds.index",["course"=>$course->id]) }}"
                                                        class="text-secondary">
                                                        {{ $course->name . ", " }}
                                                    </a>
                                                </b>
                                            @empty
                                                {{ "Not Found" }}
                                            @endforelse
                                        </td>
                                        <td>{{ $user->created_at->format("d-M-Y") }}</td>
                                        <td>
                                            <a class="btn btn-primary" href="{{ route("user.edit",[ 'user' => $user->id ]) }}" target="_blank">Edit</a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-right mt-4">
                        <a href="{{ route("course.feeds.index",['course'=>request()->course]) }}">Go Back</a>
                    </div>
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
