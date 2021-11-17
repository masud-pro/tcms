@extends('layouts.cms')

@section('title')
    Students
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Edit Student</h6>
            </div>
            <div class="card-body">
                <form action="{{ route("user.update",["user"=>$user->id]) }}" method="POST">

                    @csrf
                    @method("PATCH")

                    <label for="name">Student Name</label>
                    <input value="{{ old("name") ?? $user->name }}" name="name" class="form-control" id="name" type="text">
                    @error('name')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label class="mt-3" for="email">Student Email</label>
                    <input value="{{ old("email") ?? $user->email }}" name="email" class="form-control" id="email" type="text">
                    @error('email')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label class="mt-3" for="batch">Batch</label>
                    <select 
                        value="{{ old("name") }}" 
                        class="form-control" 
                        name="course_id[]" 
                        multiple="multiple" 
                        id="batch"
                    >
                        @foreach ($batches as $batch)
                            <option 
                                value="{{ $batch->id }}"
                                @if ( in_array( $batch->id, $user->course->pluck("id")->toArray() ) )
                                    selected
                                @endif
                            >
                                {{ $batch->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('batch_id')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label class="mt-3" for="dob">Date of Birth</label>
                    <input value="{{ old("dob") ?? $user->dob }}" name="dob" class="form-control" id="dob" type="date">
                    @error('dob')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label class="mt-3" for="gender">Gender</label>
                    <select value="{{ old("gender") }}" class="form-control" name="gender" id="gender">
                        <option @if ( $user->gender == "male" ) selected @endif value="male">Male</option>
                        <option @if ( $user->gender == "female" ) selected @endif value="female">Female</option>
                    </select>
                    @error('gender')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label class="mt-3" for="is_active">Active Status</label>
                    <select value="{{ old("is_active") }}" class="form-control" name="is_active" id="is_active">
                        <option @if ( $user->is_active == 0 ) selected @endif value="0">In Active</option>
                        <option @if ( $user->is_active == 1 ) selected @endif value="1">Active</option>
                    </select>
                    @error('is_active')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label class="mt-3" for="roll">Roll No</label>
                    <input value="{{ old("roll") ?? $user->roll }}" name="roll" class="form-control" id="roll" type="number">
                    @error('roll')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label class="mt-3" for="reg_no">Reg No</label>
                    <input value="{{ old("reg_no") ?? $user->reg_no }}" name="reg_no" class="form-control" id="reg_no" type="number">
                    @error('reg_no')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label class="mt-3" for="waiver">Waiver</label>
                    <input value="{{ old("waiver") ?? $user->waiver }}" name="waiver" class="form-control" id="waiver" type="number">
                    @error('waiver')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label class="mt-3" for="phone_no">Phone Number</label>
                    <input value="{{ old("phone_no") ?? $user->phone_no }}" name="phone_no" class="form-control" id="phone_no" type="text">
                    @error('phone_no')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label class="mt-3" for="fathers_name">Father's Name</label>
                    <input value="{{ old("fathers_name") ?? $user->fathers_name }}" name="fathers_name" class="form-control" id="fathers_name" type="text">
                    @error('fathers_name')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label class="mt-3" for="fathers_phone_no">Father's Phone Number</label>
                    <input value="{{ old("fathers_phone_no") ?? $user->fathers_phone_no }}" name="fathers_phone_no" class="form-control" id="fathers_phone_no" type="text">
                    @error('fathers_phone_no')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label class="mt-3" for="mothers_name">Mother's Name</label>
                    <input value="{{ old("mothers_name") ?? $user->mothers_name }}" name="mothers_name" class="form-control" id="mothers_name" type="text">
                    @error('mothers_name')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label class="mt-3" for="mothers_phone_no">Mother's Phone Number</label>
                    <input value="{{ old("mothers_phone_no") ?? $user->mothers_phone_no }}" name="mothers_phone_no" class="form-control" id="mothers_phone_no" type="text">
                    @error('mothers_phone_no')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label class="mt-3" for="address">Address</label>
                    <textarea class="form-control" id="address" name="address" cols="30" rows="2">{{ old("address") ?? $user->address }}</textarea>
                    @error('address')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label class="mt-3" for="password">Password</label>
                    <input name="password" class="form-control" id="password" type="password">
                    @error('password')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label class="mt-3" for="password">Confirm Password</label>
                    <input name="password_confirmation" class="form-control" id="password" type="password">
                    @error('password_confirmation')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <input type="hidden" value="Student" name="role">

                    <div class="row">
                        <div class="col text-left">
                            <input type="submit" value="Update" class="btn btn-primary mt-4">
                        </div>
                    </form>
                        <div class="col text-right">
                            <form action="{{ route("user.destroy",["user",$user->id]) }}">
                                @csrf
                                @method("DELETE")
                                <input type="submit" onclick="return confirm('Are you sure you want to delete the account of {{ $user->name }}?')" value="Delete Account" class="btn btn-danger mt-4">
                            </form>
                        </div>
                    </div>

                
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