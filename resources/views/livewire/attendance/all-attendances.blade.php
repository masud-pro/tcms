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
                @if( $batch ) - <a class="small" href="" wire:click.prevent="downloadPDF">Download as PDF</a> @endif
            </h6>
        </div>
        <div class="card-body">
            <div class="form-row mb-4">
                <div class="col-md" wire:ignore >
                    <label><b>Batch / Course</b></label>
                    {{-- <select wire:model.debounce.500ms="batch" class="form-control js-example-disabled-results"> --}}
                    <select wire:model.debounce.500ms="batch" id="batch" class="form-control js-example-disabled-results">
                        <option value="">Select Batch / Course</option>
                        @foreach ( $batches as $sbatch )
                            <option value="{{ $sbatch->id }}">{{ $sbatch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md">
                    <label><b>Date</b></label>
                    <input type="text" id="date" class="form-control" wire:model.debounce.500ms="date" placeholder="Enter Date">
                </div>
            </div>
            <div class="table-responsive">
                <form method="POST" action="{{ route("attendance.change") }}">
                    @csrf
                    @method("PATCH")
                    @if ( isset($batch) && isset($date) )
                        <table class="table table-hover table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Attendance</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Attendance</th>
                                    <th>Email</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($attendances as $attendance)
                                    <tr>
                                        <td>{{ $attendance->user ? $attendance->user->id : "Not Found" }}</td>
                                        <td>{{ $attendance->user ? $attendance->user->name : "Not Found" }}</td>
                                        <td>
                                            <input type="hidden" name="ids[]" value="{{ $attendance->id }}">
                                            <div class="custom-control custom-checkbox">
                                                <input {{ $attendance->attendance == 1 ? "checked" : "" }}  name="attendance[]" value="{{ $attendance->id }}" type="checkbox" class="custom-control-input" id="customCheck{{ $attendance->id }}">
                                                <label class="custom-control-label" for="customCheck{{ $attendance->id }}">Present</label>
                                            </div>
                                        </td>
                                        <td>{{ $attendance->user ? $attendance->user->email : "Not Found" }}</td>
                                    </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <b> No attendance found. Maybe the attendance has not been taken. <a href="{{ route("course.attendance.create",["course"=>$batch]) }}">Take today's attendance</a></b>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <input type="submit" class="btn btn-primary" value="Update">
                    @endif                    
                </form>
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
        $('#date').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
        });
        $('#date').on('change', function (e) {
            @this.set('date', e.target.value);
        });
        $('#batch').change(function(){
            var batch = $('#batch').val();
            @this.set('batch', this.value);
        });
    </script>
@endpush
