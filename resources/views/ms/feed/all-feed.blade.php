@extends('layouts.cms')

@section('title')
    {{ $course->name }}
@endsection

@push("styles")
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">

        @if ( session('success') )
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if ( session('delete') )
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('delete') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if ( Auth::user()->role == "Admin" || $is_active == 1 )
            <div class="">
                @if ( auth()->user()->role == "Admin" )  

                    <div class="btn-group mb-4">
                        <button 
                        class="btn btn-primary dropdown-toggle" 
                        type="button" 
                        id="dropdownMenuButton" 
                        data-toggle="dropdown" 
                        aria-haspopup="true" 
                        aria-expanded="false">
                            Add To Feed
                        </button>

                        <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">

                            <a 
                            class="dropdown-item" 
                            href="{{ route("course.feeds.create",["course"=>$course->id]) }}">
                                Create Post
                            </a>

                            <a 
                            class="dropdown-item" 
                            href="{{ route("course.feeds.create-link",["course"=>$course->id]) }}">
                                Provide Resource/Link
                            </a>

                        </div>
                    </div>

                    <a 
                        class="btn btn-primary mb-4" 
                        href="{{ route("course.attendance.create",[ "course" => $course->id ]) }}">
                        Take Attendance
                    </a>

                    <a 
                        class="btn btn-primary mb-4" 
                        href="{{ route("course.accounts.create",[ "course" => $course->id ]) }}">
                        Payments
                    </a>

                    <a 
                        class="btn btn-primary mb-4" 
                        href="{{ route("course.authorize",[ "course" => $course->id ]) }}">
                        Authorization Panel
                    </a>

                    

                @endif

                    @if ( auth()->user()->role == "Admin" || $canSeeFriends)    
                        <a 
                            class="btn btn-primary mb-4" 
                            href="{{ route("course.students", [ "course"=>$course->id ]) }}">
                            See Students
                        </a>
                    @endif

                    <a 
                        class="btn btn-primary mb-4" 
                        href="{{ route("course.assessments.index",[ "course" => $course->id ]) }}">
                        Assessments
                    </a>
                    @if(auth()->user()->role == "Admin")
                        <div class="row">
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

                            <!-- Tasks Card Example -->
                            <div class="col-xl col-md-6 mb-4">
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
                    
                            <!-- Earnings (Annual) Card Example -->
                            <div class="col-xl col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Paid Payments</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $paid }}</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
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
                                                    Unpaid Payments</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $unpaid }}</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="far fa-clock fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif


                <div class="row ">
                    <div class="col-md-12">

                        <div class="card shadow mb-4 border-bottom-primary">
                            <!-- Card Header - Accordion -->
                            <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse"
                                role="button" aria-expanded="true" aria-controls="collapseCardExample">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-eye"></i>
                                    Overview <span class="small text-muted"> - click to expand</span>
                                </h6>
                            </a>
                            <!-- Card Content - Collapse -->
                            <div class="collapse" id="collapseCardExample">
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-xl-12 col-md-12 mb-4">
                                            <div class="card border-left-success shadow h-100 py-2">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                                Description
                                                            </div>
                                                            <div class="p mb-0 text-gray-800">{{ $course->description }}</div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <i class="fas fa-info fa-2x text-gray-300"></i>
                                                            {{-- <i class="fas fa-calendar "></i> --}}
                                                        </div>
                                                    </div>
                                                    @if ( $course->class_link )
                                                        <div class="row no-gutters align-items-center mt-3">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                                    Class Link
                                                                </div>
                                                                <div class="p mb-0 text-gray-800">{!! $course->class_link !!}</div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-info fa-2x text-gray-300"></i>
                                                                {{-- <i class="fas fa-calendar "></i> --}}
                                                            </div>
                                                        </div>
                                                    @endif 
                                                    <div class="row no-gutters align-items-center mt-3">
                                                        <div class="col mr-2">
                                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                                Address
                                                            </div>
                                                            <div class="p mb-0 text-gray-800">{{ $course->address }} <span class="small"> - <b>Room No:</b> {{ $course->room }} </span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
        
                                        <!-- Earnings (Annual) Card Example -->
                                        
        
                                        <div class="col-xl-6 col-md-6 mb-4">
                                            <div class="card border-left-success shadow h-100 py-2">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div class="text-xs text-success text-uppercase mb-1">
                                                                Subject
                                                            </div>
                                                            <div class="h5 mb-0 text-gray-800">{{ $course->subject }}</div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <i class="fas fa-book fa-2x text-gray-300"></i>
                                                            {{-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-xl-6 col-md-6 mb-4">
                                            <div class="card border-left-success shadow h-100 py-2">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div class="text-xs text-success text-uppercase mb-1">
                                                                Section
                                                            </div>
                                                            <div class="h5 mb-0 text-gray-800">{{ $course->section }} - <span class="small"><b>Time:</b> {{ $course->time }}</span></div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <i class="far fa-calendar-check fa-2x text-gray-300"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
        
                                    </div>
                                </div>
                            </div>
                        </div>

                        @livewire("feed.all-feed",["course"=>$course])

                    </div>
                    {{-- <div class="col-md-4">
                        <div class="card shadow border-bottom-primary mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fa fa-bullhorn rotate-n-15" aria-hidden="true"></i>
                                    Announcements
                                </h6>
                            </div>
                            <div class="card-body">
                
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>

        @else
            <div class="text-center">
                @if ( $accountStatus )
                    <h4 class="text-info mt-5">Your Payment Is Pending For Approval. Please Inform Your Tutor, <br> 
                        You Will Be Able To See The Course Materials After Approval.</h4>
                @endif
                @if ( $unpaid )
                    <h4 class="text-danger mt-5">You Have {{ $unpaid }} Due Payment Please Pay</h4>
                    <a href="{{ route("account.student.individual",['status'=>"Unpaid"]) }}" class="btn btn-block w-25 mx-auto btn-success mt-4">Pay Now</a>
                @endif
            </div>
        @endif
        
    </div>
</div>

    
@endsection


@push('scripts')

@endpush