<div>
    <div class="row" wire:ignore.self wire:key="dashboard-search">
        <div class="col-12 d-flex justify-content-between mt-2">
            <h5 class="mb-4 mt-3">All Courses</h5>
            <div class="searchBox">
                <input class="searchInput form-control" type="text" wire:model.prevent="search"
                    placeholder="Search Course">
            </div>
        </div>
    </div>

    <div class="row" wire:ignore.self>
        @forelse ($filteredCourses as $course)
            <div class="col-md-3 mt-3 d-block" wire:key="dashboard-courses-{{ $loop->iteration }}">
                <div class="card">

                    <img class="card-img-top" height="250px"
                        src="{{ $course->image ? Storage::url($course->image) : asset('images/default-banner.jpg') }}"
                        alt="Card image cap">

                    <div class="card-body">

                        <h5 class="card-title text-dark">
                            <a class="text-dark" href="{{ route('course.feeds.index', ['course' => $course->id]) }}">
                                {{ Str::limit($course->name, 16) }} <span class="flot-r">Fee : <span
                                        class="text-primary font-weight-bold">{{ $course->fee }}</span>
                            </a>
                        </h5>


                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <span> Students: <span
                                    class="text-primary font-weight-bold">{{ $course->user ? $course->user->count() : '' }}
                                    / {{ $course->capacity ?? 'Not Found' }} </span></span>
                            <span class="flot-r"> Time: <span
                                    class="text-primary font-weight-bold">{{ $course->time }}</span>
                        </li>

                        <div class="card-body d-flex justify-content-between">

                            <a href="{{ route('course.feeds.index', ['course' => $course->id]) }}"
                                class="btn btn-outline-primary font-weight-bold fs-12">Feed</a>
                            <a href="{{ route('course.attendance.create', ['course' => $course->id]) }}"
                                class="btn btn-outline-secondary font-weight-bold fs-12">Attendance</a>
                            <a href="{{ route('course.accounts.create', ['course' => $course->id]) }}"
                                class="btn btn-outline-success font-weight-bold fs-12">Payment</a>
                        </div>
                </div>
            </div>


        @empty
            <div class="ml-3" >No Course Found</div>
        @endforelse
    </div>


</div>


@push('scripts')
    @livewireScripts()
@endpush


@push('styles')
    @livewireStyles()
@endpush
