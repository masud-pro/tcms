@extends('layouts.cms')

@section('title')
    Offline Payment
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Pay</h6>
            </div>
            <div class="card-body">
                <ul style="list-style: none">
                    <li class="h2 text-dark">Bkash No: <b>{{ $bkashNumber }}</b></li>
                    <li class="h2 text-dark">Rocket No: <b>{{ $rocketNumber }}</b></li>
                    <li class="h2 text-dark">Nagad No: <b>{{ $nagadNumber }}</b></li>
                    <li class="h2 text-dark">Payable: <b>{{ $account->paid_amount ?? "" }} Tk</b></li>
                    <li class="h5 text-dark"><b>Note: You can pay via app too</b></li>
                </ul>
                <div class="row">
                    <div class="col-md-6">
                        <a target="_blank" href="{{ asset("images/payments/bkash-sendmoney.jpg") }}">
                            <img class="img-fluid" src="{{ asset("images/payments/bkash-sendmoney.jpg") }}">
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a target="_blank" href="{{ asset("images/payments/rocket-sendmoney.jpg") }}">
                            <img class="img-fluid" src="{{ asset("images/payments/rocket-sendmoney.jpg") }}">
                        </a>
                    </div>
                </div>
                
                <form action="{{ route("student.pay.offline.store") }}" method="POST">

                    @csrf

                    <label for="name">Billing Name</label>
                    <input value="{{ old("name") }}" name="name" class="form-control mb-3" id="name" type="text">
                    @error('name')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label for="name">Email</label>
                    <input readonly value="{{ $account->user ? $account->user->email : "" }}" name="email" class="form-control mb-3" id="email" type="email">
                    @error('email')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label for="name">Address</label>
                    <input readonly value="{{ $account->user ? $account->user->address : "" }}" name="address" class="form-control mb-3" id="address" type="text">
                    @error('address')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label for="name">Payment Phone Number <small>(From which the payment was made)</small></label>
                    <input value="{{ old("phone") }}" name="phone" class="form-control mb-3" id="phone" type="text">
                    @error('phone')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label for="card_type">Paid By</label>
                    <select class="form-control mb-3" name="card_type" id="card_type">
                        <option value="Offline-Bkash">Bkash</option>
                        <option value="Offline-Rocket">Rocket</option>
                        <option value="Offline-Nagad">Nagad</option>
                    </select>
                    @error('card_type')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label for="name">Transaction ID</label>
                    <input value="{{ old("transaction_id") }}" name="transaction_id" class="form-control mb-3" id="transaction_id" type="text">
                    @error('transaction_id')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label for="amount">Amount</label>
                    <input readonly value="{{ $account->paid_amount ?? "" }}" name="amount" class="form-control mb-1" id="amount" type="number">
                    @error('amount')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <input type="hidden" value="{{ $account->id }}" name="account_id">
                    <input type="submit" value="Pay Now" class="btn btn-primary mt-4">

                </form>
            </div>
        </div>
    </div>    
</div>
    
@endsection

