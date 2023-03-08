<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Edit User</h6>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="submit">


                        <div class="row">
                            <div class="col-md-4">
                                <label for="name">Full Name</label>
                                <input wire:model.defer="name" value="{{ old('name') }}" name="name" class="form-control @error('name') is-invalid @enderror" id="name" type="text">
                                @error('name')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="" for="email">User Email</label>
                                <input wire:model.defer="email" value="{{ old('email') }}" name="email" class="form-control @error('email') is-invalid @enderror" id="email" type="text">
                                @error('email')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="phone_no">Phone Number</label>
                                <input wire:model.defer="phone_no" value="{{ old('phone_no') }}" name="phone_no" class="form-control @error('phone_no') is-invalid @enderror" id="phone_no" type="text">
                                @error('phone_no')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="mt-3" for="user_role">User Role</label>
                                <select wire:model="userRole" value="{{ old('user_role') }}" class="form-control  @error('user_role') is-invalid @enderror" name="user_role" id="user_role">

                                    <option disabled selected>Select User Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach

                                </select>
                                @error('user_role')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>


                            @if ($isTeacher == true)
                                <div class="col-md-4">
                                    <label class="mt-3" for="user_name">User Name</label>
                                    <input wire:model.defer="user_name" value="{{ old('user_name') }}" name="user_name" class="form-control @error('user_name') is-invalid @enderror" id="user_name" type="text">
                                    @error('user_name')
                                        <p class="text-danger small mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endif

                            <div class="col-md-4">
                                <label class="mt-3" for="dob">Date of Birth</label>
                                <input wire:model.defer="dob" value="{{ old('dob') }}" name="dob" class="form-control @error('dob') is-invalid @enderror" id="dob" type="date">
                                @error('dob')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror

                            </div>

                            <div class="col-md-4">
                                <label class="mt-3" for="gender">Gender</label>
                                <select wire:model.defer="gender" value="{{ old('gender') }}" class="form-control @error('gender') is-invalid @enderror" name="gender" id="gender">
                                    <option disabled>Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                @error('gender')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="mt-3" for="password">Password</label>
                                <input wire:model.defer="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" type="password">
                                @error('password')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="mt-3" for="password">Confirm Password</label>
                                <input wire:model.defer="password_confirmation" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password" type="password">
                                @error('password_confirmation')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            @if ($isTeacher == true)
                                <div class="col-md-4">
                                    <label class="mt-3" for="curriculum">Curriculum</label>
                                    <select wire:model.defer="curriculum" value="{{ old('curriculum') }}" class="form-control  @error('curriculum') is-invalid @enderror" name="curriculum" id="curriculum">
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
                                    <input wire:model.defer="institute" value="{{ old('institute') }}" name="institute" class="form-control @error('institute') is-invalid @enderror" id="institute" type="text">
                                    @error('institute')
                                        <p class="text-danger small mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="mt-3" for="teaching_level">Teaching Level</label>
                                    <input wire:model.defer="teaching_level" value="{{ old('teaching_level') }}" name="teaching_level" class="form-control @error('teaching_level') is-invalid @enderror"
                                        id="teaching_level" type="text">
                                    @error('teaching_level')
                                        <p class="text-danger small mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                {{--  --}}
                                <div class="col-md-4">
                                    <label class="mt-3" for="business_institute_name">Teacher Business Institute Name</label>
                                    <input wire:model.defer="business_institute_name" value="{{ old('business_institute_name') }}" name="business_institute_name"
                                        class="form-control @error('business_institute_name') is-invalid @enderror" id="business_institute_name" type="text">
                                    @error('business_institute_name')
                                        <p class="text-danger small mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endif

                            <div class="col-md-4">
                                <label class="mt-3" for="address">Address</label>
                                <textarea wire:model.defer="address" class="form-control @error('address') is-invalid @enderror" id="address" name="address" id="" rows="3">{{ old('address') }}</textarea>
                                @error('address')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>


                        <div class="row">
                            <div class="col text-left">
                                <button type="submit" class="btn btn-primary mt-4">Update</button>
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
</div>


@push('scripts')
    @livewireScripts()
@endpush

@push('styles')
    @livewireStyles()
@endpush
