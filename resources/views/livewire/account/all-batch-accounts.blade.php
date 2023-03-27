<div>
    <div class="row">
        <div class="col-lg-3">
            {{-- Filter By Status --}}
            <label><b>Filter By Status</b></label>
            <select wire:model.debounce.500ms="status" class="form-control mb-3">
                <option value="">All</option>
                <option value="Paid">Paid</option>
                <option value="Unpaid">Unpaid</option>
                <option value="Pending">Pending</option>
            </select>
        </div>
        <div class="col-lg-3 offset-lg-6">
            <label><b>Search Student</b></label>
            <input type="text" wire:model.debounce.500ms="student" class="form-control mb-3" name="student" value="{{ old('student') }}" placeholder="Search Student Name or ID">
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Account</th>
                            <th>Authorization</th>
                            <th>Status</th>
                            <th>Course</th>
                            <th>Email</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Account</th>
                            <th>Authorization</th>
                            <th>Status</th>
                            <th>Course</th>
                            <th>Email</th>
                            <th>Amount</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($accounts as $account)
                            <tr>
                                <td>{{ $account->user ? $account->user->id : 'Not Found' }}</td>
                                <td>{{ $account->user ? $account->user->name : 'Not Found' }}</td>
                                <td>
                                    <div class="form-check form-switch ml-3">
                                        <input wire:change="change_status( {{ $account->id }},'{{ $account->status }}' )" class="form-check-input" type="checkbox" @if ($account->status == 'Paid') checked @endif
                                            id="flexSwitchCheckDefault{{ $account->id }}">
                                        <label class="form-check-label" for="flexSwitchCheckDefault{{ $account->id }}">
                                            Paid
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    @php($authorizationSataus = $account->course?->user?->where('id',$account->user_id)->first()?->pivot->is_active)

                                    <div class="form-check form-switch ml-3">
                                        <input wire:change="change_authorization_status( {{ $account->course->id }},{{ $account->user->id }}, {{ $authorizationSataus }} )" class="form-check-input" type="checkbox" @if ($authorizationSataus == 1) checked @endif
                                            id="authorizationSwitch{{ $account->id }}">
                                        <label class="form-check-label" for="authorizationSwitch{{ $account->id }}">
                                        
                                        @if ($authorizationSataus == 1)
                                            <span class="badge badge-success">Authorized</span>
                                        @elseif ($authorizationSataus == 0)
                                            <span class="badge badge-warning">Not Authorized</span>
                                        @else
                                            <span class="badge badge-danger">Not Found</span>
                                        @endif
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    @if ($account->status == 'Paid')
                                        <span class="badge badge-success">Paid</span>
                                    @elseif ($account->status == 'Unpaid')
                                        <span class="badge badge-danger">Unpaid</span>
                                    @elseif ($account->status == 'Pending')
                                        <span class="badge badge-secondary">Pending</span>

                                        <a href="{{ route('account.mark-unpaid', ['account' => $account->id]) }}" class="btn btn-warning btn-sm"
                                            onclick="return confirm('Are you sure you want to mark this payment as unpaid?')">
                                            Mark Unpaid
                                        </a>
                                    @endif
                                </td>
                                <td>{{ $account->course ? $account->course->name : 'Not Found' }}</td>
                                <td>{{ $account->user ? $account->user->email : 'Not Found' }}</td>
                                <td>{{ $account->paid_amount ?? 'Not Found' }}
                                    <a data-toggle="modal" data-target="#updateAmountModal" wire:click="customAmount({{ $account->id ?? '' }})" class="float-right" rel="custom input">
                                        <i class="far fa-edit fa-lg"></i>
                                    </a>
                                </td>



                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg mt-4">
            {{ $accounts->links() }}
            <a class="small" id="pdf" hidden wire:click.prevent="downloadPDF">Download as PDF</a>
        </div>
        {{-- <div class="col-lg mt-4 text-right">
            <a href="{{ route('reauthorize.all') }}" class="btn btn-primary" onclick="return confirm('Are you sure you want to reauthorize the users now?')">Re-authorize Users</a>
        </div> --}}


        {{-- <button type="button" wire:click="flushCreate" class="btn btn-primary mb-3" data-toggle="modal" data-target="#createModal"> --}}

    </div>


    <!-- Update Amount Modal -->
    <div wire:ignore.self class="modal fade" id="updateAmountModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Edit Amount</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label class="" for="amount">Amount</label>
                    <input wire:model.defer="amount" value="{{ old('amount') }}" name="amount" class="form-control @error('amount') is-invalid @enderror" min="0" id="amount" type="number">
                    @error('amount')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger close-btn" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="newAmount({{ $account->id ?? '' }})">Update</button>
                    {{-- <button type="button" class="btn btn-primary" id="updateReauthButton">Update and
                        Re-authorize</button> --}}
                </div>
            </div>
        </div>
    </div>


</div>


@push('scripts')
    @livewireScripts()
    <script>
        $("#updateButton").click(function() {
            $("#updateForm").submit();
        });
        $("#updateReauthButton").click(function() {
            $("input#reauth_all").val("1");
            $("#updateForm").submit();
        });

        function clickpdf() {
            document.getElementById("pdf").click();
        }


        window.addEventListener('closeModal', event => {
            $('#updateAmountModal').modal('hide');
        });
    </script>
@endpush

@push('styles')
    @livewireStyles()
    <style>
        .form-check-input:checked {
            background-color: #1cc88a;
            border-color: #1cc88a;
        }

        .sidebar-dark hr.sidebar-divider {
            border-top: 1px solid rgba(255, 255, 255, .7);
            box-sizing: content-box;
            height: 0;
            overflow: visible;
        }

        .form-check-input,
        .form-check-label {
            cursor: pointer;
        }

        .tick-positions {
            display: flex;
            position: relative;
            margin-top: -18px;
        }

        .green {
            color: #1cc88a
        }

        .green:hover {
            color: #0da86f
        }
    </style>
@endpush

@push('styles-before')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
@endpush
