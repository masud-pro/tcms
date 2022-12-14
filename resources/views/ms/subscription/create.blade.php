@extends('layouts.cms')

@section('title')
    Subscription
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link href="{{ asset('assets') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet"> --}}
@endpush

@section('content')
    @livewire('subscription.create')
@endsection


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#batch').select2();
        });
    </script>
@endpush
