@extends("layouts.cms")


@section("title")
    Dashboard
@endsection


@section('content')
    
    @if ( Auth::user()->role == "Admin" || (Auth::user()->role == "Student" && Auth::user()->is_active == 1) )
        <h1 class="h3 mb-4 text-primary">Welcome to @if (auth()->user()->role == "Admin") Admin @else Student @endif Panel 😀</h1>
        @if ( session('success') )
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if ( session('full') )
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('full') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (Auth::user()->role == "Admin")

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h5 mb-0 text-gray-800">Overview</h1>
            </div>
            <div class="container-fluid">
                
            </div>
            <div class="row">

                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Received Payments</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($reveivedPayments, 2, '.', ',') }} Tk</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests Card Example -->
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Due Payments</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($duePayments, 2, '.', ',') }} Tk</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
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
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
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

                <!-- Tasks Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Attendance Percentage
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $attendancePercentage }}%</div>
                                        </div>
                                        <div class="col">
                                            <div class="progress progress-sm mr-2">
                                                <div class="progress-bar bg-info" role="progressbar"
                                                    style="width: {{ $attendancePercentage }}%" aria-valuenow="50" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
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


                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Total Missed Attendance</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $absentCount }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="far fa-clock fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <h5 class="mb-4 mt-3">All Courses</h5>
                </div>
                @forelse ($courses as $course)
                        <div class="col-md-4 mt-3">
                            <div class="card">

                                <img class="card-img-top" height="250px" src="{{ $course->image ? Storage::url($course->image) : asset("images/default-banner.jpg") }}" alt="Card image cap">

                                <div class="card-body">

                                    <h5 class="card-title text-dark">
                                        <a class="text-dark" href="{{ route("course.feeds.index",['course'=>$course->id]) }}">
                                            {{ $course->name }}
                                        </a>
                                    </h5>
                                    <p class="card-text">
                                        {{ Illuminate\Support\Str::words( $course->description ,10) }}
                                        @if (Illuminate\Support\Str::wordCount( $course->description) > 10)   
                                            <a data-toggle="collapse" href="#collapseExample{{ $course->id }}" role="button" aria-expanded="false" aria-controls="collapseExample">Read More</a>
                                        @endif
                                    </p>
                                    <div class="collapse" id="collapseExample{{ $course->id }}">
                                        <div class="card card-body">
                                            {{ $course->description }}
                                        </div>
                                    </div>

                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Students: <span class="text-primary font-weight-bold">{{ $course->user ? $course->user->count() : "" }}</span></li>
                                    <li class="list-group-item">Time: <span class="text-primary font-weight-bold">{{ $course->time }}</span></li>
                                    <li class="list-group-item">Fee: <span class="text-primary font-weight-bold">{{ $course->fee }}</span></li>
                                </ul>
                                <div class="card-body">
                                    {{-- <a href="#" class="card-link float-left">Enroll</a> --}}
                                    <a href="{{ route("course.feeds.index",['course'=>$course->id]) }}" class="card-link btn btn-success font-weight-bold btn-block">Go To Feed</a>
                                </div>
                            </div> 
                        </div>
                    @empty
                        No Course Found
                    @endforelse
                
                
            </div>
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
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Attendance Percentage
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $attendancePercentage }}%</div>
                                        </div>
                                        <div class="col">
                                            <div class="progress progress-sm mr-2">
                                                <div class="progress-bar bg-info" role="progressbar"
                                                    style="width: {{ $attendancePercentage }}%" aria-valuenow="50" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
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
                                        {{ $pendingPayments ?? "" }} 
                                        @if ( $pendingPayments > 0 )
                                            <a href="{{ route("account.student.individual",["status"=>"Unpaid"]) }}" class="h6 ml-2 font-weight-normal">Pay Now</a>
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

                                <img class="card-img-top" height="250px" src="{{ $course->image ? Storage::url($course->image) : asset("images/default-banner.jpg") }}" alt="Card image cap">

                                <div class="card-body">

                                    <h5 class="card-title text-dark">
                                        <a class="text-dark" href="{{ route("course.feeds.index",['course'=>$course->id]) }}">
                                            {{ $course->name }}
                                        </a>
                                    </h5>
                                    <p class="card-text">
                                        {{ Illuminate\Support\Str::words( $course->description ,10) }}
                                        @if (Illuminate\Support\Str::wordCount( $course->description) > 10)   
                                            <a data-toggle="collapse" href="#collapseExample{{ $course->id }}" role="button" aria-expanded="false" aria-controls="collapseExample">Read More</a>
                                        @endif
                                    </p>
                                    <div class="collapse" id="collapseExample{{ $course->id }}">
                                        <div class="card card-body">
                                            {{ $course->description }}
                                        </div>
                                    </div>

                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Time: <span class="text-primary font-weight-bold">{{ $course->time }}</span></li>
                                    <li class="list-group-item">Status: <span class="text-primary font-weight-bold">{{ $course->pivot->is_active == 0 ? "Not Active" : "Active" }}</span></li>
                                    <li class="list-group-item">Fee: <span class="text-primary font-weight-bold">{{ $course->fee }}</span></li>
                                </ul>
                                <div class="card-body">
                                    {{-- <a href="#" class="card-link float-left">Enroll</a> --}}
                                    <a href="{{ route("course.feeds.index",['course'=>$course->id]) }}" class="card-link btn btn-success font-weight-bold btn-block">Go To Feed</a>
                                </div>
                            </div> 
                        </div>
                    @empty
                        <div class="text-center mx-auto">
                            <h5>No Course Found</h5> 
                            <a class="btn btn-primary mt-4 btn-block" href="{{ route("display.course") }}">Enroll Now</a>
                        </div>
                    @endforelse
            </div>
        @endif

    
    @else

    <h4 class="text-danger text-center mt-5">Your Current Status is Unauthorized. Please Contact Your Tutor For More Information</h4>
        
    @endif
@endsection



