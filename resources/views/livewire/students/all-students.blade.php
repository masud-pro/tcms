<div>
    <div class="row">
        <div class="col-lg-3 offset-lg-9 text-right">
            <input type="text" class="form-control mb-3" placeholder="Search" wire:model.debounce.1000ms="q">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Status</th>
                    <th>Batch / Course</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Status</th>
                    <th>Batch / Course</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="text-center">
                            <a target="_blank" href="{{ $user->profile_photo_url ?? "" }}">
                                <img width="40" class="img-profile rounded-circle" src="{{ $user->profile_photo_url ?? "" }}">
                            </a>
                        </td>
                        <td><b>{{ $user->name }}</b></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone_no }}</td>
                        <td>{!! $user->is_active == 1 ? "<span class='badge bg-success text-dark'>Active</span>" : "<span class='badge bg-danger text-light'>Not Active</span>" !!}</td>
                        <td>
                            @forelse ($user->course as $course)
                                <b>{{ $course->name . ", " }}</b>
                            @empty
                                {{ "Not Found" }}
                            @endforelse
                        </td>
                        <td>{{ $user->created_at->format("d-M-Y") }}</td>
                        <td><a class="btn btn-primary" href="{{ route("user.edit",[ 'user' => $user->id ]) }}">Edit</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
</div>



@push("scripts")
    @livewireScripts()
@endpush

@push("styles")
    @livewireStyles()
@endpush