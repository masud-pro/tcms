<div>
    <div class="container">
        {{-- <form wire:submit.prevent="submit"> --}}
        <form wire:submit.prevent="submit">
            <div class="row {{ $register == false ? 'justify-content-center' : '' }}">
                <div class="col-md-5">
                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <div class="row">


                                {{-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> --}}
                                <div class="col-lg-12">
                                    <div class="p-5">

                                        <div class="text-center">


                                            <h3 class="text-center fs-1 ">
                                                {{ $planPrice == 0 ? '' : $planPrice }}<span
                                                    class="fs-6">{{ $planPrice == 0 ? 'Free for 30 Days' : 'Tk' }}</span>
                                            </h3>

                                            @if ($freeTrail == true)
                                                <h3 class="text-center fs-1"></h3>
                                            @else
                                                <div class="form-check form-switch form-switch-lg mt-2">
                                                    <label class="form-check-label pd-18"
                                                        for="flexSwitchCheckChecked">Bill
                                                        Monthly</label>
                                                    <input class="form-check-input" type="checkbox"
                                                        id="flexSwitchCheckChecked" style="opacity: 1;"
                                                        wire:click="$toggle('billChecked')">
                                                    <label class="form-check-label pd-4 "
                                                        style="opacity: 1; color: #222"
                                                        for="flexSwitchCheckChecked">Bill
                                                        Annually</label>


                                                </div>
                                            @endif






                                        </div>

                                        {{-- <div class="row">
                                          


                                           <div class="col-md-8">
                                           
                                           </div>

                                           <div class="col-md-3">
                                            <div class="">
                                           
                                                <h3 class="text-center fs-1">
                                                    {{ $planPrice == 0 ? '' : $planPrice }}<span
                                                        class="fs-6">{{ $planPrice == 0 ? 'Free for 2 Month' : 'Tk' }}</span>
                                                </h3>
                                            </div>
                                           </div>
                                        </div> --}}









                                        <div class="form-group row">

                                            <div class="col-sm-8 mb-3 mb-sm-0">


                                                <select class="form-control form-control-select " wire:model="planName"
                                                    id="planName">
                                                    <option disabled selected>Please Select Plan</option>
                                                    @foreach ($planList as $data)
                                                        <option value="{{ $data->id }}"
                                                            {{ $planName == $data->id ? 'selected' : '' }}>
                                                            {{ $data->name }}</option>
                                                    @endforeach
                                                    {{-- <option value="2">Two</option>
                                                    <option value="3">Three</option> --}}
                                                </select>
                                            </div>

                                            <div class="col-sm-4 mb-3 mb-sm-0">

                                                <div class="text-center mt-1">
                                                    {{-- <button wire:click="nextStep()" type="button"
                                                            class="btn btn-primary ">Free
                                                            Trail</button> --}}



                                                    @if ($nextStep == false)

                                                        @if ($freeTrail == true)
                                                            <button wire:click="nextStep()" type="button"
                                                                class="btn btn-primary ">Free
                                                                Trail</button>
                                                        @else
                                                            <button wire:click="nextStep()" type="button"
                                                                class="btn btn-primary ">Next
                                                                Step</button>
                                                        @endif
                                                    @else
                                                        {{-- <h3 class="text-center fs-1">
                                                            {{ $planPrice == 0 ? '' : $planPrice }}<span
                                                                class="fs-6">{{ $planPrice == 0 ? 'Free for 2 Month' : 'Tk' }}</span>
                                                        </h3> --}}
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
                                                        {{-- {{ Str::replace('.', ' ', Str::of(Str::of($feature)->camel())->headline()) }} --}}
                                                    </h6>
                                                    {{-- <h6> <span class="pr-1">-</span> {{    Str::of(Str::of($feature)->camel())->replace('.') }}</h6> --}}
                                                @endforeach



                                                {{-- <h6> <span class="pr-1">-</span> hello World</h6>
                                               <h6> <span class="pr-1">-</span> hello World</h6>
                                               <h6> <span class="pr-1">-</span> hello World</h6>
                                               <h6> <span class="pr-1">-</span> hello World</h6> --}}

                                            </div>

                                        </div>

                                        <div class="form-group row">

                                            <div class="col-sm-12 mb-3 mb-sm-0">

                                                @if ($nextStep == false)

                                                    @if ($freeTrail == true)
                                                        <div class="text-cemter mt-3 ">
                                                            <div class="col-md-12 text-center">
                                                                <button wire:click="nextStep()" type="button"
                                                                    class="btn btn-primary ">Free
                                                                    Trail</button>

                                                            </div>
                                                        </div>
                                                    @else
                                                        <h3 class="text-center fs-1">
                                                            {{ $planPrice['price'] ?? '' }}<span
                                                                class="fs-6">Tk</span> </h3>


                                                        <div class="text-cemter mt-3 ">
                                                            <div class="col-md-12 text-center">
                                                                <button wire:click="nextStep()" type="button"
                                                                    class="btn btn-primary ">Next
                                                                    Step</button>

                                                            </div>
                                                        </div>
                                                    @endif
                                                @else
                                                    <h3 class="text-center fs-1">
                                                        {{ $planPrice == 0 ? '' : $planPrice }}<span
                                                            class="fs-6">{{ $planPrice == 0 ? 'Free for 2 Month' : 'Tk' }}</span>
                                                    </h3>
                                                @endif






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



                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif






                        <div class="card o-hidden border-0 shadow-lg my-5">
                            <div class="card-body p-0">
                                <div class="row">
                                    {{-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> --}}
                                    <div class="col-lg-12">
                                        <div class="p-5">
                                            <div class="text-center">
                                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                                            </div>
                                            <div class="user">
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <input type="text"
                                                            class="form-control form-control-user @error('fName') is-invalid @enderror"
                                                            id="fName" placeholder="First Name"
                                                            value="{{ old('fName') }}" wire:model="fName">

                                                        @error('fName')
                                                            <p class="text-danger small mt-1">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control form-control-user"
                                                            id="lName" placeholder="Last Name" wire:model="lName">
                                                    </div>
                                                </div>




                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <input type="text" class="form-control form-control-user"
                                                            id="phoneNumber" placeholder="Phone Number"
                                                            wire:model="phoneNumber">
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control form-control-user"
                                                            id="userName" placeholder="User Name"
                                                            wire:model="userName">
                                                    </div>

                                                </div>

                                                <div class="form-group">
                                                    <input type="email" class="form-control form-control-user"
                                                        id="emailAddress" placeholder="Email Address"
                                                        wire:model="emailAddress">
                                                </div>



                                                <div class="form-group row">
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control form-control-user"
                                                            id="dob" placeholder="Date of Birth"
                                                            wire:model="dob">
                                                    </div>

                                                    {{-- select Gender --}}
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <select class="form-control form-control-select"
                                                            id="gender" wire:model="gender">
                                                            <option selected>Select Gender</option>
                                                            <option value="1">One</option>
                                                            <option value="2">Two</option>
                                                            <option value="3">Three</option>
                                                        </select>
                                                    </div>

                                                </div>


                                                <div class="form-group row">


                                                    {{-- Select Curriculum --}}
                                                    <div class="col-sm-6">
                                                        <select class="form-control form-control-select select1"
                                                            id="curriculum" wire:model="curriculum">
                                                            <option selected>Select Curriculum</option>
                                                            <option value="1">One</option>
                                                            <option value="2">Two</option>
                                                            <option value="3">Three</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <input type="text" class="form-control form-control-user"
                                                            id="teachingLevel" placeholder="Teaching Level"
                                                            wire:model="teachingLevel">
                                                    </div>

                                                </div>


                                                <div class="form-group">
                                                    <textarea type="email" class="form-control form-control-user" id="address" placeholder="Address"
                                                        wire:model="address"></textarea>
                                                </div>





                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <input type="password" class="form-control form-control-user"
                                                            id="password" placeholder="Password"
                                                            wire:model="password">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="password" class="form-control form-control-user"
                                                            id="exampleRepeatPassword" placeholder="Repeat Password">
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                                    Register Account
                                                </button>

                                            </div>
                                            <hr>
                                            <div class="text-center">
                                                <a class="small" href="#">Forgot Password?</a>
                                            </div>
                                            <div class="text-center">
                                                <a class="small" href="#">Already have an account? Login!</a>
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




    {{-- <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>



                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form class="user">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user"
                                            id="exampleFirstName" placeholder="First Name">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user"
                                            id="exampleLastName" placeholder="Last Name">
                                    </div>
                                </div>




                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user"
                                            id="exampleFirstName" placeholder="Phone Number">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user"
                                            id="exampleLastName" placeholder="Date of Birth">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user"
                                        id="exampleInputEmail" placeholder="Email Address">
                                </div>



                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user"
                                            id="exampleLastName" placeholder="User Name">
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">


                                        <select class="form-control form-control-select ">
                                            <option selected>Select Gender</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>

                                </div>


                                <div class="form-group row">
                                    <div class="col-sm-6">



                                        <select class="form-control form-control-select select1 ">
                                            <option selected>Select Curriculum</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user"
                                            id="exampleFirstName" placeholder="Teaching Level">
                                    </div>

                                </div>


                                <div class="form-group">


                                    <textarea type="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Address"></textarea>
                                </div>





                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Password">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user"
                                            id="exampleRepeatPassword" placeholder="Repeat Password">
                                    </div>
                                </div>
                                <a href="#" class="btn btn-primary btn-user btn-block">
                                    Register Account
                                </a>

                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="forgot-password.html">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="login.html">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> --}}
</div>


@push('scripts')
    @livewireScripts()
    <script src="{{ asset('assets') }}/js/datepicker/bootstrap-datepicker.min.js"></script>
    <script>
        $('.sub-calander').datepicker({
            format: "yyyy-mm-dd",
            // startView: "months",
            // minViewMode: "months",
            autoclose: true,
            todayHighlight: true
        });

        // window.addEventListener('reInitJquery', event => {
        //     var $disabledResults = $(".js-example-disabled-results");
        //     $disabledResults.select2();
        // })

        // $('#startDate').on('change', function(e) {
        //     @this.set('startDate', e.target.value);

        // });

        // $('#monthCount').on('change', function(e) {
        //     @this.set('monthCount', e.target.value);

        // });

        $("#checkbox").prop("checked", true);



        $('#planName').change(function() {
            var planName = $('#planName').val();
            @this.set('planName', this.value);
        });
    </script>
@endpush

@push('styles')
    @livewireStyles()
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    {{-- <link href="{{ asset('assets') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="{{ asset('assets') }}/css/datepicker/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css"> --}}
@endpush
