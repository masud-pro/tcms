<ul class="sticky navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/dashboard') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-chalkboard-teacher"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ env('DASH_TITLE', 'CE CMS') }}</div>
    </a>

    @if (Auth::user()->is_active == 1 || Auth::user()->hasRole(['Super Admin']))
        {{-- @if (Auth::user()->hasRole(['Teacher', 'Super Admin']) || (Auth::user()->hasRole(['Student']) && Auth::user()->is_active == 1)) --}}


        <!-- Divider -->
        <hr class="sidebar-divider dropdown-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }} ">
            <a class="nav-link" href="/dashboard">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider dropdown-divider">

        @role('Super Admin')
            <li class="nav-item {{ request()->is('administrator.*') ? 'active' : '' }}">

                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#administrator"
                    aria-expanded="true" aria-controls="administrator">
                    <i class="fas fa-users-cog"></i>
                    <span>Administrator</span>
                </a>

                <div id="administrator" class="collapse {{ request()->routeIs('administrator.*') ? 'show' : '' }}"
                    aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">User Operations:</h6>
                        <a class="collapse-item {{ request()->is('administrator') ? 'active' : '' }}"
                            href="{{ route('administrator.index') }}">All User</a>
                        {{-- <a class="collapse-item" href="#">Role Permission</a> --}}
                    </div>
                </div>

            </li>

            <li class="nav-item {{ request()->is('role') ? 'active' : '' }}">

                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#roleManagement"
                    aria-expanded="true" aria-controls="roleManagement">
                    <i class="fas fa-users-cog"></i>
                    <span>Role Management</span>
                </a>

                <div id="roleManagement" class="collapse {{ request()->routeIs('role.*') ? 'show' : '' }}"
                    aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Role Management:</h6>
                        <a class="collapse-item {{ request()->is('role') ? 'active' : '' }}"
                            href="{{ route('role.index') }}">User Roles</a>
                        <a class="collapse-item {{ request()->is('role.permission') ? 'active' : '' }}"
                            href="{{ route('role.permission') }}">Role Permission</a>
                    </div>
                </div>

            </li>

            {{-- <hr class="sidebar-divider dropdown-divider"> --}}

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ request()->routeIs('subscription.*') ? 'active' : '' }} ">
                <a class="nav-link" href="{{ route('subscription.index') }}">
                    <i class="fas fa-sack-dollar"></i>
                    <span>Subscription</span></a>
            </li>


            <li class="nav-item">

                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#subscriberManagement"
                    aria-expanded="true" aria-controls="subscriberManagement">
                    <i class="fa-solid fa-robot"></i>
                    <span>Subscribers</span>
                </a>

                <div id="subscriberManagement" class="collapse" aria-labelledby="headingTwo"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Subscriber Management:</h6>
                        <a class="collapse-item" href="{{ route('subscriber.index') }}">Subscriber List</a>
                        <a class="collapse-item" href="{{ route('subscriber.transaction') }}">Subscriber Transactions</a>
                    </div>
                </div>

            </li>
            <hr class="sidebar-divider dropdown-divider">
        @endrole





        @if (auth()->user()->hasRole(['Teacher', 'Super Admin']))
            {{-- @if (auth()->user()->can(['courses.index', 'courses.archived'])) --}}

            @if (hasCourseAccess())
                <li class="nav-item {{ request()->routeIs('course.*') ? 'active' : '' }} ">

                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#batchCollapse"
                        aria-expanded="true" aria-controls="batchCollapse">
                        <i class="fas fa-tasks"></i>
                        <span>Batches / Courses</span>
                    </a>

                    <div id="batchCollapse" class="collapse {{ request()->routeIs('course.*') ? 'show' : '' }}"
                        aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Batch Operations:</h6>
                            <a class="collapse-item {{ request()->is('course') ? 'active' : '' }}"
                                href="{{ route('course.index') }}">All Batches / Courses</a>
                            <a class="collapse-item {{ request()->is('course/create') ? 'active' : '' }}"
                                href="{{ route('course.create') }}">Add Batches / Courses</a>
                        </div>
                    </div>

                </li>
            @endif

            @if (hasStudentAccess())
                <li class="nav-item {{ request()->routeIs('user.*') ? 'active' : '' }}">

                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#userCollapse"
                        aria-expanded="true" aria-controls="userCollapse">
                        <i class="fas fa-user-graduate"></i>
                        <span>Students</span>
                    </a>

                    <div id="userCollapse" class="collapse {{ request()->routeIs('user.*') ? 'show' : '' }}"
                        aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Student Operations:</h6>
                            <a class="collapse-item {{ request()->is('user') ? 'active' : '' }}"
                                href="{{ route('user.index') }}">All Students</a>
                            <a class="collapse-item {{ request()->is('user/create') ? 'active' : '' }}"
                                href="{{ route('user.create') }}">Add Students</a>
                        </div>
                    </div>

                </li>
            @endif


            @if (hasExamQuestionAccess())
                <li class="nav-item {{ request()->routeIs('assignments.*') ? 'active' : '' }}">

                    <a class="nav-link collapsed" href="#" data-toggle="collapse"
                        data-target="#assessmentCollaple" aria-expanded="true" aria-controls="assessmentCollaple">
                        <i class="fas fa-pen"></i>
                        <span>Exam Questions</span>
                    </a>

                    <div id="assessmentCollaple"
                        class="collapse {{ request()->routeIs('assignments.*') ? 'show' : '' }}"
                        aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Assessment Operations:</h6>
                            <a class="collapse-item {{ request()->is('assignments') ? 'active' : '' }}"
                                href="{{ route('assignments.index') }}">All Questions</a>
                            <a class="collapse-item {{ request()->is('assignments/create') ? 'active' : '' }}"
                                href="{{ route('assignments.create') }}">Create Questions</a>
                        </div>
                    </div>

                </li>
            @endif


            @if (hasAttendanceAccess())
                <li class="nav-item {{ request()->is('attendance*') ? 'active' : '' }}">

                    <a class="nav-link collapsed" href="#" data-toggle="collapse"
                        data-target="#attendaceCollapse" aria-expanded="true" aria-controls="attendaceCollapse">
                        <i class="far fa-clock"></i>
                        <span>Attendances</span>
                    </a>

                    <div id="attendaceCollapse"
                        class="collapse {{ request()->routeIs('attendance*') ? 'show' : '' }}"
                        aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Attendance Operations:</h6>
                            <a class="collapse-item {{ request()->routeIs('attendances.index') ? 'active' : '' }}"
                                href="{{ route('attendances.index') }}">Batch Attendances</a>
                            <a class="collapse-item {{ request()->routeIs('attendance.student-attendance') ? 'active' : '' }}"
                                href="{{ route('attendance.student-attendance') }}">Student Attendance</a>
                        </div>
                    </div>

                </li>
            @endif

            @if (hasAccountAccess())
                <li class="nav-item {{ request()->routeIs('account*') ? 'active' : '' }}">

                    <a class="nav-link collapsed" href="#" data-toggle="collapse"
                        data-target="#paymentsCollapse" aria-expanded="true" aria-controls="paymentsCollapse">
                        <i class="fas fa-dollar-sign"></i>
                        <span>Accounts</span>
                    </a>

                    <div id="paymentsCollapse" class="collapse {{ request()->routeIs('account*') ? 'show' : '' }}"
                        aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Update Accounts:</h6>
                            <a class="collapse-item {{ request()->routeIs('account.all-batch-accounts') ? 'active' : '' }}"
                                href="{{ route('account.all-batch-accounts') }}">Update Payments</a>
                            <a class="collapse-item {{ request()->routeIs('accounts.index') ? 'active' : '' }}"
                                href="{{ route('accounts.index') }}">Batch Accounts</a>
                            <h6 class="collapse-header">Reports:</h6>
                            <a class="collapse-item {{ request()->routeIs('account.overall-account') ? 'active' : '' }}"
                                href="{{ route('account.overall-account') }}">Overall Accounts</a>
                            <a class="collapse-item {{ request()->routeIs('account.student-account') ? 'active' : '' }}"
                                href="{{ route('account.student-account') }}">Student Account</a>
                            {{-- <h6 class="collapse-header">Add Accounts:</h6>
        <a class="collapse-item {{ request()->routeIs('account.manual.create') ? 'active' : '' }}" href="{{ route("account.manual.create") }}">Add Student Account</a> --}}
                        </div>
                    </div>

                </li>
            @endif



            @if (hasTransactionsAccess())
                <li class="nav-item {{ request()->routeIs('transactions') ? 'active' : '' }}">

                    <a class="nav-link" href="{{ route('transactions') }}">
                        <i class="fas fa-money-check-alt"></i>
                        <span>Transactions</span>
                    </a>

                </li>
            @endif

            @if (hasMassageAccess())
                <li class="nav-item {{ request()->routeIs('sms*') ? 'active' : '' }}">

                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#smsCollapse"
                        aria-expanded="true" aria-controls="smsCollapse">
                        <i class="fas fa-sms"></i>
                        <span>SMS Panel</span>
                    </a>

                    <div id="smsCollapse" class="collapse {{ request()->routeIs('sms*') ? 'show' : '' }}"
                        aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">SMS Operations:</h6>
                            <a class="collapse-item {{ request()->routeIs('sms.index') ? 'active' : '' }}"
                                href="{{ route('sms.index') }}">SMS Dashboard</a>
                            <a class="collapse-item {{ request()->routeIs('sms.batch') ? 'active' : '' }}"
                                href="{{ route('sms.batch') }}">Send Batch SMS</a>
                        </div>
                    </div>

                </li>
            @endif

            @if (hasFileManagerAccess())
                <li class="nav-item {{ request()->routeIs('filemanager') ? 'active' : '' }}">

                    <a class="nav-link" href="{{ route('filemanager') }}">
                        <i class="fas fa-folder-open"></i>
                        <span>File Manager</span>
                    </a>


                </li>
            @endif

            @if (hasSettingAccess())
                <li class="nav-item {{ request()->routeIs('settings') ? 'active' : '' }}">

                    <a class="nav-link" href="{{ route('settings') }}">
                        <i class="fas fa-sliders-h"></i>
                        <span>Settings</span>
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('subscriber.subscription.renew') ? 'active' : '' }}">

                    <a class="nav-link" href="{{ route('subscriber.subscription.renew') }}">
                        <i class="fas fa-undo"></i>
                        <span>Renew</span>
                    </a>


                </li>
            @else
                <li class="nav-item {{ request()->routeIs('settings') ? 'active' : '' }}">

                    <a class="nav-link" href="{{ route('settings') }}">
                        <i class="fas fa-sliders-h"></i>
                        <span>Settings</span>
                    </a>


                </li>
            @endif
        @else
            <li class="nav-item {{ request()->routeIs('courses.*') ? 'active' : '' }}">

                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#batchCollapse"
                    aria-expanded="true" aria-controls="batchCollapse">
                    <i class="fas fa-tasks"></i>
                    <span>Batches / Courses</span>
                </a>

                <div id="batchCollapse" class="collapse {{ request()->routeIs('courses.*') ? 'show' : '' }}"
                    aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Batch Operations:</h6>
                        <a class="collapse-item {{ request()->routeIs('courses.individual.student') ? 'active' : '' }}"
                            href="{{ route('courses.individual.student') }}">My Batches / Courses</a>
                        <a class="collapse-item {{ request()->routeIs('courses.all') ? 'active' : '' }}"
                            href="{{ route('courses.all') }}">All Batches / Courses</a>
                    </div>
                </div>
            </li>

            <li class="nav-item {{ request()->routeIs('attendance.student.individual') ? 'active' : '' }}">

                <a class="nav-link" href="{{ route('attendance.student.individual') }}">
                    <i class="far fa-clock"></i>
                    <span>Attendances</span>
                </a>

            </li>

            <li class="nav-item {{ request()->routeIs('account.student.individual') ? 'active' : '' }}">

                <a class="nav-link" href="{{ route('account.student.individual') }}">
                    <i class="fas fa-money-check-alt"></i>
                    <span>Payments</span>
                </a>

            </li>

            <li class="nav-item {{ request()->routeIs('profile.show') ? 'active' : '' }}">

                <a class="nav-link" href="{{ route('profile.show') }}">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
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
    <hr class="sidebar-divider dropdown-divider">
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
    {{-- <hr class="sidebar-divider dropdown-divider d-none d-md-block"> --}}

    <!-- Sidebar Toggler (Sidebar) -->


</ul>
