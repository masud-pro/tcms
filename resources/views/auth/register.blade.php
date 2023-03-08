<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            {{-- <x-jet-authentication-card-logo /> --}}
            <div class="text-center mb-3 ce-logo">
                {{-- <i class="far fa-laugh-beam"></i> --}}
                <img src="{{ asset('images/login/register.svg') }}" alt="">
            </div>
        </x-slot>

        <x-jet-validation-errors class="mb-3" />

        <div class="card shadow-sm px-2 mb-5">
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-sm-12 ">
                            <div class="mb-3">
                                <x-jet-label value="{{ __('Name') }}" />

                                <x-jet-input class="{{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                                <x-jet-input-error for="name"></x-jet-input-error>
                            </div>
                        </div>
                        {{--  --}}

                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <x-jet-label value="{{ __('Email') }}" />

                                <x-jet-input class="{{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" :value="old('email')" required />
                                <x-jet-input-error for="email"></x-jet-input-error>
                            </div>
                        </div>

                        {{--  --}}
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <x-jet-label value="{{ __('Date Of Birth') }}" />

                                <x-jet-input class="{{ $errors->has('dob') ? 'is-invalid' : '' }}" type="date" name="dob" :value="old('dob')" required />
                                <x-jet-input-error for="dob"></x-jet-input-error>
                            </div>
                        </div>

                        {{--  --}}
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <label for="gender">Gender</label>
                            <select required value="{{ old('gender') }}" class="form-control mb-3" name="gender" id="gender">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                            @error('gender')
                                <p class="text-danger small mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{--  --}}
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <x-jet-label value="{{ __('Phone Number') }}" />

                                <x-jet-input class="{{ $errors->has('phone_no') ? 'is-invalid' : '' }}" type="text" name="phone_no" :value="old('phone_no')" required />
                                <x-jet-input-error for="phone_no"></x-jet-input-error>
                            </div>
                        </div>

                        {{--  --}}
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <x-jet-label value="{{ __('Class') }}" />

                                <x-jet-input class="{{ $errors->has('class') ? 'is-invalid' : '' }}" type="number" name="class" :value="old('class')" required />
                                <x-jet-input-error for="class"></x-jet-input-error>
                            </div>
                        </div>

                        {{--  --}}

                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <x-jet-label value="{!! __('Father\'s Name and Occupation') !!}" />

                                <x-jet-input class="{{ $errors->has('fathers_name') ? 'is-invalid' : '' }}" type="text" name="fathers_name" :value="old('fathers_name')" required />
                                <x-jet-input-error for="fathers_name"></x-jet-input-error>
                            </div>
                        </div>

                        {{--  --}}
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <x-jet-label value="{!! __('Father\'s Phone Number') !!}" />

                                <x-jet-input class="{{ $errors->has('fathers_phone_no') ? 'is-invalid' : '' }}" type="text" name="fathers_phone_no" :value="old('fathers_phone_no')" required />
                                <x-jet-input-error for="fathers_phone_no"></x-jet-input-error>
                            </div>
                        </div>

                        {{--  --}}
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <x-jet-label value="{!! __('Mother\'s Name and Occupation') !!}" />

                                <x-jet-input class="{{ $errors->has('mothers_name') ? 'is-invalid' : '' }}" type="text" name="mothers_name" :value="old('mothers_name')" required />
                                <x-jet-input-error for="mothers_name"></x-jet-input-error>
                            </div>
                        </div>

                        {{--  --}}
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <x-jet-label value="{!! __('Mother\'s Phone Number') !!}" />

                                <x-jet-input class="{{ $errors->has('mothers_phone_no') ? 'is-invalid' : '' }}" type="text" name="mothers_phone_no" :value="old('mothers_phone_no')" required />
                                <x-jet-input-error for="mothers_phone_no"></x-jet-input-error>
                            </div>
                        </div>

                        {{--  --}}
                        <div class="col-md-12">
                            <div class="mb-3">
                                <x-jet-label value="{!! __('Address') !!}" />
                                <textarea name="address" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" id="" rows="2">{{ old('address') }}</textarea>
                                {{-- <x-jet-input class="{{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" --}}
                                {{-- :value="old('address')" required /> --}}
                                <x-jet-input-error for="address"></x-jet-input-error>
                            </div>
                        </div>

                        {{--  --}}
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <x-jet-label value="{{ __('Password') }}" />

                                <x-jet-input class="{{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" id="password" name="password" required autocomplete="new-password" />
                                <x-jet-input-error for="password"></x-jet-input-error>
                            </div>
                        </div>

                        {{--  --}}
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <x-jet-label value="{{ __('Confirm Password') }}" />

                                <x-jet-input class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" />
                            </div>
                        </div>
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

                    @php
                        $teacher = null;
                        if (getSubdomainUser()) {
                            $teacher = getSubdomainUser();
                        }
                    @endphp
                    @if ($teacher)
                        <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                    @endif

                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="mb-3">
                            <div class="custom-control custom-checkbox">
                                <x-jet-checkbox id="terms" name="terms" />
                                <label class="custom-control-label" for="terms">
                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="' . route('terms.show') . '">' . __('Terms of Service') . '</a>',
                                        'privacy_policy' => '<a target="_blank" href="' . route('policy.show') . '">' . __('Privacy Policy') . '</a>',
                                    ]) !!}
                                </label>
                            </div>
                        </div>
                    @endif


                    <div class="mb-0 ">
                        <div class="d-flex justify-content-start align-items-baseline">
                            <x-jet-button>
                                {{ __('Register') }}
                            </x-jet-button>

                            <a class="text-muted text-decoration-none" style="padding-left: 10px;" href="{{ route('login') }}">
                                {{ __('Already registered?') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>


    </x-jet-authentication-card>
</x-guest-layout>


<script>
    var myInput = document.getElementById("password");
    var letter = document.getElementById("letter");
    var capital = document.getElementById("capital");
    var number = document.getElementById("number");
    var length = document.getElementById("length");

    // When the user clicks on the password field, show the message box
    myInput.onfocus = function() {
        document.getElementById("message").style.display = "block";
    }

    // When the user clicks outside of the password field, hide the message box
    myInput.onblur = function() {
        document.getElementById("message").style.display = "none";
    }

    // When the user starts to type something inside the password field
    myInput.onkeyup = function() {
        // Validate lowercase letters
        var lowerCaseLetters = /[a-z]/g;
        if (myInput.value.match(lowerCaseLetters)) {
            letter.classList.remove("invalid");
            letter.classList.add("valid");
        } else {
            letter.classList.remove("valid");
            letter.classList.add("invalid");
        }

        // Validate capital letters
        var upperCaseLetters = /[A-Z]/g;
        if (myInput.value.match(upperCaseLetters)) {
            capital.classList.remove("invalid");
            capital.classList.add("valid");
        } else {
            capital.classList.remove("valid");
            capital.classList.add("invalid");
        }

        // Validate numbers
        var numbers = /[0-9]/g;
        if (myInput.value.match(numbers)) {
            number.classList.remove("invalid");
            number.classList.add("valid");
        } else {
            number.classList.remove("valid");
            number.classList.add("invalid");
        }

        // Validate length
        if (myInput.value.length >= 8) {
            length.classList.remove("invalid");
            length.classList.add("valid");
        } else {
            length.classList.remove("valid");
            length.classList.add("invalid");
        }
    };
</script>


<style>
    .label-text {
        font-size: 12px !important;
        font-weight: 600 !important;
        color: #555 !important;
        margin-bottom: 0;
    }

    /* The message box is shown when the user clicks on the password field */
    #message {
        display: none;
        color: #000;
        position: relative;
        margin-top: 10px;
    }

    #message p {
        padding: 0px 20px;
        font-size: 14px;
    }

    /* Add a green text color and a checkmark when the requirements are right */
    .valid {
        color: green;
    }

    .valid:before {
        position: relative;
        left: -20px;
        content: "✔";
    }

    /* Add a red text color and an "x" when the requirements are wrong */
    .invalid {
        color: red;
    }

    .invalid:before {
        position: relative;
        left: -20px;
        content: "✖";
    }
</style>
