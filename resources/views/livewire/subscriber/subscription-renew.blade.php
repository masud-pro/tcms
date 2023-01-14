<div>

    <form wire:submit.prevent="submit" autocomplete="off">

        <div class="row">
            <div class="col-md-5">
                <div class="card shadow-lg">
                    <div class="card-body p-0">
                        <div class="row">
                            {{-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> --}}
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Subscription Renew</h1>
                                    </div>
                                    <div class="user">
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                
                                                <label for="name">Plan List</label>
                                                <div wire:ignore>
                                                    <select wire:model="planName" id="planName"
                                                        class="form-control form-control-user @error('planName') is-invalid @enderror js-example-disabled-results">
                                                        <option value="">Select Your Plan</option>
                                                        @foreach ($planList as $data)
                                                            <option value="{{ $data->id }}" {{ $planName == $data->id ? 'selected' : '' }} >{{ $data->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                
                                                @error('planName')
                                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <label for="planPrice">Plan Price</label>
                                                <input type="number" disabled
                                                    class="form-control form-control-user @error('planPrice') is-invalid @enderror"
                                                    id="planPrice" placeholder="Price" wire:model="planPrice">
                                                @error('planPrice')
                                                    <p class="text-start text-danger small mt-1">{{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                        </div>




                                        {{-- <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="text"
                                                    class="form-control form-control-user @error('phoneNumber') is-invalid @enderror"
                                                    id="phoneNumber" placeholder="Phone Number"
                                                    wire:model="phoneNumber">

                                                @error('phoneNumber')
                                                    <p class="text-start text-danger small mt-1">
                                                        {{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="col-sm-6">
                                                <input type="text"
                                                    class="form-control form-control-user @error('username') is-invalid @enderror"
                                                    id="username" placeholder="User Name"
                                                    wire:model="username">

                                                @error('username')
                                                    <p class="text-start text-danger small mt-1">
                                                        {{ $message }}</p>
                                                @enderror
                                            </div>

                                        </div> --}}

                                        <div class="form-group">
                                            <input type="number" min="0"
                                                class="form-control form-control-user @error('month') is-invalid @enderror"
                                                id="month" placeholder="Renew For how many Month's"
                                                wire:model="month" autocomplete="off">

                                            @error('month')
                                                <p class="text-start text-danger small mt-1">{{ $message }}
                                                </p>
                                            @enderror
                                        </div>

                                        {{-- <div class="form-group">
                                            <textarea class="form-control form-control-user @error('address') is-invalid @enderror" id="address"
                                                placeholder="Address" wire:model="address"></textarea>

                                            @error('address')
                                                <p class="text-start text-danger small mt-1">{{ $message }}
                                                </p>
                                            @enderror
                                        </div> --}}





                                     
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Renew Subscription
                                        </button>

                                    </div>
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="col-md-7">
                {{-- <div class="card" style="">

                    <div class="card-body">
                        <h5 class="card-title">Feature list</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                            the card's content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div> --}}








                <div class="card o-hidden shadow-lg">
                    <div class="card-body p-0">



                        {{-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> --}}

                        <div class="p-5">
                            <div class="form-group row">
                                <div class="col-sm-12 mb-3">

                                    <h2 class="text-end fs-2 price-container fw-bold price-digit"> {{ $price }} <span
                                            class="fs-6 ml-xx-8 price-currency">tk</span></h2>

                                </div>

                            </div>

                            <div class="form-group row mt-xx-10">
                                <h4 class="fs-4 text-bold">Feature list</h4>
                                <div class="col-sm-12 mb-3 mb-sm-0">

                                    @foreach ($featureList ?? [] as $feature)
                                                <h6> <span class="pr-1">-</span>
                                                    {{ Str::of(Str::of(Str::replace('.', ' ', $feature))->camel())->headline() }}
                                                </h6>
                                               
                                            @endforeach

                                    {{-- <h6> <span class="pr-1">-</span> hello World</h6>
                                    <h6> <span class="pr-1">-</span> hello World</h6>
                                    <h6> <span class="pr-1">-</span> hello World</h6>
                                    <h6> <span class="pr-1">-</span> hello World</h6> --}}

                                </div>
                            </div>

                        </div>

                    </div>

                </div>






            </div>
        </div>

    </form>
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

        window.addEventListener('reInitJquery', event => {
            var $disabledResults = $(".js-example-disabled-results");
            $disabledResults.select2();
        })

        $('#startDate').on('change', function(e) {
            @this.set('startDate', e.target.value);

        });

        // $('#monthCount').on('change', function(e) {
        //     @this.set('monthCount', e.target.value);

        // });


        $('#subscriberName').change(function() {
            var subscriberName = $('#subscriberName').val();
            @this.set('subscriberName', this.value);
        });


        $('#planName').change(function() {
            var planName = $('#planName').val();
            @this.set('planName', this.value);
        });
    </script>
@endpush

@push('styles')
    @livewireStyles()
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('assets') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="{{ asset('assets') }}/css/datepicker/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css">

    <style>
        .mt-xx-10 {
            margin-top: -9%;
        }

        .ml-xx-8 {
            margin-left: -8px;
        }
        .price-digit{
            color: #0d6efd;
        }
        .price-currency{
            color: #000;
        }
    </style>
@endpush
