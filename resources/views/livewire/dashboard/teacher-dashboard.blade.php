<div>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h5 mb-0 text-gray-800">Overview</h1>
    </div>
    <div class="container-fluid">

    </div>
    <div class="row">
        <div class="col-xl mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Net Income</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($total, 2, '.', ',') }} Tk</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Student Payments</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($reveivedPayments, 2, '.', ',') }} Tk</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Expense</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($expense, 2, '.', ',') }} Tk</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Revenue</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($revenue, 2, '.', ',') }} Tk</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Due Payments</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($duePayments, 2, '.', ',') }} Tk</div>
                        </div>
                        <div class="col-auto">

                            @if ($isHaveDuePayment == true)
                                <i class="fas fa-dollar-sign fa-2x blink"></i>
                            @else
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            @endif



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Batch/Courses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalCourses }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Annual) Card Example -->
        <div class="col-xl col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Students</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalStudents }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Annual) Card Example -->
        <div class="col-xl col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Enrolled Students</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $studentWithBatch }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tasks Card Example -->
        <div class="col-xl col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Attendance
                                Percentage
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                        {{ $attendancePercentage }}%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ $attendancePercentage }}%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl col-md-6 mb-4">
            <a class=" text-none" href="{{ route('course.index') }}" target="_blank" rel="In Active User">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    In Active Users</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $inActiveUsers }}</div>
                            </div>
                            <div class="col-auto">
                                @if ($isHaveInActiveUsers == true)
                                    <i class="far fa-clock fa-2x blink-warning"></i>
                                @else
                                    <i class="far fa-clock fa-2x text-gray-300"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>


        <div class="col-xl col-md-6 mb-4">
            <a class=" text-none" href="{{ $paddingUrl }}" target="_blank" rel="padding report">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Pending Payment</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $paddingPayments }}</div>
                            </div>
                            <div class="col-auto">
                                @if ($isHavePaddingPayment == true)
                                    <i class="fa-sharp fa-solid fa-circle-dollar-to-slot fa-2x blink"></i>
                                @else
                                    <i class="fa-sharp fa-solid fa-circle-dollar-to-slot fa-2x text-gray-300"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </a>

        </div>

    </div>

    @if (auth()->user()->hasRole(['Teacher']))
        @if ($courseView == 'grid')
            @livewire('dashboard.course-search')
        @elseif($courseView == 'table')
            <div class="row">
                <div class="col-12">
                    <h5 class="mb-4 mt-3">All Courses</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Fee</th>
                                <th>Type</th>
                                <th>Time</th>
                                <th>Subject</th>
                                <th>Capacity</th>
                                <th>Students</th>
                                <th>Feed</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Fee</th>
                                <th>Type</th>
                                <th>Time</th>
                                <th>Subject</th>
                                <th>Capacity</th>
                                <th>Students</th>
                                <th>Feed</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($courses as $course)
                                <tr>
                                    <td>{!! $course->image ? "<a href='" . Storage::url($course->image) . "'><img width='100' src='" . Storage::url($course->image) . "' />" : '' !!}</td>
                                    <td>{{ $course->name ?? '' }}</td>
                                    <td>{{ $course->fee ?? '' }}</td>
                                    <td>{{ $course->type ?? '' }}</td>
                                    <td>{{ $course->time ?? '' }}</td>
                                    <td>{{ $course->subject ?? '' }}</td>
                                    <td>{{ $course->capacity ?? '' }}</td>
                                    <td>{{ $course->user ? $course->user->count() : 0 }}</td>
                                    <td><a class="btn btn-primary" href="{{ route('course.feeds.index', ['course' => $course->id]) }}">Feed</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    @endif
</div>


@push('styles')
    @livewireStyles()
    <style>
        @-webkit-keyframes blinker {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }

        .blink {
            text-decoration: blink;
            -webkit-animation-name: blinker;
            -webkit-animation-duration: 0.6s;
            -webkit-animation-iteration-count: infinite;
            -webkit-animation-timing-function: ease-in-out;
            -webkit-animation-direction: alternate;
            color: #ff0000;
        }

        .blink-warning {
            text-decoration: blink;
            -webkit-animation-name: blinker;
            -webkit-animation-duration: 0.6s;
            -webkit-animation-iteration-count: infinite;
            -webkit-animation-timing-function: ease-in-out;
            -webkit-animation-direction: alternate;
            color: #f6c23e;
        }

        .text-none {
            text-decoration: none;
        }

        .text-none:hover {

            text-decoration: none;
        }
    </style>
@endpush
@push('scripts')
    @livewireScripts()
@endpush
