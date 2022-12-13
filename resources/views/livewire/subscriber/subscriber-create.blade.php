<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Create New subscriber</h6>
                </div>
                <div class="card-body">

                    <form wire:submit.prevent="submit">

                        <div class="row">
                            <div class="col-md-4">
                                <label for="name">Subscriber Name</label>
                                <input class="form-control @error('name') is-invalid @enderror" id="name"
                                    wire:model="name" value="{{ old('name') }}" type="text">
                                @error('name')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>


                            <div class="col-md-4">
                                <label class="" for="price">Subscription Package</label>
                                <input class="form-control @error('price') is-invalid @enderror" id="price"
                                    min="1" wire:model="price" value="{{ old('price') }}" type="number">
                                @error('price')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="days">Subscription Day Duration</label>
                                <input class="form-control @error('days') is-invalid @enderror" id="days"
                                    min="1" wire:model="days" value="{{ old('days') }}" type="number">
                                @error('days')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- end  --}}
                        </div>

                        {{-- Feature --}}


                        <div class="row">
                            <div class="col text-left">
                                <button type="submit" class="btn btn-primary mt-4">Create</button>
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
