<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
         <div class="row">
            <div class="col-6">
                <h6 class="m-0 pt-2 font-weight-bold text-primary">
                    Attendance Of Individual Student 
                    <div wire:loading>
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </h6>
            </div>
            <div class="col-6 text-right">
                @if( $student )
                    <a class=" btn btn-danger btn-sm" wire:click.prevent="downloadPDF">
                        <i class="fa-solid fa-file-pdf"></i> Download as PDF
                    </a> 
                @endif
            </div>

         </div>
        </div>
        <div class="card-body">
            <div class="form-row mb-4">
                <div class="col-md" wire:ignore >
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
                            <option value="{{ $student->id }}"> ID:{{ $student->id }} - {{ $student->name }} - {{ $student->email }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md">
                    <label><b>Date</b></label>
                    <input type="text" id="month" class="form-control" wire:model.debounce.500ms="month" placeholder="Enter Date">
                </div>
            </div>
            <div class="table-responsive">
                @if ( isset($student) && isset($month) )
                    <table class="table table-hover table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Course</th>
                                <th>Email</th>
                                <th>Date</th>
                                <th>Attendance</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Course</th>
                                <th>Email</th>
                                <th>Date</th>
                                <th>Attendance</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($attendances as $attendance)
                                <tr>
                                    <td>{{ $attendance->user ? $attendance->user->name : "Not Found" }}</td>
                                    <td>{{ $attendance->course ? $attendance->course->name : "Not Found" }}</td>
                                    <td>{{ $attendance->user ? $attendance->user->email : "Not Found" }}</td>
                                    <td>{{ $attendance->date ? \Carbon\Carbon::parse($attendance->date)->format("d-M-Y") : "Not Found" }}</td>
                                    <td>
                                        <input type="hidden" name="ids[]" value="{{ $attendance->id }}">
                                        <div class="custom-control custom-checkbox">
                                            <input onclick="return false;" {{ $attendance->attendance == 1 ? "checked" : "" }}  name="attendance[]" value="{{ $attendance->id }}" type="checkbox" class="custom-control-input" id="customCheck{{ $attendance->id }}">
                                            <label class="custom-control-label" for="customCheck{{ $attendance->id }}">Present</label>
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
