<div>
    @if ( session('success') )
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <button type="button" wire:click="flushCreate" class="btn btn-primary mb-3" data-toggle="modal" data-target="#createModal">
        Add To Overall Account
    </button>

    <a href="{{ route("account.manual.create") }}" class="btn btn-primary mb-3">Add Student Accounts</a>
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-lg-4 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Net Income</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total ?? "Not Found" }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-lg-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Student Payments</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPaid ?? "Not Found" }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-lg-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Other Revenue</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $netIncome ?? "Not Found" }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Annual) Card Example -->
        <div class="col-lg-4 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Expense</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $expense ?? "Not Found" }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Annual) Card Example -->
        <div class="col-lg-4 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Revenue</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $revenue ?? "Not Found" }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-4 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Due Payments</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUnpaid ?? "Not Found" }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                
                <div class="row">
                    <div class="col-6 m-0 pt-2">Account </div>
                    <div class="col-6 text-right"> 
                        <a class="btn btn-danger btn-sm" wire:click.prevent="downloadPDF">
                            <i class="fa-solid fa-file-pdf"></i> Download as PDF</a>
                        {{-- @if ( $total != null )
                            Total this month - {{ $total }} Tk
                        @endif 
                        @if ( $totalUnpaid != null )
                            and Total due - {{ $totalUnpaid }} Tk
                        @endif --}}
                    </div>
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
                    <label><b>Month</b></label>
                    <input type="text" id="month" class="form-control" wire:model.debounce.500ms="month" placeholder="Enter Month">
                </div>
                <div class="col-md">
                    <label><b>Search</b></label>
                    <input type="text" id="search" class="form-control" wire:model.debounce.1000ms="q" placeholder="Search by Student Name">
                </div>
            </div>

            <div class="table-responsive">
                <form id="updateForm" method="POST" action="{{ route("account.change") }}">
                    @csrf
                    @method("PATCH")
                    @if ( isset($month) )
                        <table class="table table-hover table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Course Name</th>
                                    <th>Name</th>
                                    <th>Email/Description</th>
                                    <th>Amount</th>
                                    <th>Last Updated</th>
                                    <th>Is Paid</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Course Name</th>
                                    <th>Name</th>
                                    <th>Email/Description</th>
                                    <th>Amount</th>
                                    <th>Last Updated</th>
                                    <th>Is Paid</th>
                                    <th>Delete</th>
                                </tr>
                            </tfoot>
                            <tbody> 
                                @forelse ($accounts as $account)
                                    <tr>
                                        <td>{!! $account->course ? "<a href='".route("course.feeds.index",["course"=>$account->course->id])."'>{$account->course->name}</a>"   : "Not from course" !!}</td>
                                        <td>{{ $account->user_name ? "ID: " . $account->user_id . " " . $account->user_name . " (Student)" : $account->name }}</td>
                                        <td>{{ $account->user_email ? $account->user_email : $account->description }}</td>
                                        <td>{{ $account->paid_amount ?? "Not Found" }}</td>
                                        <td>{{ $account->updated_at ? \Carbon\Carbon::parse()->format("d-M-Y g:i a") : "Not Found" }}</td>
                                        <td>
                                            @if ( $account->status == "Paid" || $account->status == "Revenue" )
                                                <span class="badge badge-success">{{ $account->status }}</span>
                                            @elseif( $account->status == "Expense" )
                                                <span class="badge badge-info">{{ $account->status }}</span>
                                            @else
                                                <span class="badge badge-danger">{{ $account->status }}</span>
                                            @endif                                            
                                        </td>
                                        <td>
                                            @if ( $account->user )
                                                <a href="{{ route("accounts.index") }}" class="text-dark">Delete from batch accounts</a> 
                                            @else 
                                                {{-- <button type="button" class="btn btn-primary" data-toggle="modal">View/Edit</button> --}}
                                                <button type="button" wire:click="updateId({{ $account->id }})" class="btn btn-primary mt-2" data-toggle="modal" data-target="#updateModal">View/Update</button>
                                                <button type="button" wire:click="deleteId({{ $account->id }})" class="btn btn-danger mt-2" data-toggle="modal" data-target="#exampleModal">Delete</button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <b>No Account Record Found</b>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <input type="hidden" name="course" value="{{ $batch ?? 0 }}">
                        <input type="hidden" name="reauth" value="0" id="reauth">

                        {{-- <input type="submit" class="btn btn-primary" value="Update"> --}}

                        <!-- Update trigger modal -->
                        {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateModal">
                            Update
                        </button> --}}
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

    <!-- Create Modal -->
    <div wire:ignore.self class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form wire:submit.prevent="createAccount">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Add to Accounts</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ( $errors->any() )
                        <span class="text-danger">Please fillup all the data correctly</span><br>
                    @endif
                    <label><b>Account For</b></label>
                    <input wire:model.lazy="account.name" type="text" class="form-control" placeholder="i.e House Rent" required>

                    <label class="mt-3"><b>Some Description</b></label>
                    <textarea wire:model.lazy="account.description" name="" id="" cols="30" rows="2" class="form-control"></textarea>

                    <label class="mt-3"><b>It's a</b></label>
                    <select wire:model.lazy="account.status" name="" class="form-control">
                        <option value="Revenue">Revenue</option>
                        <option value="Expense">Expense</option>
                    </select>
                    
                    <label class="mt-3"><b>Amount</b></label>
                    <input wire:model.lazy="account.paid_amount" type="number" min="0" class="form-control" required>

                    <label class="mt-3"><b>Month</b></label>
                    <input wire:model.lazy="account.month" type="text" id="createMonth" class="form-control" placeholder="Account For Month">

                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Create">
                </div>
            </form>
        </div>
        </div>
    </div>


    <!-- Update Modal -->
    <div wire:ignore.self class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form wire:submit.prevent="updateAccount">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ( $errors->any() )
                        <span class="text-danger">Please fillup all the data correctly</span><br>
                    @endif
                    <label><b>Account For</b></label>
                    <input wire:model.lazy="account.name" type="text" class="form-control" placeholder="i.e House Rent" required>

                    <label class="mt-3"><b>Some Description</b></label>
                    <textarea wire:model.lazy="account.description" name="" id="" cols="30" rows="2" class="form-control"></textarea>

                    <label class="mt-3"><b>It's a</b></label>
                    <select wire:model.lazy="account.status" name="" class="form-control">
                        <option value="Revenue">Revenue</option>
                        <option value="Expense">Expense</option>
                    </select>
                    
                    <label class="mt-3"><b>Amount</b></label>
                    <input wire:model.lazy="account.paid_amount" type="number" min="0" class="form-control" required>

                    <label class="mt-3"><b>Month</b></label>
                    <input wire:model.lazy="account.month" type="text" id="updateMonth" class="form-control" placeholder="Account For Month">

                </div>
                <div class="modal-footer">
                    <input wire:loading.disabled type="submit" class="btn btn-primary" value="Update">
                </div>
            </form>
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

        $('#createMonth').datepicker({
            format: "mm-yyyy",
            startView: "months", 
            minViewMode: "months",
            autoclose: true,
            todayHighlight: true
        });

        $('#updateMonth').datepicker({
            format: "mm-yyyy",
            startView: "months", 
            minViewMode: "months",
            autoclose: true,
            todayHighlight: true
        });

        $('#month').on('change', function (e) {
            @this.set('month', e.target.value);
        });

        $('#createMonth').on('change', function (e) {
            @this.set('account.month', e.target.value);
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

        window.addEventListener('accountCreated', event => {
            $('#createModal').modal('hide');
        });
        
        window.addEventListener('accountUpdate', event => {
            $('#updateModal').modal('hide');
        });

    </script>
@endpush
