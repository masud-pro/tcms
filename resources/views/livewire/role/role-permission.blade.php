<div>


    @if (session()->has('created'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('created') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('updated'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ session('updated') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card-body">
        <div class="form-row mb-4">
            <div class="col-md-4" wire:ignore>
                <label>User Role</label>
                <select wire:model.debounce.500ms="selectedRole" id="role"
                    class="form-control js-example-disabled-results">
                    <option value="">Select Role</option>
                    @foreach ($allRoles as $roleData)
                        <option {{ $selectedRole == $roleData->id ? 'selected' : '' }} value="{{ $roleData->id }}">
                            {{ $roleData->name }}</option>
                    @endforeach
                </select>
            </div>

        </div>



        {{-- Pages permission --}}
        @if ($selectedRole)
            <form wire:submit.prevent="submit" action="#" method="POST">


                {{-- start --}}

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-check mt-3 mb-3">
                            <input class="form-check-input" id="selectAll" wire:model="checkedAll" type="checkbox"
                                value="checked" {{ $allChecked == count($allPermissions) ? 'checked' : '' }}>
                            <label class="form-check-label pr-4" for="selectAll">Select All
                                Check</label>
                            <button wire:click.prevent="clearSelected" style="width: 75px;"
                                class="btn btn-sm btn-primary">Clear</button>
                        </div>
                    </div>

                    {{-- Course Portion --}}

                    <div class="col-md-6">
                        <div class="card">

                            <div class="card-body">
                                <h5 class="card-title"><u>Course</u> </h5>

                                {{-- courses.index --}}
                                <div class="form-check">
                                    <input class="form-check-input checkbox" type="checkbox" value="courses.index"
                                        wire:model="selectedPermissions"
                                        {{ in_array('courses.index', $allPermissions) ? 'checked' : '' }}
                                        id="coursesIndex">
                                    <label class="form-check-label" for="coursesIndex">Course List</label>
                                </div>

                                {{-- courses.create --}}
                                <div class="form-check">
                                    <input class="form-check-input checkbox" type="checkbox" value="courses.create"
                                        wire:model="selectedPermissions"
                                        {{ in_array('courses.create', $allPermissions) ? 'checked' : '' }}
                                        id="coursesCreate">
                                    <label class="form-check-label" for="coursesCreate">Course Create</label>
                                </div>

                                {{-- courses.authorization_panel --}}
                                <div class="form-check">
                                    <input class="form-check-input checkbox" type="checkbox" value="courses.edit"
                                        wire:model="selectedPermissions"
                                        {{ in_array('courses.edit', $allPermissions) ? 'checked' : '' }}
                                        id="coursesEdit">
                                    <label class="form-check-label" for="coursesEdit">Courses Edit</label>
                                </div>

                                {{-- courses.authorization_panel --}}
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="courses.destroy"
                                        wire:model="selectedPermissions"
                                        {{ in_array('courses.delete', $allPermissions) ? 'checked' : '' }}
                                        id="coursesDelete">
                                    <label class="form-check-label" for="coursesDelete">Courses Delete</label>
                                </div>

                                {{-- courses.authorization_panel --}}
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="courses.archived"
                                        wire:model="selectedPermissions"
                                        {{ in_array('courses.archived', $allPermissions) ? 'checked' : '' }}
                                        id="coursesArchived">
                                    <label class="form-check-label" for="coursesArchived">Courses
                                        Archived</label>
                                </div>

                                {{-- courses.authorization_panel --}}
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="courses.authorization_panel"
                                        wire:model="selectedPermissions"
                                        {{ in_array('courses.authorization_panel', $allPermissions) ? 'checked' : '' }}
                                        id="coursesAuthorization_panel">
                                    <label class="form-check-label" for="coursesAuthorization_panel">Courses
                                        Authorization
                                        Panel</label>
                                </div>

                                {{-- courses.authorization_panel --}}
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="courses.authorize_users"
                                        wire:model="selectedPermissions"
                                        {{ in_array('courses.authorize_users', $allPermissions) ? 'checked' : '' }}
                                        id="coursesAuthorize_users">
                                    <label class="form-check-label" for="coursesAuthorize_users">Courses Authorize
                                        Student</label>
                                </div>

                            </div>

                        </div>
                    </div>

                    {{-- Feed Portion --}}

                    <div class="col-md-6">
                        <div class="card">

                            <div class="card-body">
                                <h5 class="card-title"><u>Feed</u> </h5>

                                {{-- feed.index --}}
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="feed.index"
                                        wire:model="selectedPermissions"
                                        {{ in_array('feed.index', $allPermissions) ? 'checked' : '' }} id="feedIndex">
                                    <label class="form-check-label" for="feedIndex">Feed List</label>
                                </div>

                                {{-- feed.create --}}
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="feed.create"
                                        wire:model="selectedPermissions"
                                        {{ in_array('feed.create', $allPermissions) ? 'checked' : '' }}
                                        id="feedCreate">
                                    <label class="form-check-label" for="feedCreate">Feed Create</label>
                                </div>

                                {{-- feed.edit --}}
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="feed.edit"
                                        wire:model="selectedPermissions"
                                        {{ in_array('feed.edit', $allPermissions) ? 'checked' : '' }} id="feedEdit">
                                    <label class="form-check-label" for="feedEdit">Feed Edit</label>
                                </div>



                                {{-- feed.destroy --}}
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="feed.destroy"
                                        wire:model="selectedPermissions"
                                        {{ in_array('feed.destroy', $allPermissions) ? 'checked' : '' }}
                                        id="feedDestroy">
                                    <label class="form-check-label" for="feedDestroy">Feed Delete</label>
                                </div>


                                {{-- feed.create_link --}}
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="feed.create_link"
                                        wire:model="selectedPermissions"
                                        {{ in_array('feed.create_link', $allPermissions) ? 'checked' : '' }}
                                        id="feedCreate_link">
                                    <label class="form-check-label" for="feedCreate_link">Feed Create Link</label>
                                </div>

                                {{-- feed.edit_link --}}
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="feed.edit_link"
                                        wire:model="selectedPermissions"
                                        {{ in_array('feed.edit_link', $allPermissions) ? 'checked' : '' }}
                                        id="feedEdit_link">
                                    <label class="form-check-label" for="feedEdit_link">Feed Edit Link</label>
                                </div>

                            </div>

                        </div>
                    </div>


                    {{-- Student Portion --}}
                    <div class="col-md-6 mt-4">
                        <div class="card">

                            <div class="card-body">
                                <h5 class="card-title"><u>Student</u> </h5>

                                {{-- student.index --}}
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="student.index"
                                        wire:model="selectedPermissions"
                                        {{ in_array('student.index', $allPermissions) ? 'checked' : '' }}
                                        id="studentIndex">
                                    <label class="form-check-label" for="studentIndex">Student List</label>
                                </div>

                                {{-- student.create --}}
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="student.create"
                                        wire:model="selectedPermissions"
                                        {{ in_array('student.create', $allPermissions) ? 'checked' : '' }}
                                        id="studentCreate">
                                    <label class="form-check-label" for="studentCreate">Student Create</label>
                                </div>



                                {{-- student.edit --}}
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="student.edit"
                                        wire:model="selectedPermissions"
                                        {{ in_array('student.edit', $allPermissions) ? 'checked' : '' }}
                                        id="studentEdit">
                                    <label class="form-check-label" for="studentEdit">Student Edit</label>
                                </div>


                                {{-- student.destroy --}}
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="student.destroy"
                                        wire:model="selectedPermissions"
                                        {{ in_array('student.destroy', $allPermissions) ? 'checked' : '' }}
                                        id="studentDestroy">
                                    <label class="form-check-label" for="studentDestroy">Student Delete</label>
                                </div>

                            </div>

                        </div>
                    </div>


                    {{-- Exam Question Portion --}}
                    <div class="col-md-6 mt-4">
                        <div class="card">

                            <div class="card-body">
                                <h5 class="card-title"><u>Exam Questions</u> </h5>

                                {{-- exam_question.index --}}
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="exam_question.index"
                                        wire:model="selectedPermissions"
                                        {{ in_array('exam_question.index', $allPermissions) ? 'checked' : '' }}
                                        id="exam_questionIndex">
                                    <label class="form-check-label" for="exam_questionIndex">Exam Question
                                        List</label>
                                </div>

                                {{-- exam_question.create --}}
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="exam_question.create"
                                        wire:model="selectedPermissions"
                                        {{ in_array('exam_question.create', $allPermissions) ? 'checked' : '' }}
                                        id="exam_questionCreate">
                                    <label class="form-check-label" for="exam_questionCreate">Exam Question
                                        Create</label>
                                </div>

                                {{-- exam_question.edit --}}
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="exam_question.edit"
                                        wire:model="selectedPermissions"
                                        {{ in_array('exam_question.edit', $allPermissions) ? 'checked' : '' }}
                                        id="exam_questionEdit">
                                    <label class="form-check-label" for="exam_questionEdit">Exam Question Edit</label>
                                </div>

                                {{-- exam_question.destroy --}}
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="exam_question.destroy"
                                        wire:model="selectedPermissions"
                                        {{ in_array('exam_question.destroy', $allPermissions) ? 'checked' : '' }}
                                        id="studentDestroy">
                                    <label class="form-check-label" for="studentDestroy">Exam Question Delete</label>
                                </div>

                                {{-- exam_question.assigned_course --}}
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        value="exam_question.assigned_course" wire:model="selectedPermissions"
                                        {{ in_array('exam_question.assigned_course', $allPermissions) ? 'checked' : '' }}
                                        id="exam_questionAssigned_course">
                                    <label class="form-check-label" for="exam_questionAssigned_course">Exam Question
                                        Assigned Course</label>
                                </div>

                            </div>

                        </div>
                    </div>


                    {{-- Accounts Portion --}}
                    <div class="col-md-6 mt-4">
                        <div class="card">

                            <div class="card-body">
                                <h5 class="card-title"><u>Attendance Course Students</u> </h5>

                                {{-- attendance.course_students --}}
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        value="attendance.course_students" wire:model="selectedPermissions"
                                        {{ in_array('attendance.course_students', $allPermissions) ? 'checked' : '' }}
                                        id="attendanceCourse_students">
                                    <label class="form-check-label" for="attendanceCourse_students">Attendance Course
                                        Students</label>
                                </div>

                                {{-- attendance.individual_students --}}
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        value="attendance.individual_students" wire:model="selectedPermissions"
                                        {{ in_array('attendance.individual_students', $allPermissions) ? 'checked' : '' }}
                                        id="attendanceIndividual_students">
                                    <label class="form-check-label" for="attendanceIndividual_students">Attendance
                                        Individual Students</label>
                                </div>

                            </div>

                        </div>
                    </div>


                    {{-- Accounts Portion --}}
                    <div class="col-md-6 mt-4">
                        <div class="card">

                            <div class="card-body">
                                <h5 class="card-title"><u>Account</u> </h5>

                                {{-- accounts.update --}}
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="accounts.update"
                                        wire:model="selectedPermissions"
                                        {{ in_array('accounts.update', $allPermissions) ? 'checked' : '' }}
                                        id="accountsUpdate">
                                    <label class="form-check-label" for="accountsUpdate">Account Update
                                        Payment</label>
                                </div>

                                {{-- accounts.course_update --}}
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="accounts.course_update"
                                        wire:model="selectedPermissions"
                                        {{ in_array('accounts.course_update', $allPermissions) ? 'checked' : '' }}
                                        id="accountsCourse_update">
                                    <label class="form-check-label" for="accountsCourse_update">Batch Accounts</label>
                                </div>

                                {{-- accounts.overall_user_account --}}
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        value="accounts.overall_user_account" wire:model="selectedPermissions"
                                        {{ in_array('accounts.overall_user_account', $allPermissions) ? 'checked' : '' }}
                                        id="accountsOverall_user_account">
                                    <label class="form-check-label" for="accountsOverall_user_account">Overall
                                        Account</label>
                                </div>

                                {{-- accounts.individual_student --}}
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        value="accounts.individual_student" wire:model="selectedPermissions"
                                        {{ in_array('accounts.individual_student', $allPermissions) ? 'checked' : '' }}
                                        id="accountsOverall_user_account">
                                    <label class="form-check-label" for="accountsOverall_user_account">Student
                                        Accounts</label>
                                </div>

                            </div>

                        </div>
                    </div>



                    {{-- Transactions Portion --}}
                    <div class="col-md-6 mt-4">
                        <div class="card">

                            <div class="card-body">
                                <h5 class="card-title"><u>Transactions</u> </h5>

                                {{-- transactions.user_online_transactions --}}
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        value="transactions.user_online_transactions" wire:model="selectedPermissions"
                                        {{ in_array('transactions.user_online_transactions', $allPermissions) ? 'checked' : '' }}
                                        id="transactionsUser_online_transactions">
                                    <label class="form-check-label"
                                        for="transactionsUser_online_transactions">Transactions Online Report</label>
                                </div>

                            </div>

                        </div>
                    </div>


                    {{-- File Manager Portion --}}
                    <div class="col-md-6 mt-4">
                        <div class="card">

                            <div class="card-body">
                                <h5 class="card-title"><u>File Manager</u> </h5>

                                {{-- file_manager.individual_teacher --}}
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        value="file_manager.individual_teacher" wire:model="selectedPermissions"
                                        {{ in_array('file_manager.individual_teacher', $allPermissions) ? 'checked' : '' }}
                                        id="file_managerIndividual_teacher">
                                    <label class="form-check-label" for="file_managerIndividual_teacher">File Manager
                                        Individual Teacher</label>
                                </div>

                            </div>

                        </div>
                    </div>


                    {{-- Settings Portion --}}
                    <div class="col-md-6 mt-4">
                        <div class="card">

                            <div class="card-body">
                                <h5 class="card-title"><u>Settings</u> </h5>

                                {{-- settings.individual_teacher --}}
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        value="settings.individual_teacher" wire:model="selectedPermissions"
                                        {{ in_array('settings.individual_teacher', $allPermissions) ? 'checked' : '' }}
                                        id="file_managerIndividual_teacher">
                                    <label class="form-check-label" for="file_managerIndividual_teacher">Setting
                                        Individual Teacher</label>
                                </div>

                            </div>

                        </div>
                    </div>



                </div>


                {{-- end  --}}

                <div class="col-12">
                    <button type="submit" {{ $selectedRole == null ? 'disabled' : '' }}
                        class="pl-4 pr-4 btn btn-primary mt-4">Save</button>

                </div>
            </form>
        @endif

    </div>

</div>

@push('styles')
    @livewireStyles()
    <link href="{{ asset('assets') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush
@push('scripts')
    @livewireScripts()

    <script>
        $('#role').change(function() {
            var role = $('#role').val();
            @this.set('selectedRole', this.value);
        });
    </script>
@endpush
