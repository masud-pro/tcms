<ul class="sticky navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url("/dashboard") }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-chalkboard-teacher"></i>
        </div>
        <div class="sidebar-brand-text mx-3">CE CMS</div>
    </a>

    @if ( Auth::user()->role == "Admin" || (Auth::user()->role == "Student" && Auth::user()->is_active == 1) )
        

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    

    @if (auth()->user()->role == "Admin")
        <li class="nav-item">

            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#batchCollapse"
                aria-expanded="true" aria-controls="batchCollapse">
                <i class="fas fa-tasks"></i>
                <span>Batches / Courses</span>
            </a>

            <div id="batchCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Batch Operations:</h6>
                    <a class="collapse-item" href="{{ route("course.index") }}">All Batches / Courses</a>
                    <a class="collapse-item" href="{{ route("course.create") }}">Add Batches / Courses</a>
                </div>
            </div>

        </li>
        <li class="nav-item">

            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#userCollapse"
                aria-expanded="true" aria-controls="userCollapse">
                <i class="fas fa-user-graduate"></i>
                <span>Students</span>
            </a>

            <div id="userCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Student Operations:</h6>
                    <a class="collapse-item" href="{{ route("user.index") }}">All Students</a>
                    <a class="collapse-item" href="{{ route("user.create") }}">Add Students</a>
                </div>
            </div>

        </li>

        <li class="nav-item">

            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#attendaceCollapse"
                aria-expanded="true" aria-controls="attendaceCollapse">
                <i class="far fa-clock"></i>
                <span>Attendances</span>
            </a>
    
            <div id="attendaceCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Attendance Operations:</h6>
                    <a class="collapse-item" href="{{ route("attendances.index") }}">All Attendances</a>
                    <a class="collapse-item" href="{{ route("attendance.student-attendance") }}">Student Attendance</a>
                </div>
            </div>
    
        </li>
    
        <li class="nav-item">
    
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#paymentsCollapse"
                aria-expanded="true" aria-controls="paymentsCollapse">
                <i class="fas fa-dollar-sign"></i>
                <span>Payments</span>
            </a>
    
            <div id="paymentsCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Payments Operations:</h6>
                    <a class="collapse-item" href="{{ route("accounts.index") }}">All Accounts</a>
                    <a class="collapse-item" href="{{ route("account.student-account") }}">Student Account</a>
                </div>
            </div>
    
        </li>

        <li class="nav-item">
    
            <a class="nav-link" href="{{ route("account.transactions") }}">
                <i class="fas fa-money-check-alt"></i>
                <span>Transactions</span>
            </a>
    
    
        </li>

        <li class="nav-item">

            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#smsCollapse"
                aria-expanded="true" aria-controls="smsCollapse">
                <i class="fas fa-sms"></i>
                <span>SMS Panel</span>
            </a>
    
            {{-- <div id="smsCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">SMS Operations:</h6>
                    <a class="collapse-item" href="{{ route("user.index") }}">All Students</a>
                    <a class="collapse-item" href="{{ route("user.create") }}">Add Students</a>
                </div>
            </div> --}}
    
        </li>

        <li class="nav-item">
    
            <a class="nav-link" href="{{ route("filemanager") }}">
                <i class="fas fa-folder-open"></i>
                <span>File Manager</span>
            </a>
    
    
        </li>

        <li class="nav-item">
    
            <a class="nav-link" href="#">
                <i class="fas fa-sliders-h"></i>
                <span>Settings</span>
            </a>
    
    
        </li>
    

    @else
        <li class="nav-item">

            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#batchCollapse"
                aria-expanded="true" aria-controls="batchCollapse">
                <i class="fas fa-tasks"></i>
                <span>Batches / Courses</span>
            </a>

            <div id="batchCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Batch Operations:</h6>
                    <a class="collapse-item" href="{{ route("my.courses") }}">My Batches / Courses</a>
                    <a class="collapse-item" href="{{ route("display.course") }}">All Batches / Courses</a>
                </div>
            </div>

        </li>

        <li class="nav-item">

            <a class="nav-link" href="{{ route("attendance.student.individual") }}">
                <i class="far fa-clock"></i>
                <span>Attendances</span>
            </a>
    
        </li>
    
        <li class="nav-item">
    
            <a class="nav-link" href="{{ route("account.student.individual") }}">
                <i class="fas fa-money-check-alt"></i>
                <span>Payments</span>
            </a>
    
        </li>
    @endif
 
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    @else
        <div class="sidebar-heading">
            Unauthorized
        </div>
    @endif

{{--

Doc 

1. Sidebar Divider :
    <hr class="sidebar-divider">
2. Sidebar Heading : 
    <div class="sidebar-heading">
        Interface
    </div>
3. Nav Items and Dropdown
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Components</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Components:</h6>
                <a class="collapse-item" href="buttons.html">Buttons</a>
                <a class="collapse-item" href="cards.html">Cards</a>
            </div>
        </div>
    </li>

--}}
    
    <!-- Divider -->
    {{-- <hr class="sidebar-divider d-none d-md-block"> --}}

    <!-- Sidebar Toggler (Sidebar) -->
    

</ul>