

@extends('layouts.cms')

@section('title')
    Overall Accounts
@endsection

@push("styles")
    <link href="{{ asset("assets") }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')

{{-- <a href="" class="btn btn-primary mb-3">Add Accounts</a> --}}
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
        
        @livewire("account.overall-account")

        
    </div>
</div>

    
@endsection


@push('scripts')

@endpush