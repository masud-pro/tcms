@extends('layouts.cms')

@section('title')
    Subcriber
@endsection

@push('styles')
    <link href="{{ asset('assets') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
    @livewire('subscriber.subscriber-create')
@endsection


@push('scripts')
@endpush
