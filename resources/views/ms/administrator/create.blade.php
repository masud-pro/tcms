@extends('layouts.cms')

@section('title')
    Administrators
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Create New User</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('administrator.store') }}" method="POST">

                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <label for="name">User Name</label>
                                <input value="{{ old('name') }}" name="name"
                                    class="form-control @error('name') is-invalid @enderror" id="name" type="text">
                                @error('name')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="" for="email">User Email</label>
                                <input value="{{ old('email') }}" name="email"
                                    class="form-control @error('email') is-invalid @enderror" id="email" type="text">
                                @error('email')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="phone_no">Phone Number</label>
                                <input value="{{ old('phone_no') }}" name="phone_no"
                                    class="form-control @error('phone_no') is-invalid @enderror" id="phone_no"
                                    type="text">
                                @error('phone_no')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        <div class="row">


                            <div class="col-md-4">
                                <label class="mt-3" for="dob">Date of Birth</label>
                                <input value="{{ old('dob') }}" name="dob"
                                    class="form-control @error('dob') is-invalid @enderror" id="dob" type="date">
                                @error('dob')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror



                            </div>

                            <div class="col-md-4">
                                <label class="mt-3" for="gender">Gender</label>
                                <select value="{{ old('gender') }}"
                                    class="form-control @error('gender') is-invalid @enderror" name="gender"
                                    id="gender">
                                    <option disabled selected>Select Gender</option>
                                    <option class="" value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                @error('gender')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>


                            <div class="col-md-4">
                                <label class="mt-3" for="address">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" id=""
                                    rows="3">{{ old('address') }}</textarea>
                                @error('address')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-4">
                                <label class="mt-3" for="curriculum">Curriculum</label>
                                <select value="{{ old('curriculum') }}"
                                    class="form-control  @error('curriculum') is-invalid @enderror" name="curriculum"
                                    id="curriculum">
                                    <option disabled selected>Select Curriculum</option>
                                    <option value="bangla">Bangla Medium</option>
                                    <option value="english">English Medium</option>
                                    <option value="other">Other</option>
                                </select>
                                @error('curriculum')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="mt-3" for="institute">Belonging Institute Name</label>
                                <input value="{{ old('institute') }}" name="institute" class="form-control" id="institute"
                                    type="text">
                                @error('institute')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="mt-3" for="teaching_level">Teaching Level</label>
                                <input value="{{ old('teaching_level') }}" name="teaching_level"
                                    class="form-control @error('teaching_level') is-invalid @enderror" id="teaching_level"
                                    type="text">
                                @error('teaching_level')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>



                        <div class="row">

                            <div class="col-md-4">
                                <label class="mt-3" for="user_role">User Role</label>
                                <select value="{{ old('user_role') }}"
                                    class="form-control  @error('user_role') is-invalid @enderror" name="user_role"
                                    id="user_role">
                                    <option disabled selected>Select User Role</option>

                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach

                                </select>
                                @error('user_role')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="mt-3" for="password">Password</label>
                                <input name="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" type="password">
                                @error('password')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="mt-3" for="password">Confirm Password</label>
                                <input name="password_confirmation"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    id="password" type="password">
                                @error('password_confirmation')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>


                        <div class="row">
                            <div class="col text-left">
                                <input type="submit" value="Create" class="btn btn-primary mt-4">
                            </div>
                            <div class="col text-right mt-5">
                                <a href="{{ route('administrator.index') }}">Go Back</a>
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
