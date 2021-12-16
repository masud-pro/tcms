@extends('layouts.cms')

@section('title')
    Assessments
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


        <div class="row">
            <div class="col">
                @if ( auth()->user()->role == "Admin" )
                    <a class="btn btn-primary mb-4" href="{{ route("course.assessments.create",['course'=>request()->course]) }}">Create New Assessments</a>
                @endif
            </div>
            <div class="col text-right mt-2">
                <a href="{{ route("course.feeds.index",['course'=>request()->course]) }}">Go Back</a>
            </div>
        </div>

        
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Assessments</h6>
            </div>
            <div class="card-body">

                @forelse ($assessments as $assessment)
                    @if ( $assessment->type == "Assignment" )
                        <div class="card mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <div class="m-0 font-weight-bold"> 
                                    <h6 class="m-0 font-weight-bold text-dark">Assignment  @if ( auth()->user()->role == "Admin" ) - Id {{ $assessment->id }} @endif</h6>
                                    <span class="small"> - {{ $assessment->created_at ? $assessment->created_at->format("dS-M-Y h:i A") : "" }}</span>
                                </div>

                                @if ( auth()->user()->role == "Admin" )
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuAssessment"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuAssessment">
                                            {{-- <div class="dropdown-header">Options</div> --}}
                                            <a class="dropdown-item" href="{{ route("assessments.edit",['assessment'=>$assessment->id]) }}">
                                                Edit Asssignment
                                            </a>
                                            <form action="{{ route('assessments.destroy',['assessment'=>$assessment->id]) }}" method="POST">
                                                @csrf
                                                @method("DELETE")
                                                <input type="submit" onclick="return confirm('Are you sure you want to delete this post?')" class="dropdown-item" value="Delete Assessment">
                                            </form>
                                        </div>
                                    </div>
                                @endif
                                
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <h5 class="mt-2 card-title text-dark">{{ $assessment->name }}</h5>
                                <hr>
                                {!! $assessment->description !!}
                                <a href="{{ route("assessments.show",['assessment'=>$assessment->id]) }}" 
                                    target="_blank" class="btn btn-primary mt-3 mb-2">

                                    <i class="fas fa-external-link-alt"></i>
                                    See Assignment
                                </a>     
                                @if ( auth()->user()->role == "Admin" )
                                    <a href="{{ route("assessment.responses",['assessment'=>$assessment->id]) }}" 
                                        class="btn btn-primary mt-3 mb-2">

                                        {{-- <i class="fas fa-external-link-alt"></i> --}}
                                        See Responses
                                    </a>
                                @endif                       
                            </div>
                        </div>
                    @endif
                @empty
                    
                @endforelse

               

                
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