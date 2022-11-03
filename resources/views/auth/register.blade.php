<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            {{-- <x-jet-authentication-card-logo /> --}}
            <div class="text-center mb-3 ce-logo">
                {{-- <i class="far fa-laugh-beam"></i> --}}
                <img src="{{ asset("images/login/register.svg") }}" alt="">
            </div>
        </x-slot>

        <x-jet-validation-errors class="mb-3" />

        <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <x-jet-label value="{{ __('Name') }}" />

                    <x-jet-input class="{{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                                 :value="old('name')" required autofocus autocomplete="name" />
                    <x-jet-input-error for="name"></x-jet-input-error>
                </div>

                <div class="mb-3">
                    <x-jet-label value="{{ __('Email') }}" />

                    <x-jet-input class="{{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email"
                                 :value="old('email')" required />
                    <x-jet-input-error for="email"></x-jet-input-error>
                </div>

                <div class="mb-3">
                    <x-jet-label value="{{ __('Date Of Birth') }}" />

                    <x-jet-input class="{{ $errors->has('dob') ? 'is-invalid' : '' }}" type="date" name="dob"
                                 :value="old('dob')" required />
                    <x-jet-input-error for="dob"></x-jet-input-error>
                </div>

                <label for="gender">Gender</label>
                <select required value="{{ old("gender") }}" class="form-control mb-3" name="gender" id="gender">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                @error('gender')
                    <p class="text-danger small mt-1">{{ $message }}</p>
                @enderror

                <div class="mb-3">
                    <x-jet-label value="{{ __('Phone Number') }}" />

                    <x-jet-input class="{{ $errors->has('phone_no') ? 'is-invalid' : '' }}" type="text" name="phone_no"
                                 :value="old('phone_no')" required />
                    <x-jet-input-error for="phone_no"></x-jet-input-error>
                </div>

                <div class="mb-3">
                    <x-jet-label value="{{ __('Class') }}" />

                    <x-jet-input class="{{ $errors->has('class') ? 'is-invalid' : '' }}" type="number" name="class"
                                 :value="old('class')" required />
                    <x-jet-input-error for="class"></x-jet-input-error>
                </div>

                <div class="mb-3">
                    <x-jet-label value="{!! __('Father\'s Name and Occupation') !!}" />

                    <x-jet-input class="{{ $errors->has('fathers_name') ? 'is-invalid' : '' }}" type="text" name="fathers_name"
                                 :value="old('fathers_name')" required />
                    <x-jet-input-error for="fathers_name"></x-jet-input-error>
                </div>

                <div class="mb-3">
                    <x-jet-label value="{!! __('Father\'s Phone Number') !!}" />

                    <x-jet-input class="{{ $errors->has('fathers_phone_no') ? 'is-invalid' : '' }}" type="text" name="fathers_phone_no"
                                 :value="old('fathers_phone_no')" required />
                    <x-jet-input-error for="fathers_phone_no"></x-jet-input-error>
                </div>

                <div class="mb-3">
                    <x-jet-label value="{!! __('Mother\'s Name and Occupation') !!}" />

                    <x-jet-input class="{{ $errors->has('mothers_name') ? 'is-invalid' : '' }}" type="text" name="mothers_name"
                                 :value="old('mothers_name')" required />
                    <x-jet-input-error for="mothers_name"></x-jet-input-error>
                </div>

                <div class="mb-3">
                    <x-jet-label value="{!! __('Mother\'s Phone Number') !!}" />

                    <x-jet-input class="{{ $errors->has('mothers_phone_no') ? 'is-invalid' : '' }}" type="text" name="mothers_phone_no"
                                 :value="old('mothers_phone_no')" required />
                    <x-jet-input-error for="mothers_phone_no"></x-jet-input-error>
                </div>

                <div class="mb-3">
                    <x-jet-label value="{!! __('Address') !!}" />
                    <textarea name="address" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" id="" rows="2">{{ old('address') }}</textarea>
                    {{-- <x-jet-input class="{{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" --}}
                                 {{-- :value="old('address')" required /> --}}
                    <x-jet-input-error for="address"></x-jet-input-error>
                </div>


                <div class="mb-3">
                    <x-jet-label value="{{ __('Password') }}" />

                    <x-jet-input class="{{ $errors->has('password') ? 'is-invalid' : '' }}" type="password"
                                 name="password" required autocomplete="new-password" />
                    <x-jet-input-error for="password"></x-jet-input-error>
                </div>

                <div class="mb-3">
                    <x-jet-label value="{{ __('Confirm Password') }}" />

                    <x-jet-input class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" />
                </div>

                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="mb-3">
                        <div class="custom-control custom-checkbox">
                            <x-jet-checkbox id="terms" name="terms" />
                            <label class="custom-control-label" for="terms">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'">'.__('Terms of Service').'</a>',
                                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'">'.__('Privacy Policy').'</a>',
                                    ]) !!}
                            </label>
                        </div>
                    </div>
                @endif


                <div class="mb-0">
                    <div class="d-flex justify-content-end align-items-baseline">
                        <a class="text-muted me-3 text-decoration-none" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>

                        <x-jet-button>
                            {{ __('Register') }}
                        </x-jet-button>
                    </div>
                </div>
            </form>
        </div>
    </x-jet-authentication-card>
</x-guest-layout>
