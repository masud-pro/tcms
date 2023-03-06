@extends('layouts.cms')


@section('title')
    Dashboard
@endsection


@section('content')

    {{-- @if (Auth::user()->role == 'Admin' || (Auth::user()->role == 'Student' && Auth::user()->is_active == 1)) --}}

    @if (auth()->user()->hasRole(['Teacher', 'Super Admin']) ||
            (Auth::user()->role == 'Student' && Auth::user()->is_active == 1))
        <h1 class="h3 mb-4 text-primary">
            Welcome to {{ env('APP_NAME') }} @if ($emoji)
                😀
            @endif
        </h1>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session('full'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('full') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif


        @if (auth()->user()->hasRole(['Super Admin']))
            @livewire('dashboard.admin-dashboard')
        @elseif (auth()->user()->hasRole(['Teacher']))
            @livewire('dashboard.teacher-dashboard')
        @elseif (auth()->user()->hasRole(['Student']))
            @livewire('dashboard.student-dashboard')
        @else
            <div class="container text-center">
                <h2 class="text-primary mt-3">
                    Hello and Welcome to {{ env('APP_NAME') }}
                </h2>
                <h5 class="text-dark mt-4">
                    Your registration to {{ env('APP_NAME') }} is successful. We will review and approve your account very
                    soon. Add all your <b>profile information</b> and add a <b>profile picture</b> to get authorized soon.
                    We will notify you via email when your account status is changed.
                </h5>
                <a href="{{ route('profile.show') }}" class="btn btn-primary text-center mt-3">Update Profile</a>
                <p class="lead mt-3 text-info">To update profile picture just simply upload the profile picture and click on
                    save.</p>
            </div>
        @endif
    @else
        <div class="container text-center">
            <h2 class="text-primary mt-3">
                Hello and Welcome to {{ env('APP_NAME') }}
            </h2>
            <h5 class="text-dark mt-4">
                Your registration to {{ env('APP_NAME') }} is successful. We will review and approve your account very
                soon. Add all your <b>profile information</b> and add a <b>profile picture</b> to get authorized soon.
                We will notify you via email when your account status is changed.
            </h5>
            <a href="{{ route('profile.show') }}" class="btn btn-primary text-center mt-3">Update Profile</a>
            <p class="lead mt-3 text-info">To update profile picture just simply upload the profile picture and click on
                save.</p>
        </div>
    @endif
@endsection

@push('styles')
    <link href="{{ asset('assets') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style>
        #dataTable_info {
            display: none;
        }
    </style>
@endpush

@push('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('assets') }}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "bPaginate": false
            });
        });
    </script>
@endpush
