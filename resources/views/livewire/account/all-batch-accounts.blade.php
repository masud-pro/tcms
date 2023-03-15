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
                                @if ($showInput == true)
                                    <td>
                                        <input class="form-control form-control-user" style="width: 80px;" type="number" min="0" wire:model="newPaidAmount">
                                        <a class="float-right tick-positions green" wire:click="customAmount({{ $account->id }}) rel="custom input">
                                            <i class="far fa-check-circle fa-lg"></i>
                                        </a>
                                    </td>
                                @else
                                    <td >{{ $account->paid_amount ?? 'Not Found' }}
                                        <a class="float-right " for="{{ $account->id }}" wire:click="customAmount({{ $account->id }})" rel="custom input">
                                            <i class="far fa-edit fa-lg"></i>
                                        </a>
                                    </td>
                                @endif

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
        <div class="col-lg mt-4 text-right">
            <a href="{{ route('reauthorize.all') }}" class="btn btn-primary" onclick="return confirm('Are you sure you want to reauthorize the users now?')">Re-authorize Users</a>
        </div>
    </div>


    <!-- Update Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update and Re-authorize?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul>
                        <li>Update will just update the accounts</li>
                        <li>Update with re-authorize will update the accounts and give <b>access to the students to the
                                course materials based on their payment status.</b></li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="updateButton">Update</button>
                    <button type="button" class="btn btn-primary" id="updateReauthButton">Update and
                        Re-authorize</button>
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
