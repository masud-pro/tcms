<div>
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
                @if ( isset($user) )
                    <table class="table table-hover table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Batch</th>
                                <th>Email</th>
                                <th>Paid Amount</th>
                                <th>Last Updated</th>
                                <th>Is Paid</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Batch</th>
                                <th>Email</th>
                                <th>Paid Amount</th>
                                <th>Last Updated</th>
                                <th>Is Paid</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($accounts as $account)
                                <tr>
                                    <td>{{ $account->user ? $account->user->name : "Not Found" }}</td>
                                    <td>{{ $account->course ? $account->course->name : "Not Found" }}</td>
                                    <td>{{ $account->user ? $account->user->email : "Not Found" }}</td>
                                    <td>{{ $account->paid_amount ?? "Not Found" }}</td>
                                    <td>{{ $account->updated_at ? \Carbon\Carbon::parse()->format("d-M-Y g:i a") : "Not Found" }}</td>
                                    <td>
                                        <input type="hidden" name="ids[]" value="{{ $account->id }}">
                                        <div class="custom-control custom-checkbox">
                                            <input {{ $account->status == "Paid" ? "checked" : "" }}  name="status[]" value="{{ $account->id }}" type="checkbox" class="custom-control-input" id="customCheck{{ $account->id }}">
                                            <label class="custom-control-label" for="customCheck{{ $account->id }}">Paid</label>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($account->status == "Paid")
                                            <a class="btn btn-success">Paid</a>
                                        @else
                                            <a href="{{ route("student.pay",[ "account" => $account->id ]) }}" class="btn btn-primary">Pay Now</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                {{ $accounts->links() }}
                <div class="text-right">
                    <a href="{{ route("dashboard") }}">Go Back</a>
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
