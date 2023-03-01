@extends('layouts.cms')

@section('title')
    Link for {{ $course->name ?? '' }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Create A Link</h6>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('course.feeds.store-link', ['course' => $course->id]) }}" method="POST">

                        @csrf

                        <label for="name">Name</label>
                        <input value="{{ old('name') }}" name="name" class="form-control" id="name"
                            type="text">
                        @error('name')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror

                        <label for="link" class="mt-3">Link</label>
                        <input type="text" value="{{ old('link') }}" name="link" id="link"
                            class="form-control" />
                        @error('link')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror


                        <input type="hidden" name="type" value="link">

                        <div class="row">
                            <div class="col text-left">
                                <input type="submit" value="Create" class="btn btn-primary mt-4">
                            </div>
                            <div class="col text-right mt-4">
                                <a href="{{ route('course.feeds.index', ['course' => request()->course]) }}">Go Back</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
