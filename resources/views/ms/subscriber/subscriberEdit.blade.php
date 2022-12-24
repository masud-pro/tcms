@extends('layouts.cms')

@section('title')
    Subcriber
@endsection

@push('styles')
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
    <link href="{{ asset('assets') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
    @livewire('subscriber.subscriber-edit'['subscriptionUser' = $subscriptionUser])
@endsection


@push('scripts')
@endpush
