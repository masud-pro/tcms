@extends('layouts.cms')


@section('title')
    Dashboard
@endsection


@section('content')

    @if (Auth::user()->role == 'Admin' || (Auth::user()->role == 'Student' && Auth::user()->is_active == 1))

        <h1 class="h3 mb-4 text-primary">
            Welcome to {{ env('APP_NAME') }} @if ($emoji)
                😀
            @endif
        </h1>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session('full'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('full') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (Auth::user()->role == 'Student' && $pendingPayments > 0)
            <div class="text-center">
                <h2 class="text-danger mb-3">You Have {{ $pendingPayments }} Due Payment(s) </h2>
                <a href="{{ route('account.student.individual', ['status' => 'Unpaid']) }}" class="btn btn-primary">Pay
                    Now</a>
            </div>
        @endif

        @if (Auth::user()->role == 'Admin')

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
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
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
                                                <div class="progress-bar bg-info" role="progressbar"
                                                    style="width: {{ $attendancePercentage }}%" aria-valuenow="50"
                                                    aria-valuemin="0" aria-valuemax="100"></div>
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
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        In Active Users</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $inActiveUsers }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="far fa-clock fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


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
                                        <td>{!! $course->image
                                            ? "<a href='" . Storage::url($course->image) . "'><img width='100' src='" . Storage::url($course->image) . "' />"
                                            : '' !!}</td>
                                        <td>{{ $course->name ?? '' }}</td>
                                        <td>{{ $course->fee ?? '' }}</td>
                                        <td>{{ $course->type ?? '' }}</td>
                                        <td>{{ $course->time ?? '' }}</td>
                                        <td>{{ $course->subject ?? '' }}</td>
                                        <td>{{ $course->capacity ?? '' }}</td>
                                        <td>{{ $course->user ? $course->user->count() : 0 }}</td>
                                        <td><a class="btn btn-primary"
                                                href="{{ route('course.feeds.index', ['course' => $course->id]) }}">Feed</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        @else
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h5 mb-0 text-gray-800">Overview</h1>
            </div>
            <!-- Cards -->
            <div class="row">

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Course Enrolled</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $courses->count() }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Annual) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Missed Attendance</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $missedAttendance }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="far fa-clock fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tasks Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
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
                                                <div class="progress-bar bg-info" role="progressbar"
                                                    style="width: {{ $attendancePercentage }}%" aria-valuenow="50"
                                                    aria-valuemin="0" aria-valuemax="100"></div>
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

                <!-- Pending Requests Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Pending Payments</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $pendingPayments ?? '' }}
                                        @if ($pendingPayments > 0)
                                            <a href="{{ route('account.student.individual', ['status' => 'Unpaid']) }}"
                                                class="h6 ml-2 font-weight-normal">Pay Now</a>
                                        @endif

                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="row">
                <div class="col-12">
                    <h5 class="mb-4 mt-3">Enrolled Courses</h5>
                </div>
                @forelse ($courses as $course)
                    <div class="col-md-4">
                        <div class="card">

                            <img class="card-img-top" height="250px"
                                src="{{ $course->image ? Storage::url($course->image) : asset('images/default-banner.jpg') }}"
                                alt="Card image cap">

                            <div class="card-body">

                                <h5 class="card-title text-dark">
                                    <a class="text-dark"
                                        href="{{ route('course.feeds.index', ['course' => $course->id]) }}">
                                        {{ $course->name }}
                                    </a>
                                </h5>
                                <p class="card-text">
                                    {{ Illuminate\Support\Str::words($course->description, 10) }}
                                    @if (Illuminate\Support\Str::wordCount($course->description) > 10)
                                        <a data-toggle="collapse" href="#collapseExample{{ $course->id }}"
                                            role="button" aria-expanded="false" aria-controls="collapseExample">Read
                                            More</a>
                                    @endif
                                </p>
                                <div class="collapse" id="collapseExample{{ $course->id }}">
                                    <div class="card card-body">
                                        {{ $course->description }}
                                    </div>
                                </div>

                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Time: <span
                                        class="text-primary font-weight-bold">{{ $course->time }}</span></li>
                                <li class="list-group-item">Status: <span
                                        class="text-primary font-weight-bold">{{ $course->pivot->is_active == 0 ? 'Not Active' : 'Active' }}</span>
                                </li>
                                <li class="list-group-item">Fee: <span
                                        class="text-primary font-weight-bold">{{ $course->fee }}</span></li>
                            </ul>
                            <div class="card-body">
                                {{-- <a href="#" class="card-link float-left">Enroll</a> --}}
                                <a href="{{ route('course.feeds.index', ['course' => $course->id]) }}"
                                    class="card-link btn btn-success font-weight-bold btn-block">Go To Feed</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center mx-auto">
                        <h5>No Course Found</h5>
                        <a class="btn btn-primary mt-4 btn-block" href="{{ route('courses.all') }}">Enroll Now</a>
                    </div>
                @endforelse
            </div>
        @endif
    @else
        <div class="container text-center">
            <h2 class="text-primary mt-3">
                Hello and Welcome to {{ env('APP_NAME') }}
            </h2>
            <h5 class="text-dark mt-4">
                Your registration to {{ env('APP_NAME') }} is successful. We will review and approve your account very
                soon. Add all your <b>profile information</b> and add a <b>profile picture</b> to get authorized soon.
                We will notify you via email when your account status is changed.
            </h5>
            <a href="{{ route('profile.show') }}" class="btn btn-primary text-center mt-3">Update Profile</a>
            <p class="lead mt-3 text-info">To update profile picture just simply upload the profile picture and click on
                save.</p>
        </div>

    @endif
@endsection

@push('styles')
    <link href="{{ asset('assets') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style>
        #dataTable_info {
            display: none;
        }
    </style>
@endpush

@push('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('assets') }}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "bPaginate": false
            });
        });
    </script>
@endpush
