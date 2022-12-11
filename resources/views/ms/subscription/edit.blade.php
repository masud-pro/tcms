@extends('layouts.cms')

@section('title')
    Subscription
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="row">
        {{-- @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Subscription</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('subscription.update', $subscription->id) }}" method="POST">

                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-md-4">
                                <label for="name">Subscription Name</label>
                                <input class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name') ?? $subscription->name}}" type="text">
                                @error('name')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>


                            <div class="col-md-4">
                                <label class="" for="price">Subscription Price</label>
                                <input class="form-control @error('price') is-invalid @enderror" id="price"  min="1"
                                    name="price" value="{{ old('price') ?? $subscription->price }}" type="number">
                                @error('price')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="days">Subscription Day Duration</label>
                                <input class="form-control @error('days') is-invalid @enderror" id="days" min="1"
                                    name="days" value="{{ old('days') ?? $subscription->days }}" type="number">
                                @error('days')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>



                        <div class="row">
                            <div class="col text-left">
                                <input type="submit" value="Update" class="btn btn-primary mt-4">
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
@endsection


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#batch').select2();
        });
    </script>
@endpush
