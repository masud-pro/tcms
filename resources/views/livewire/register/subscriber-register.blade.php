<div>
    <div class="container">
        {{-- <form wire:submit.prevent="submit"> --}}
        <form wire:submit.prevent="submit" autocomplete="off">
            <div class="row {{ $register == false ? 'justify-content-center' : '' }}">
                <div class="col-md-5">
                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="p-5">

                                        <div class="text-center">
                                            @if ($planPrice == 0)
                                                <h3 class="text-center fs-4 price-container fw-bold">Free for 30 Days
                                                </h3>
                                            @else
                                                <h3 class="text-center fs-1 price-container fw-bold">
                                                    {{ $planPrice == 0 ? '' : number_format($planPrice) }}<span class="fs-6">Tk</span>
                                                </h3>
                                                @if (!$customPlanData)
                                                    <div class="form-check form-switch form-switch-lg mt-2">
                                                        <label class="form-check-label pd-18" for="flexSwitchCheckChecked">Bill Monthly</label>
                                                        <input class="form-check-input" type="checkbox" name="flexSwitchCheckChecked" value="{{ old('flexSwitchCheckChecked') }}" id="flexSwitchCheckChecked"
                                                            style="opacity: 1;" wire:click="$toggle('billChecked')">
                                                        <label class="form-check-label pd-4 " style="opacity: 1; color: #222" for="flexSwitchCheckChecked">Bill Annually</label>
                                                    </div>


                                                    <a class="small text-dark" wire:click="$toggle('customPlanData')" href="#">Custom</a>
                                                @else
                                                    <label>Select Month</label>
                                                    <input wire:model="month" type="number" name="month" value="{{ old('month') }}" class="form-control" min="2">

                                                    <a class="small text-dark" wire:click="$toggle('customPlanData')" href="#">Back</a>
                                                @endif


                                            @endif

                                        </div>

                                        <div class="form-group row mt-3">

                                            <div class="col-sm-{{ $nextStep == false ? '8' : '12' }} mb-3 mb-sm-0">


                                                <select class="form-control form-control-select " wire:model.defer="planId" id="planId">
                                                    <option disabled selected>Please Select Plan</option>
                                                    @foreach ($planList as $data)
                                                        <option value="{{ $data->id }}" {{ $planId == $data->id ? 'selected' : '' }}>
                                                            {{ $data->name }}</option>
                                                    @endforeach

                                                </select>
                                            </div>

                                            <div class="col-sm-4 mb-3 mb-sm-0">

                                                <div class="text-center mt-1">

                                                    @if ($nextStep == false)
                                                        <button wire:click="nextStep()" type="button" class="btn btn-primary ">Next Step</button>
                                                    @endif


                                                </div>


                                            </div>

                                        </div>


                                        <div class="form-group row">

                                            <h4 class="fs-4 text-bold">Features </h4>

                                            <div class="col-sm-12 mb-3 mb-sm-0">

                                                @foreach ($planFeature ?? [] as $feature)
                                                    <h6> <span class="pr-1">-</span>
                                                        {{ Str::of(Str::of(Str::replace('.', ' ', $feature))->camel())->headline() }}
                                                    </h6>
                                                @endforeach

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($register == true)
                    <div class="col-md-7 w3-container w3-center w3-animate-right">

                        <div class="card o-hidden border-0 shadow-lg my-5">
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="p-5">
                                            <div class="text-center">
                                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                                            </div>
                                            <div class="user">
                                                <div class="form-group row text-left">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <label for="fName" class="label-text">First Name</label>
                                                        <span class="required"></span>
                                                        <input type="text" name="fName" value="{{ old('fName') }}" class="form-control form-control-user @error('fName') is-invalid @enderror" id="fName"
                                                            placeholder="First Name" value="{{ old('fName') }}" wire:model.defer="fName">

                                                        @error('fName')
                                                            <p class="text-start text-danger small mt-1">
                                                                {{ $message }}
                                                            </p>
                                                        @enderror
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="fName" class="label-text">Last Name</label>
                                                        <span class="required"></span>
                                                        <input type="text" name="lName" value="{{ old('lName') }}" class="form-control form-control-user @error('lName') is-invalid @enderror" id="lName"
                                                            placeholder="Last Name" wire:model.defer="lName">
                                                        @error('lName')
                                                            <p class="text-start text-danger small mt-1">
                                                                {{ $message }}
                                                            </p>
                                                        @enderror
                                                    </div>
                                                </div>




                                                <div class="form-group row text-left">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <label for="fName" class="label-text">Phone Number</label>
                                                        <span class="required"></span>
                                                        <input type="text" name="phoneNumber" value="{{ old('phoneNumber') }}" class="form-control form-control-user @error('phoneNumber') is-invalid @enderror"
                                                            id="phoneNumber" placeholder="Phone Number" wire:model.defer="phoneNumber">

                                                        @error('phoneNumber')
                                                            <p class="text-start text-danger small mt-1">
                                                                {{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <label for="fName" class="label-text">User Name</label>
                                                        <span class="required"></span>
                                                        <input type="text" name="username" value="{{ old('username') }}" class="form-control form-control-user @error('username') is-invalid @enderror"
                                                            id="username" placeholder="User Name" wire:model="username">

                                                        @error('username')
                                                            <p class="text-start text-danger small mt-1">
                                                                {{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                </div>

                                                <div class="form-group text-left">
                                                    <label for="fName" class="label-text">Email Address</label>
                                                    <span class="required"></span>
                                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control form-control-user  @error('emailAddress') is-invalid @enderror"
                                                        id="emailAddress" placeholder="Email Address" wire:model.defer="emailAddress">

                                                    @error('emailAddress')
                                                        <p class="text-start text-danger small mt-1">
                                                            {{ $message }}</p>
                                                    @enderror
                                                </div>



                                                <div class="form-group row text-left">
                                                    <div class="col-sm-6">
                                                        <label for="dob" class="label-text">Date Of Birth</label>
                                                        <span class="required"></span>
                                                        <input format="dd/mm/yyyy" name="dob" value="{{ old('dob') }}"
                                                            class="form-control form-control-user datepicker sub-calander @error('dob') is-invalid @enderror" id="dob" placeholder="Date of Birth"
                                                            wire:model="dob" type="date" id="dob">

                                                        @error('dob')
                                                            <p class="text-start text-danger small mt-1">
                                                                {{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                    {{-- select Gender --}}
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <label for="gender" class="label-text">Gender</label>
                                                        <span class="required"></span>
                                                        <select value="{{ old('gender') }}" class="form-control form-control-select @error('gender') is-invalid @enderror" id="gender" wire:model.defer="gender">
                                                            <option readonly selected>Select Gender</option>
                                                            <option value="male">Male</option>
                                                            <option value="female">Female</option>
                                                        </select>

                                                        @error('gender')
                                                            <p class="text-start text-danger small mt-1">
                                                                {{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                </div>


                                                <div class="form-group row text-left">

                                                    <div class="col-sm-12 mb-3">
                                                        <label for="business_institute_name" class="label-text">Teacher
                                                            Business Institute Name</label>
                                                        <input type="text" value="{{ old('business_institute_name') }}" class="form-control form-control-user @error('business_institute_name') is-invalid @enderror"
                                                            id="business_institute_name" placeholder="Teacher's Business Institute Name" wire:model.defer="business_institute_name">

                                                        @error('business_institute_name')
                                                            <p class="text-start text-danger small mt-1">
                                                                {{ $message }}</p>
                                                        @enderror
                                                    </div>


                                                    {{-- Select Curriculum --}}
                                                    <div class="col-sm-6">
                                                        <label for="curriculum" class="label-text">Curriculum</label>
                                                        <span class="required"></span>
                                                        <select value="{{ old('curriculum') }}" class="form-control form-control-select select1 @error('curriculum') is-invalid @enderror" id="curriculum"
                                                            wire:model.defer="curriculum">
                                                            <option readonly selected>Select Curriculum</option>
                                                            <option value="bangla">Bangla Medium</option>
                                                            <option value="english">English Medium</option>
                                                            <option value="other">Other</option>
                                                        </select>

                                                        @error('curriculum')
                                                            <p class="text-start text-danger small mt-1">
                                                                {{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <label for="teachingLevel" class="label-text">Teaching
                                                            Level</label>
                                                        <span class="required"></span>
                                                        <input type="text" value="{{ old('teachingLevel') }}" class="form-control form-control-user @error('teachingLevel') is-invalid @enderror" id="teachingLevel"
                                                            placeholder="Teacher's Desired Tuition Level" wire:model.defer="teachingLevel">

                                                        @error('teachingLevel')
                                                            <p class="text-start text-danger small mt-1">
                                                                {{ $message }}</p>
                                                        @enderror
                                                    </div>



                                                </div>


                                                <div class="form-group text-left">
                                                    <label for="institute" class="label-text">Institute</label>

                                                    <input type="text" class="form-control form-control-user @error('institute') is-invalid @enderror" id="institute" placeholder="Institute Name"
                                                        wire:model.defer="institute" autocomplete="off">

                                                    @error('institute')
                                                        <p class="text-start text-danger small mt-1">{{ $message }}
                                                        </p>
                                                    @enderror
                                                </div>

                                                <div class="form-group text-left">
                                                    <label for="address" class="label-text">Address</label>
                                                    <span class="required"></span>
                                                    <textarea class="form-control form-control-user @error('address') is-invalid @enderror" id="address" placeholder="Address" wire:model.defer="address"></textarea>

                                                    @error('address')
                                                        <p class="text-start text-danger small mt-1">{{ $message }}
                                                        </p>
                                                    @enderror
                                                </div>

                                                <div class="form-group row text-left">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <label for="password" class="label-text">Password</label>
                                                        <span class="required"></span>
                                                        <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" id="password" placeholder="Password"
                                                            wire:model.defer="password">
                                                        <div id="pass_available" class="mt-1"></div>

                                                        @error('password')
                                                            <p class="text-start text-danger small mt-1">
                                                                {{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="password_confirmation" class="label-text">Password
                                                            Confirmation</label>
                                                        <span class="required"></span>
                                                        <input type="password" class="form-control form-control-user @error('password_confirmation') is-invalid @enderror" id="repassword"
                                                            wire:model.defer="password_confirmation" placeholder="Repeat Password">

                                                    </div>

                                                    <div class="col-sm-12">
                                                        <div class=" form-control-user" id="message">
                                                            <p id="letter" class="invalid">A <b>lowercase</b>
                                                                letter</p>
                                                            <p id="capital" class="invalid">A <b>capital
                                                                    (uppercase)</b> letter</p>
                                                            <p id="number" class="invalid">A <b>number</b></p>
                                                            <p id="length" class="invalid">Minimum <b>8
                                                                    characters</b></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                                    Register Account
                                                </button>

                                            </div>
                                            <hr>
                                            <div class="text-center">
                                            </div>
                                            <div class="text-center">
                                                <a class="small" href="{{ route('login') }}">Already have an
                                                    account? Login!</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>


        </form>

    </div>
</div>


@push('scripts')
    @livewireScripts()
    <script src="{{ asset('assets') }}/js/datepicker/bootstrap-datepicker.min.js"></script>

    <script>
        $('#dob').datepicker({
            format: "yyyy-mm-dd",
            startView: "months",

            todayHighlight: true,
        });

        $('#dob').on('change', function(e) {
            @this.set('dob', e.target.value);

        });


        $('#planId').change(function() {
            var planId = $('#planId').val();
            @this.set('planId', this.value);
        });
    </script>
@endpush

@push('styles')
    @livewireStyles()
    <link href="{{ asset('assets') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="{{ asset('assets') }}/css/datepicker/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css">
@endpush
