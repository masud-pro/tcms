
<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            {{-- <x-jet-authentication-card-logo /> --}}
            <div class="text-center mb-3 ce-logo">
                {{-- <i class="fas fa-chalkboard-teacher"></i> --}}
                <img src="{{ asset('images/login/login.svg') }}" alt="">
            </div>
        </x-slot>


        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-8 col-lg-5">
                <div class="card shadow-sm ">
                    <div class="card-body">

                        <x-jet-validation-errors class="mb-3 rounded-0" />

                        @if (session('status'))
                            <div class="alert alert-success mb-3 rounded-0" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <x-jet-label value="{{ __('Email or Phone') }}" />

                                <x-jet-input class="{{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="identity" :value="old('email')" required />
                                <x-jet-input-error for="email"></x-jet-input-error>
                            </div>


                            <div class="mb-3">
                                <x-jet-label value="{{ __('Password') }}" />

                                <x-jet-input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" name="password" required autocomplete="current-password" />
                                <x-jet-input-error for="password"></x-jet-input-error>
                            </div>


                            <div class="mb-3">
                                <div class="custom-control custom-checkbox">
                                    <x-jet-checkbox id="remember_me" name="remember" />
                                    <label class="custom-control-label" for="remember_me">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>

                            <div class="mb-0">
                                <div class="d-flex justify-content-end align-items-baseline">
                                    @if (Route::has('password.request'))
                                        <a class="text-muted me-3" href="{{ route('password.request') }}">
                                            {{ __('Forgot your password?') }}
                                        </a>
                                    @endif

                                    <x-jet-button>
                                        {{ __('Log in') }}
                                    </x-jet-button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



    </x-jet-authentication-card>
</x-guest-layout>
