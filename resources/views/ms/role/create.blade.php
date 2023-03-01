@extends('layouts.cms')

@section('title')
    Role Management
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Create New Role</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('role.store') }}" method="POST">

                        @csrf
                        <div class="row">
                            <div class="offset-md-3 col-md-6">
                                <label for="name">Role Name</label>
                                <input value="{{ old('name') }}" name="name"
                                    class="form-control @error('name') is-invalid @enderror" id="name" type="text">
                                @error('name')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row">

                            <div class="offset-md-3 col-md-6 mt-4">
                                <label class="" for="email">Guard Name</label>
                                <input readonly value="web" name="guard_name"
                                    class="form-control @error('email') is-invalid @enderror" id="email" type="text">
                                @error('email')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        <div class="row">
                            <div class="col text-left">
                                <input type="submit" value="Create" class="btn btn-primary mt-4">
                            </div>
                            <div class="col text-right mt-5">
                                <a href="{{ route('role.index') }}">Go Back</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#batch').select2();
        });
    </script>
@endpush
