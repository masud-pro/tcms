@extends('layouts.cms')

@section('title')
    Pay
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            {{-- @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}
            @if (session('failed'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('failed') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Pay</h6>
                </div>
                <div class="card-body">
                    <form action="/pay" method="POST" id="payform">

                        @csrf

                        <label for="name">Billing Name</label>
                        <input value="{{ old('name') }}" name="name" class="form-control mb-3" id="name" type="text">
                        @error('name')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror

                        <label for="name">Email</label>
                        <input readonly value="{{ $account->user ? $account->user->email : '' }}" name="email"
                            class="form-control mb-3" id="email" type="email">
                        @error('email')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror

                        <label for="name">Address</label>
                        <input readonly value="{{ $account->user ? $account->user->address : '' }}" name="address"
                            class="form-control mb-3" id="address" type="text">
                        @error('address')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror

                        <label for="name">Payment Phone Number <small>(From which the payment was made)</small></label>
                        <input value="{{ old('phone_no') }}" name="phone_no" class="form-control mb-3" id="phone_no"
                            type="text">
                        @error('phone_no')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror

                        <label for="name">Amount</label>
                        <input readonly value="{{ $account->paid_amount ?? '' }}" name="amount" class="form-control mb-1"
                            id="amount" type="number">
                        @error('amount')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror

                        <input type="hidden" value="{{ $account->id }}" name="account_id">
                        @if (env('UDDOKTAPAY_API_KEY') != null && env('UDDOKTAPAY_WEBHOOK_DOMAIN') != null && env('UDDOKTAPAY_PAYMENT_DOMAIN') != null)
                            <input type="button" id="submittedViaUddokta" value="Pay Online" class="btn btn-primary mt-4">
                        @endif
                        @if (env('STORE_ID') != null && env('STORE_PASSWORD') != null)
                            <input type="button" id="submittedViaSSL" value="Pay Via SSLCommerz"
                                class="btn btn-primary mt-4">
                        @endif

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function() {
            $(document).ready(function() {
                $("input#submittedViaSSL").click(function(e) {
                    e.preventDefault();
                    var submittedVia = $("#submittedViaSSL").val();
                    $("form#payform").attr("action", "/pay");
                    $("form#payform").submit();
                });

                $("input#submittedViaUddokta").click(function(e) {
                    e.preventDefault();
                    var submittedVia = $("#submittedViaUddokta").val();
                    $("form#payform").attr("action", "/uddokta-pay");
                    $("form#payform").submit();
                });
            });
        })(jQuery)
    </script>
@endpush
