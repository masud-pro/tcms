@extends('layouts.cms')

@section('title')
    My Courses
@endsection

@push("styles")
    <link href="{{ asset("assets") }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
{{-- <span class="invalid-feedback" role="alert">
    <strong>The password confirmation does not match.</strong>
</span> --}}
@if ( session('success') )
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if ( session('full') )
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('full') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<div class="row">
    <div class="col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">My Courses</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    @forelse ($courses as $course)
                    <div class="col-md-4">
                        <div class="card">

                            <img class="card-img-top" height="250px" src="{{ $course->image ? asset("storage/".$course->image) : asset("images/default-banner.jpg") }}" alt="Card image cap">

                            <div class="card-body">

                                <h5 class="card-title text-dark">{{ $course->name }}</h5>
                                <p class="card-text">
                                    {{ Illuminate\Support\Str::words( $course->description ,10) }}
                                    @if (Illuminate\Support\Str::wordCount( $course->description) > 10)   
                                        <a data-toggle="collapse" href="#collapseExample{{ $course->id }}" role="button" aria-expanded="false" aria-controls="collapseExample">Read More</a>
                                    @endif
                                </p>
                                <div class="collapse" id="collapseExample{{ $course->id }}">
                                    <div class="card card-body">
                                        {{ $course->description }}
                                    </div>
                                </div>

                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Time: <span class="text-primary font-weight-bold">{{ $course->time }}</span></li>
                                <li class="list-group-item">Subject: <span class="text-primary font-weight-bold">{{ $course->subject }}</span></li>
                                <li class="list-group-item">Fee: <span class="text-primary font-weight-bold">{{ $course->fee }}</span></li>
                            </ul>
                            <div class="card-body">
                                {{-- <a href="#" class="card-link float-left">Enroll</a> --}}
                                <a href="{{ route("course.feeds.index",['course'=>$course->id]) }}" class="card-link btn btn-success font-weight-bold btn-block">Go To Feed</a>
                            </div>
                        </div> 
                    </div>
                    @empty
                        No Course Found
                    @endforelse
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