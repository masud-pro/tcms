<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Subscription</h6>
                </div>
                <div class="card-body">

                    <form wire:submit.prevent="submit">

                        <div class="row">
                            <div class="col-md-4">
                                <label for="name">Subscription Name</label>
                                <input class="form-control @error('name') is-invalid @enderror" id="name"
                                    wire:model="name" value="{{ old('name') }}" type="text">
                                @error('name')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>


                            <div class="col-md-4">
                                <label class="" for="price">Subscription Price</label>
                                <input class="form-control @error('price') is-invalid @enderror" id="price"
                                    min="1" wire:model="price" value="{{ old('price') }}" type="number">
                                @error('price')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="months">Subscription Month Duration</label>
                                <input class="form-control @error('months') is-invalid @enderror" id="months"
                                    min="1" wire:model="months" value="{{ old('months') }}" type="number">
                                @error('months')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- end  --}}
                        </div>

                        {{-- Feature --}}

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-check mt-3 mb-3">
                                    <input class="form-check-input" id="selectAll" wire:model="checkedAll"
                                        type="checkbox">
                                    <label class="form-check-label pr-4" for="selectAll">Select All
                                        Check</label>
                                </div>
                            </div>
                            @error('selectedFeature')
                                <p class="text-danger small mt-1">{{ $message }}</p>
                            @enderror

                            {{-- Course Portion --}}

                            <div class="col-md-6">
                                <div class="card">

                                    <div class="card-body">
                                        <h5 class="card-title"><u>Course</u> </h5>

                                        {{-- courses.index --}}
                                        <div class="form-check">
                                            <input class="form-check-input checkbox" type="checkbox"
                                                value="courses.index" wire:model="selectedFeature" id="coursesIndex"
                                                {{-- {{ in_array('courses.index', $selectedFeature) ? 'checked' : '' }}> --}} <label class="form-check-label"
                                                for="coursesIndex">Course List</label>
                                        </div>

                                        {{-- courses.create --}}
                                        <div class="form-check">
                                            <input class="form-check-input checkbox" type="checkbox"
                                                value="courses.create" wire:model="selectedFeature" id="coursesCreate">
                                            <label class="form-check-label" for="coursesCreate">Course
                                                Create</label>
                                        </div>

                                        {{-- courses.authorization_panel --}}
                                        <div class="form-check">
                                            <input class="form-check-input checkbox" type="checkbox"
                                                value="courses.edit" wire:model="selectedFeature" id="coursesEdit">
                                            <label class="form-check-label" for="coursesEdit">Courses Edit</label>
                                        </div>

                                        {{-- courses.authorization_panel --}}
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="courses.destroy"
                                                wire:model="selectedFeature" id="coursesDelete">
                                            <label class="form-check-label" for="coursesDelete">Courses
                                                Delete</label>
                                        </div>

                                        {{-- courses.authorization_panel --}}
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="courses.archived"
                                                wire:model="selectedFeature" id="coursesArchived">
                                            <label class="form-check-label" for="coursesArchived">Courses
                                                Archived</label>
                                        </div>

                                        {{-- courses.authorization_panel --}}
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                value="courses.authorization_panel" wire:model="selectedFeature"
                                                id="coursesAuthorization_panel">
                                            <label class="form-check-label" for="coursesAuthorization_panel">Courses
                                                Authorization
                                                Panel</label>
                                        </div>

                                        {{-- courses.authorization_panel --}}
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                value="courses.authorize_users" wire:model="selectedFeature"
                                                id="coursesAuthorize_users">
                                            <label class="form-check-label" for="coursesAuthorize_users">Courses
                                                Authorize
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
                                                wire:model="selectedFeature" id="feedIndex">
                                            <label class="form-check-label" for="feedIndex">Feed List</label>
                                        </div>

                                        {{-- feed.create --}}
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="feed.create"
                                                wire:model="selectedFeature" id="feedCreate">
                                            <label class="form-check-label" for="feedCreate">Feed Create</label>
                                        </div>

                                        {{-- feed.edit --}}
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="feed.edit"
                                                wire:model="selectedFeature" id="feedEdit">
                                            <label class="form-check-label" for="feedEdit">Feed Edit</label>
                                        </div>



                                        {{-- feed.destroy --}}
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="feed.destroy"
                                                wire:model="selectedFeature" id="feedDestroy">
                                            <label class="form-check-label" for="feedDestroy">Feed Delete</label>
                                        </div>


                                        {{-- feed.create_link --}}
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="feed.create_link"
                                                wire:model="selectedFeature" id="feedCreate_link">
                                            <label class="form-check-label" for="feedCreate_link">Feed Create
                                                Link</label>
                                        </div>

                                        {{-- feed.edit_link --}}
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="feed.edit_link"
                                                wire:model="selectedFeature" id="feedEdit_link">
                                            <label class="form-check-label" for="feedEdit_link">Feed Edit
                                                Link</label>
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
                                                wire:model="selectedFeature" id="studentIndex">
                                            <label class="form-check-label" for="studentIndex">Student
                                                List</label>
                                        </div>

                                        {{-- student.create --}}
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="student.create"
                                                wire:model="selectedFeature" id="studentCreate">
                                            <label class="form-check-label" for="studentCreate">Student
                                                Create</label>
                                        </div>



                                        {{-- student.edit --}}
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="student.edit"
                                                wire:model="selectedFeature" id="studentEdit">
                                            <label class="form-check-label" for="studentEdit">Student Edit</label>
                                        </div>


                                        {{-- student.destroy --}}
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="student.destroy"
                                                wire:model="selectedFeature" id="studentDestroy">
                                            <label class="form-check-label" for="studentDestroy">Student
                                                Delete</label>
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
                                            <input class="form-check-input" type="checkbox"
                                                value="exam_question.index" wire:model="selectedFeature"
                                                id="exam_questionIndex">
                                            <label class="form-check-label" for="exam_questionIndex">Exam Question
                                                List</label>
                                        </div>

                                        {{-- exam_question.create --}}
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                value="exam_question.create" wire:model="selectedFeature"
                                                id="exam_questionCreate">
                                            <label class="form-check-label" for="exam_questionCreate">Exam
                                                Question
                                                Create</label>
                                        </div>

                                        {{-- exam_question.edit --}}
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                value="exam_question.edit" wire:model="selectedFeature"
                                                id="exam_questionEdit">
                                            <label class="form-check-label" for="exam_questionEdit">Exam Question
                                                Edit</label>
                                        </div>

                                        {{-- exam_question.destroy --}}
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                value="exam_question.destroy" wire:model="selectedFeature"
                                                id="studentDestroy">
                                            <label class="form-check-label" for="studentDestroy">Exam Question
                                                Delete</label>
                                        </div>

                                        {{-- exam_question.assigned_course --}}
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                value="exam_question.assigned_course" wire:model="selectedFeature"
                                                id="exam_questionAssigned_course">
                                            <label class="form-check-label" for="exam_questionAssigned_course">Exam
                                                Question
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
                                                value="attendance.course_students" wire:model="selectedFeature"
                                                id="attendanceCourse_students">
                                            <label class="form-check-label" for="attendanceCourse_students">Attendance
                                                Course
                                                Students</label>
                                        </div>

                                        {{-- attendance.individual_students --}}
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                value="attendance.individual_students" wire:model="selectedFeature"
                                                id="attendanceIndividual_students">
                                            <label class="form-check-label"
                                                for="attendanceIndividual_students">Attendance
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
                                                wire:model="selectedFeature" id="accountsUpdate">
                                            <label class="form-check-label" for="accountsUpdate">Account Update
                                                Payment</label>
                                        </div>

                                        {{-- accounts.course_update --}}
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                value="accounts.course_update" wire:model="selectedFeature"
                                                id="accountsCourse_update">
                                            <label class="form-check-label" for="accountsCourse_update">Batch
                                                Accounts</label>
                                        </div>

                                        {{-- accounts.overall_user_account --}}
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                value="accounts.overall_user_account" wire:model="selectedFeature"
                                                id="accountsOverall_user_account">
                                            <label class="form-check-label" for="accountsOverall_user_account">Overall
                                                Account</label>
                                        </div>

                                        {{-- accounts.individual_student --}}
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                value="accounts.individual_student" wire:model="selectedFeature"
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
                                                value="transactions.user_online_transactions"
                                                wire:model="selectedFeature"
                                                id="transactionsUser_online_transactions">
                                            <label class="form-check-label"
                                                for="transactionsUser_online_transactions">Transactions Online
                                                Report</label>
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
                                                value="file_manager.individual_teacher" wire:model="selectedFeature"
                                                id="file_managerIndividual_teacher">
                                            <label class="form-check-label" for="file_managerIndividual_teacher">File
                                                Manager
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
                                                value="settings.individual_teacher" wire:model="selectedFeature"
                                                id="file_managerIndividual_teacher">
                                            <label class="form-check-label"
                                                for="file_managerIndividual_teacher">Setting
                                                Individual Teacher</label>
                                        </div>

                                    </div>

                                </div>
                            </div>



                        </div>



                        <div class="row">
                            <div class="col text-left">
                                <button type="submit" class="btn btn-primary mt-4">Update</button>
                            </div>
                            <div class="col text-right mt-5">
                                <a href="{{ route('administrator.index') }}">Go Back</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    @livewireScripts()
@endpush

@push('styles')
    @livewireStyles()
@endpush
