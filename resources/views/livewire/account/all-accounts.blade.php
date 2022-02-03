<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                
                <div class="row">
                    <div class="col">Account</div>
                    @if ( !$q )
                        <div class="col text-right"> 
                            @if ( $total != null )
                                Total this month - {{ $total }} Tk
                            @endif 
                            @if ( $totalUnpaid != null )
                                and Total due - {{ $totalUnpaid }} Tk
                            @endif
                        </div>
                    @endif
                </div>
                <div wire:loading>
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </h6>
        </div>
        <div class="card-body">
            <div class="form-row mb-4">
                <div class="col-md">
                    <label><b>Batch / Course</b></label>
                    <select wire:model.debounce.500ms="batch" class="form-control">
                        <option value="">Select Batch / Course</option>
                        @foreach ( $batches as $sbatch )
                            <option value="{{ $sbatch->id }}">{{ $sbatch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md">
                    <label><b>Month</b></label>
                    <input type="text" id="month" class="form-control" wire:model.debounce.500ms="month" placeholder="Enter Month">
                </div>
                <div class="col-md">
                    <label><b>Search</b></label>
                    <input type="text" class="form-control" wire:model.debounce.1000ms="q" placeholder="Search">
                </div>
            </div>

            <div class="table-responsive">
                <form id="updateForm" method="POST" action="{{ route("account.change") }}">
                    @csrf
                    @method("PATCH")
                    @if ( isset($batch) && isset($month) )
                        <table class="table table-hover table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Paid Amount</th>
                                    <th>Last Updated</th>
                                    <th>Is Paid</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Paid Amount</th>
                                    <th>Last Updated</th>
                                    <th>Is Paid</th>
                                    <th>Delete</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($accounts as $account)
                                    <tr>
                                        <td>{{ $account->user_name ?? "Not Found" }}</td>
                                        <td>{{ $account->user_email ?? "Not Found" }}</td>
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
                                            <button type="button" wire:click="deleteId({{ $account->id }})" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <input type="hidden" name="course" value="{{ $batch ?? 0 }}">
                        <input type="hidden" name="reauth" value="0" id="reauth">

                        {{-- <input type="submit" class="btn btn-primary" value="Update"> --}}

                        <!-- Update trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateModal">
                            Update
                        </button>
                    @endif                    
                </form>
                <div class="text-right">
                    <a href="{{ route("dashboard") }}">Go Back</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Confirm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true close-btn">×</span>
                    </button>
                </div>
            <div class="modal-body">
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                    <button type="button" wire:click.prevent="delete()" class="btn btn-danger close-modal" data-dismiss="modal">Yes, Delete</button>
                </div>
            </div>
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
                    <li>Update with re-authorize will update the accounts and give <b>access to the students to the course materials based on their payment status.</b></li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="updateButton">Update</button>
                <button type="button" class="btn btn-primary" id="updateReauthButton">Update and Re-authorize</button>
            </div>
        </div>
        </div>
    </div>

</div>





@push('styles')
    @livewireStyles()
    <link href="{{ asset("assets") }}/css/datepicker/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css">
@endpush
@push('scripts')
    @livewireScripts()
    <script src="{{ asset("assets") }}/js/datepicker/bootstrap-datepicker.min.js"></script>
    <script>

        $('#month').datepicker({
            format: "mm-yyyy",
            startView: "months", 
            minViewMode: "months",
            autoclose: true,
            todayHighlight: true
        });

        $('#month').on('change', function (e) {
            @this.set('month', e.target.value);
        });

        $(document).ready(function() {    
            $("#updateButton").click(function(){
                $("#updateForm").submit();
            });
            $("#updateReauthButton").click(function(){
                $("input#reauth").val("1");
                $("#updateForm").submit();
            });
        });

    </script>
@endpush
