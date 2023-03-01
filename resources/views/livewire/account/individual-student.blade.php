<div>
    <div class="text-center">
        <h2 class="text-danger mb-3">You Have {{ $due }} Due Payment(s). Please Pay.</h2>
    </div>

    <ul>
        <li><b>Manual payment is done via Bkash, Rocket, Nagad and you have to make the payment manually from the app or
                USSD.</b></li>
        @if (env('STORE_ID') != null && env('STORE_PASSWORD') != null)
            <li><b>Online payment is a automatic system of payment which includes Visa/Master Cards, Banks, Bkash,
                    Rocket, Nagad, Other internet banking options etc.</b></li>
        @endif
    </ul>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Student Account
                <div wire:loading>
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </h6>
        </div>
        <div class="card-body">
            <label><b>Status</b></label>
            <select wire:model.debounce.500ms="status" class="form-control mb-4">
                <option value="">All</option>
                <option value="Paid">Paid</option>
                <option value="Unpaid">Unpaid</option>
            </select>
            <div class="table-responsive">
                @if (isset($user))
                    <table class="table table-hover table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Is Paid</th>
                                <th>Paid Amount</th>
                                <th>Month</th>
                                <th>Batch</th>
                                <th>Last Updated</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Action</th>
                                <th>Is Paid</th>
                                <th>Paid Amount</th>
                                <th>Month</th>
                                <th>Batch</th>
                                <th>Last Updated</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($accounts as $account)
                                <tr>
                                    <td>
                                        @if ($account->status == 'Paid')
                                            <span class="text-success">✓</span>
                                        @else
                                            @if ($manualPayment == 1)
                                                <a href="{{ route('student.pay.offline', ['account' => $account->id]) }}"
                                                    class="btn btn-primary mt-1">Pay Manually</a>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        <span
                                            class='badge badge-{{ $account->status == 'Paid' ? 'success' : 'danger' }}'>
                                            {{ $account->status == 'Paid' ? 'Paid' : 'Unpaid' }}
                                        </span>

                                    </td>
                                    <td>{{ $account->paid_amount ?? 'Not Found' }}</td>
                                    <td>{{ $account->month ? \Carbon\Carbon::parse($account->month)->format('M-Y') : 'Not Found' }}
                                    </td>
                                    <td>{{ $account->course ? $account->course->name : 'Not Found' }}</td>
                                    <td>{{ $account->updated_at ? \Carbon\Carbon::parse()->format('d-M-Y g:i a') : 'Not Found' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                {{ $accounts->links() }}
                <div class="text-right">
                    <a href="{{ route('dashboard') }}">Go Back</a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    @livewireStyles()
@endpush
@push('scripts')
    @livewireScripts()
@endpush
