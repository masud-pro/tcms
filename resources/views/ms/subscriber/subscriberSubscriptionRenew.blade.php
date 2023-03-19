@extends('layouts.cms')

@section('title')
    Renew
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

            @if (session('renew'))
                <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                    {{ session('renew') }}
                </div>
            @endif


            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Renew Your Subscription</h6>
                </div>
                <div class="card-body">

                    @livewire('subscriber.subscription-renew')

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
