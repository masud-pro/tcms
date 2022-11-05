<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Account
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
                    <select wire:model.debounce.500ms="batch" id="batch" class="form-control js-example-disabled-results">
                        <option value="">Select Batch / Course</option>
                        @foreach ($batches as $sbatch)
                            <option value="{{ $sbatch->id }}">{{ $sbatch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md">
                    <label><b>Students</b></label>
                    <select wire:model.debounce.500ms="student" id="student" class="form-control js-example-disabled-results">
                        <option value="">Select Student</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }} - {{ $student->email }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md">
                    <label><b>Date</b></label>
                    <input type="text" id="month" class="form-control" wire:model.debounce.500ms="month" placeholder="Enter Date">
                </div>
            </div>

            @if ( $showForm == true )
                <form wire:submit.prevent="add">
                    <label for="paid_amount">Amount</label>
                    <input value="{{ old("paid_amount") }}" wire:model.lazy="paid_amount" class="form-control" id="paid_amount" type="number">
                    @error('paid_amount')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <label for="status" class="mt-3">Status</label>
                    <select wire:model.lazy="status" id="status" class="form-control">
                        <option value="Unpaid">Unpaid</option>
                        <option value="Paid">Paid</option>
                    </select>
                    @error('status')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror

                    <input type="submit" class="btn btn-primary mt-3" value="Add Account">
                </form>
            @endif
            

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

        window.addEventListener('reInitJquery', event => {
            var $disabledResults = $(".js-example-disabled-results");
            $disabledResults.select2();
        })

        $('#batch').change(function(){
            var batch = $('#batch').val();
            @this.set('batch', this.value);
        });
        $('#student').change(function(){
            var student = $('#student').val();
            @this.set('student',student);
        });
    </script>
@endpush
