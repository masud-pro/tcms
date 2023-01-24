<div>
    {{-- @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif --}}
    {{-- <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#createModal"> Buy Message </button> --}}


    <!-- Create Modal -->
    {{-- <div class="modal fade" id="createModal" tabindex="-1" role="dialog" --}}
    <div wire:ignore.self class="modal fade" id="createModal" tabindex="-1" role="dialog"
        aria-labelledby="createModalLabel" aria-hidden="true">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form wire:submit.prevent="submit">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Buy More SMS</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show m-12" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show m-12" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="modal-body">

                        <label><b>Per Sms Rate In BDT</b></label>
                        <input wire:model="perSms" type="number" class="form-control" placeholder="Per Sms Rate"
                            disabled>
                   
                        <label class="mt-3"><b>Please Select Your Package</b></label>
                        <div wire:ignore>
                            <select wire:model="smsPackage" id="smsPackage"
                                class="form-control @error('smsPackage') is-invalid @enderror js-example-disabled-results">
                                <option value="">Select Subscription Package</option>

                                <option value="500">500</option>
                                <option value="1000">1000</option>
                                <option value="1500">1500</option>
                                <option value="2000">2000</option>
                                <option value="5000">5000</option>
                                <option value="7000">7000</option>
                                <option value="10000">10000</option>
                                {{-- @foreach ($subscriptionList as $data)
                                <option value="{{ $data->id }}">{{ $data->name }}
                                </option>
                            @endforeach --}}
                            </select>
                        </div>

                        @error('smsPackage')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror

                        <label class="mt-3"><b>Price</b></label>
                        <input wire:model="price" type="number" min="0" class="form-control" disabled>

                        {{-- <label class="mt-3"><b>Month</b></label>
                    <input wire:model.lazy="account.month" type="text" id="createMonth" class="form-control" placeholder="Account For Month"> --}}

                    </div>
                    <div class="modal-footer">
                        {{-- <input type="submit"  value="Create"> --}}
                        <button type="submit" class="btn btn-primary text-center">Buy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>



@push('scripts')
    @livewireScripts()
    <script src="{{ asset('assets') }}/js/datepicker/bootstrap-datepicker.min.js"></script>
    <script>
        // $('.sub-calander').datepicker({
        //     format: "yyyy-mm-dd",
        //     // startView: "months",
        //     // minViewMode: "months",
        //     autoclose: true,
        //     todayHighlight: true
        // });

        window.addEventListener('reInitJquery', event => {
            var $disabledResults = $(".js-example-disabled-results");
            $disabledResults.select2();
        })

        // $('#startDate').on('change', function(e) {
        //     @this.set('startDate', e.target.value);

        // });

        // $('#monthCount').on('change', function(e) {
        //     @this.set('monthCount', e.target.value);

        // });


        // $('#subscriberName').change(function() {
        //     var subscriberName = $('#subscriberName').val();
        //     @this.set('subscriberName', this.value);
        // });


        $('#smsPackage').change(function(e) {
            var smsPackage = $('#smsPackage').val();
            @this.set('smsPackage', this.value);
        });
    </script>
@endpush

@push('styles')
    @livewireStyles()
    <style>
        .m-12 {
            margin: 12px;
        }
    </style>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link href="{{ asset('assets') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="{{ asset('assets') }}/css/datepicker/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css">
@endpush
