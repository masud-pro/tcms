<div>
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-3 offset-lg-9 text-right">
            <input type="text" class="form-control mb-3" placeholder="Search Name or ID"
                wire:model.debounce.500ms="search">
            {{-- <input type="text" class="form-control mb-3" placeholder="Search Name"> --}}
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Purpose Of Payment</th>
                    <th>Last Payment Date</th>
                    <th>Extended Date</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Transaction ID</th>
                    <th>Purpose Of Payment</th>
                    <th>Last Payment Date</th>
                    <th>Extended Date</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </tfoot>
            <tbody>

                @forelse  ($ownTransaction as $transaction)
                    <tr>
                        <td>
                            {{ $transaction->id }}
                        </td>
                        <td><b>{{ $transaction->purpose ?? 'Not Found' }}</b></td>
                        <td>
                            {{ Carbon\Carbon::parse($transaction->to_date)->format('d M Y') }}
                        </td>
                        <td>
                            {{ Carbon\Carbon::parse($transaction->from_date)->format('d M Y') }}
                        </td>
                        <td>
                            {{ $transaction->total_price }}
                        </td>
                        <td>
                            {{ $transaction->status == 1 ? 'Paid' : 'Unpaid' }}
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="9"> No matching records found </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $ownTransaction->links() }}
    </div>
</div>



@push('scripts')
    @livewireScripts()
@endpush



@push('styles-before')
    @livewireStyles()
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
@endpush
