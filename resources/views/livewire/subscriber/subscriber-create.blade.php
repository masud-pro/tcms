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
                            {{-- <div class="col-md-4">
                                <label for="name">Subscriber Name</label>
                                <input class="form-control @error('name') is-invalid @enderror" id="name"
                                    wire:model="name" value="{{ old('name') }}" type="text">
                                @error('name')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div> --}}


                            <div class="col-md-4">
                                <label for="name">Subscriber Name</label>
                                <select wire:model.debounce.500ms="subscriberName" id="subscriberName"
                                    class="form-control js-example-disabled-results">
                                    <option value="">Select Subscriber Name</option>
                                    @foreach ($subscriberList as $data)
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{--                             
                                <div class="col-md-4" wire:ignore>
                                    <label>Batch / Course</label>
                                    <select wire:model.debounce.500ms="batch" id="batch"
                                        class="form-control js-example-disabled-results">
                                        <option value="">Select Batch / Course</option>
                                        <option value="">Select Batch / Course</option>
                                        <option value="">Select Batch / Course</option>
                                        <option value="">Select Batch / Course</option>
                                        <option value="">Select Batch / Course</option>z
                                        @foreach ($batches as $sbatch)
                                            <option value="{{ $sbatch->id }}">{{ $sbatch->name }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}



                            {{-- <div class="col-md-4">
                                <label class="" for="price">Subscription Package</label>
                                <input class="form-control @error('price') is-invalid @enderror" id="price"
                                    min="1" wire:model="price" value="{{ old('price') }}" type="number">
                                @error('price')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div> --}}

                            <div class="col-md-4">
                                <label for="name">Subscription Package</label>
                                <select wire:model.debounce.500ms="subscriberPackage" id="subscriberPackage"
                                    class="form-control js-example-disabled-results">
                                    <option value="">Select Subscription Package</option>
                                    @foreach ($subscriptionList as $data)
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="price">Subscription Price</label>
                                <input class="form-control @error('price') is-invalid @enderror" id="price"
                                    min="1" wire:model="price" value="{{ old('price') }}" type="number">
                                @error('price')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div> 
                        </div> 
                        
                        <div class="row mt-4">
                            {{-- <div class="col-md-4">
                                <label for="name">Subscription Package</label>
                                <select wire:model.debounce.500ms="subscriberPackage" id="subscriberPackage"
                                    class="form-control js-example-disabled-results">
                                    <option value="">Select Subscription Package</option>
                                    @foreach ($subscriptionList as $data)
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div> --}}

                            <div class="col-md-4">
                                <label for="price">Subscription Start Date</label>
                                <input class="form-control @error('price') is-invalid @enderror" id="price"
                                    min="1" wire:model="price" value="{{ old('price') }}" type="date">
                                @error('price')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div> 


                            <div class="col-md-4">
                                <label for="price">Subscription End Date</label>
                                <input class="form-control @error('price') is-invalid @enderror" id="price"
                                    min="1" wire:model="price" value="{{ old('price') }}" type="date">
                                @error('price')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div> 

                            <div class="col-md-4">
                                <label for="price">Subscription Discount</label>
                                <input class="form-control @error('price') is-invalid @enderror" id="price"
                                    min="1" wire:model="price" value="{{ old('price') }}" type="number">
                                @error('price')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div> 
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

@push('scripts')
    @livewireScripts()
    <script>
        $('#subscriberName').change(function() {
            var subscriberName = $('#subscriberName').val();
            @this.set('subscriberName', this.value);
        }); 
        
        
        $('#subscriberPackage').change(function() {
            var subscriberPackage = $('#subscriberPackage').val();
            @this.set('subscriberPackage', this.value);
        });
    </script>
@endpush

@push('styles')
    @livewireStyles()
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link href="{{ asset('assets') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush
