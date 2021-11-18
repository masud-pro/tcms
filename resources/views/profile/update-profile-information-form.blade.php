<x-jet-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form">

        <x-jet-action-message on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div class="mb-3" x-data="{photoName: null, photoPreview: null}">
                <!-- Profile Photo File Input -->
                <input type="file" hidden
                       wire:model="photo"
                       x-ref="photo"
                       x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-jet-label for="photo" value="{{ __('Photo') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" class="rounded-circle" height="80px" width="80px">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview">
                    <img x-bind:src="photoPreview" class="rounded-circle" width="80px" height="80px">
                </div>

                <x-jet-secondary-button class="mt-2 me-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
				</x-jet-secondary-button>
				
				@if ($this->user->profile_photo_path)
                    <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        <div wire:loading wire:target="deleteProfilePhoto" class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>

                        {{ __('Remove Photo') }}
                    </x-jet-secondary-button>
                @endif

                <x-jet-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <div class="w-md-75">
            <!-- Name -->
            <div class="mb-3">
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" type="text" class="{{ $errors->has('name') ? 'is-invalid' : '' }}" wire:model.defer="state.name" autocomplete="name" />
                <x-jet-input-error for="name" />
            </div>

            <!-- Email -->
            <div class="mb-3">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" type="email" class="{{ $errors->has('email') ? 'is-invalid' : '' }}" wire:model.defer="state.email" />
                <x-jet-input-error for="email" />
            </div>

            @if (auth()->user()->role == "Student")
                <div class="mb-3">
                    <x-jet-label for="dob" value="{{ __('Date Of Birth') }}" />
                    <x-jet-input id="dob" type="date" class="{{ $errors->has('dob') ? 'is-invalid' : '' }}" wire:model.defer="state.dob" />
                    <x-jet-input-error for="dob" />
                </div>
                
                <div class="mb-3">
                    <x-jet-label for="gender" value="{{ __('Gender') }}" />
                    <select wire:model.defer="state.gender" class="form-control" name="gender" id="">
                        <option selected value="male">Male</option>
                        <option selected value="female">Female</option>
                    </select>
                    <x-jet-input-error for="gender" />
                </div>

                <div class="mb-3">
                    <x-jet-label for="phone_no" value="{{ __('Phone No') }}" />
                    <x-jet-input id="phone_no" type="text" class="{{ $errors->has('phone_no') ? 'is-invalid' : '' }}" wire:model.defer="state.phone_no" />
                    <x-jet-input-error for="phone_no" />
                </div>

                <div class="mb-3">
                    <x-jet-label for="class" value="{{ __('Class') }}" />
                    <x-jet-input id="class" type="text" class="{{ $errors->has('class') ? 'is-invalid' : '' }}" wire:model.defer="state.class" />
                    <x-jet-input-error for="class" />
                </div>

                <div class="mb-3">
                    <x-jet-label for="roll_no" value="{{ __('Roll No') }}" />
                    <input disabled value="{{ auth()->user()->roll }}" id="roll_no" type="text" class="form-control {{ $errors->has('roll_no') ? 'is-invalid' : '' }}" />
                    <x-jet-input-error for="roll_no" />
                </div>

                <div class="mb-3">
                    <x-jet-label for="reg" value="{{ __('Registration No') }}" />
                    <input disabled value="{{ auth()->user()->reg_no }}" id="reg" type="text" class="form-control {{ $errors->has('reg') ? 'is-invalid' : '' }}" />
                    <x-jet-input-error for="reg" />
                </div>

                <div class="mb-3">
                    <x-jet-label for="waiver" value="{{ __('Waiver') }}" />
                    <input disabled value="{{ auth()->user()->waiver }}" id="waiver" type="text" class="form-control {{ $errors->has('waiver') ? 'is-invalid' : '' }}" />
                    <x-jet-input-error for="waiver" />
                </div>

                <div class="mb-3">
                    <x-jet-label for="fathers_name" value="{!! __('Father\'s Name') !!}" />
                    <x-jet-input id="fathers_name" type="text" class="{{ $errors->has('fathers_name') ? 'is-invalid' : '' }}" wire:model.defer="state.fathers_name" />
                    <x-jet-input-error for="fathers_name" />
                </div>

                <div class="mb-3">
                    <x-jet-label for="fathers_phone_no" value="{!! __('Father\'s Phone Number') !!}" />
                    <input disabled value="{{ auth()->user()->fathers_phone_no }}" id="fathers_phone_no" type="text" class="form-control {{ $errors->has('fathers_phone_no') ? 'is-invalid' : '' }}" />
                    <x-jet-input-error for="fathers_phone_no" />
                </div>

                <div class="mb-3">
                    <x-jet-label for="mothers_name" value="{!! __('Mother\'s Name') !!}" />
                    <x-jet-input id="mothers_name" type="text" class="{{ $errors->has('mothers_name') ? 'is-invalid' : '' }}" wire:model.defer="state.mothers_name" />
                    <x-jet-input-error for="mothers_name" />
                </div>

                <div class="mb-3">
                    <x-jet-label for="mothers_phone_no" value="{!! __('Mother\'s Phone Number') !!}" />
                    <input disabled value="{{ auth()->user()->mothers_phone_no }}" id="mothers_phone_no" type="text" class="form-control {{ $errors->has('mothers_phone_no') ? 'is-invalid' : '' }}" />
                    <x-jet-input-error for="mothers_phone_no" />
                </div>

                <div class="mb-3">
                    <x-jet-label for="address" value="{!! __('Address') !!}" />
                    <textarea class="form-control" id="address" type="text" class="{{ $errors->has('address') ? 'is-invalid' : '' }}" wire:model.defer="state.address" /></textarea>
                    <x-jet-input-error for="address" />
                </div>
            @endif
        </div>
    </x-slot>

    <x-slot name="actions">
		<div class="d-flex align-items-baseline">
			<x-jet-button>
                <div wire:loading class="spinner-border spinner-border-sm" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>

				{{ __('Save') }}
			</x-jet-button>
		</div>
    </x-slot>
</x-jet-form-section>