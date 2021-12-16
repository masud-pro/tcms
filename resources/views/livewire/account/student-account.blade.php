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
            <div class="form-row mb-4">
                <div class="col-md">
                    <label><b>Batch / Course</b></label>
                    <select wire:model.debounce.500ms="batch" class="form-control">
                        <option value="">Select Batch / Course</option>
                        @foreach ($batches as $sbatch)
                            <option value="{{ $sbatch->id }}">{{ $sbatch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md">
                    <label><b>Student</b></label>
                    <select wire:model.debounce.500ms="user" class="form-control">
                        <option value="0">Select Student</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }} - {{ $student->email }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- {{ $singleStudent }} --}}
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
                    
                <div class="text-right">
                    <a href="{{ route("dashboard") }}">Go Back</a>
                </div>
            </div>
        </div>
    </div>
</div>

