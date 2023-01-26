<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Subscriber </h6>
                </div>
                <div class="card-body">

                    <form wire:submit.prevent="submit">

                        <div class="row">

                            <div class="col-md-4">
                                <label for="subscriberName">Subscriber Name</label>
                                <input class="form-control sub-calander @error('subscriberName') is-invalid @enderror"
                                    disabled id="subscriberName" type="text" placeholder="Enter Month"
                                    value="{{ old('subscriberName') }}" wire:model="subscriberName">
                                @error('subscriberName')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="name">Subscription Package</label>

                                <div wire:ignore>
                                    <select wire:model="subscriberPackage" id="subscriberPackage"
                                        class="form-control @error('subscriberPackage') is-invalid @enderror js-example-disabled-results">
                                        <option value="">Select Subscription Package</option>
                                        @foreach ($subscriptionList as $data)
                                            <option value="{{ $data->id }}"
                                                {{ $subscriptionUser->subscription_id == $data->id ? ' selected' : '' }}>
                                                {{ $data->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                @error('subscriberPackage')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror

                            </div>

                            <div class="col-md-4">
                                <label for="price">Subscription Price</label>
                                <input class="form-control @error('price') is-invalid @enderror" id="price" readonly
                                    wire:model.lazy="price" value="{{ old('price') }}" type="number">
                                @error('price')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-4">
                                <label for="expiryDate">Subscription Expiry Date</label>
                                <input class="form-control sub-calander @error('expiryDate') is-invalid @enderror"
                                    disabled id="expiryDate" type="text" placeholder="Enter Month"
                                    value="{{ old('expiryDate') }}" wire:model="expiryDate">
                                @error('expiryDate')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>


                            <div class="col-md-4">
                                <label for="monthCount">Subscription For Month Wise</label>
                                <input class="form-control @error('monthCount') is-invalid @enderror" min="1"
                                    id="monthCount" type="number" placeholder="Enter Month Amount"
                                    value="{{ old('monthCount') }}" wire:model="monthCount">
                                @error('monthCount')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>


                            <div class="col-md-4">
                                <label for="specialPrice">Special Price</label>
                                <input class="form-control @error('specialPrice') is-invalid @enderror"
                                    {{ $specialPriceField == true ? 'disabled' : '' }} min="0" id="specialPrice"
                                    type="number" placeholder="Enter Special Price" value="{{ old('specialPrice') }}"
                                    wire:model="specialPrice">
                                @error('specialPrice')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Feature --}}


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
    <script src="{{ asset('assets') }}/js/datepicker/bootstrap-datepicker.min.js"></script>
    <script>
        $('.sub-calander').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
        });

        window.addEventListener('reInitJquery', event => {
            var $disabledResults = $(".js-example-disabled-results");
            $disabledResults.select2();
        })

        // $('#expiryDate').on('change', function(e) {
        //     @this.set('expiryDate', e.target.value);

        // });

        // $('#monthCount').on('change', function(e) {
        //     @this.set('monthCount', e.target.value);

        // });


        // $('#subscriberName').change(function() {
        //     var subscriberName = $('#subscriberName').val();
        //     @this.set('subscriberName', this.value);
        // });


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
    <link href="{{ asset('assets') }}/css/datepicker/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css">
@endpush
