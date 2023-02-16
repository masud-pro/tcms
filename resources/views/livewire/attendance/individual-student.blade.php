<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Attendance
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
                    <label><b>Date</b></label>
                    <input type="text" id="month" class="form-control" wire:model.debounce.500ms="month" name="month" value="{{ old('month') }}" placeholder="Enter Date">
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
    </script>
@endpush
