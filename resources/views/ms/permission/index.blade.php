@extends('layouts.cms')

@section('title')
    Role Management
@endsection

@push('styles')
    <link href="{{ asset('assets') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
    <a href="{{ route('administrator.create') }}" class="btn btn-primary mb-3">Add New Role</a>
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


            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">All Role</h6>
                </div>
                <div class="card-body">

                    @livewire('permission.index')

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
