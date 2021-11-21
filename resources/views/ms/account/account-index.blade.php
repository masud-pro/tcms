@extends('layouts.cms')

@section('title')
    Accounts
@endsection

@push("styles")
    <link href="{{ asset("assets") }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')

<div class="row">
    <div class="col-md-12">

        @if ( session('success') )
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <a class="btn btn-primary mb-4" onclick="return confirm('Are you sure you want to re generate?')" href="{{ route("account.regenerate",['course' => request()->course]) }}">Regenerate Payments</a>
        <a class="btn btn-primary mb-4" onclick="return confirm('Are you sure you want to newly regenerate?')" href="{{ route("account.regenerate.new",['course' => request()->course]) }}">Newly Generate Payments</a>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Account for {{ \Carbon\Carbon::today()->format('M-Y') }}</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <form action="{{ route("account.change") }}" method="POST">
                        @csrf
                        @method("PATCH")
                        <table class="table table-hover table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Amount</th>
                                    <th>Account</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Amount</th>
                                    <th>Account</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($accounts as $account)
                                    <tr>
                                        <td>{{ $account->user ? $account->user->name : "Not Found" }}</td>
                                        <td>{{ $account->user ? $account->user->email : "Not Found" }}</td>
                                        <td>{{ $account->paid_amount ?? "Not Found" }}</td>
                                        <td>
                                            <input type="hidden" name="ids[]" value="{{ $account->id }}">
                                            <div class="custom-control custom-checkbox">
                                                <input {{ $account->status == "Paid" ? "checked" : "" }}  name="status[]" value="{{ $account->id }}" type="checkbox" class="custom-control-input" id="customCheck{{ $account->id }}">
                                                <label class="custom-control-label" for="customCheck{{ $account->id }}">Paid</label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <input type="hidden" name="course_id" value="{{ request()->course->id }}">
                        <input type="submit" class="btn btn-primary" value="Update">
                    </form>

                    <div class="text-right">
                        <a href="{{ route("course.feeds.index",['course'=>request()->course]) }}">Go Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    
@endsection


@push('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset("assets") }}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset("assets") }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset("assets") }}/js/demo/datatables-demo.js"></script>
@endpush