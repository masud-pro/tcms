@extends('layouts.cms')

@section('title')
    All Transactions
@endsection


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
        @if ( session('delete') )
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('delete') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Transaction</h6>
            </div>
            <div class="card-body">
                <table class="table table-hover table-bordered table-responsive" width="100%" >
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>User</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Amount</th>
                            <th>Store Amount</th>
                            <th>Paid By</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Currency</th>
                            <th>Transaction ID</th>
                            <th>Last Updated</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Course</th>
                            <th>User</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Amount</th>
                            <th>Store Amount</th>
                            <th>Paid By</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Currency</th>
                            <th>Transaction ID</th>
                            <th>Last Updated</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>
                                    <a href="{{ $transaction->account ? route("course.feeds.index", ['course'=>$transaction->account->course->id]) : "" }}">
                                        {{ $transaction->account ? $transaction->account->course->name : "" }}
                                    </a>
                                </td>
                                <td>{{ $transaction->user ? $transaction->user->name : "" }}</td>
                                <td>{{ $transaction->name ??  "" }}</td>
                                <td>{{ $transaction->email ??  "" }}</td>
                                <td>{{ $transaction->phone ??  "" }}</td>
                                <td>{{ $transaction->amount ??  "" }}</td>
                                <td>{{ $transaction->store_amount ??  "" }}</td>
                                <td>{{ $transaction->card_type ??  "" }}</td>
                                <td>{{ $transaction->address ??  "" }}</td>
                                <td>{{ $transaction->status ??  "" }}</td>
                                <td>{{ $transaction->currency ??  "" }}</td>
                                <td>{{ $transaction->transaction_id ??  "" }}</td>
                                <td>{{ $transaction->updated_at ? $transaction->updated_at->format('d-M-Y g:i a') : "" }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</div>

    
@endsection

