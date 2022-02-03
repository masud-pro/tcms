

@extends('layouts.cms')

@section('title')
    Authorization Panel
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

        <form method="POST" action="{{ route("course.users.reauthorize",['course'=>request()->course]) }}">
            @csrf
            <input type="submit" value="Reauthorize Students" onclick="return confirm('Are you sure you want to re authorize students')" class="mb-3 btn btn-primary">
        </form>
        
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Authorization Panel</h6>
            </div>
            <div class="card-body pt-4">
                <div class="table-responsive">
                    <form method="POST" action="{{ route("course.users.authorize",['course'=>request()->course]) }}">
                        @csrf
                        @method("PATCH")
                            <table class="table table-hover table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Is Active</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Is Active</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($students as $student)
                                        <tr>
                                            <td>{{ $student->name ?? "Not Found" }}</td>
                                            <td>{{ $student->email ?? "Not Found" }}</td>
                                            <td>
                                                <input type="hidden" name="ids[]" value="{{ $student->id }}">
                                                <div class="custom-control custom-checkbox">
                                                    <input {{ $student->pivot->is_active == 1 ? "checked" : "" }}  name="students[]" value="{{ $student->id }}" type="checkbox" class="custom-control-input" id="customCheck{{ $student->id }}">
                                                    <label class="custom-control-label" for="customCheck{{ $student->id }}">Authorized</label>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <input type="submit" class="btn btn-primary" value="Update">
                                       
                    </form>
                    <div class="text-right">
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