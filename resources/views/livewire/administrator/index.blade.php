<div>
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-3 offset-lg-9 text-right">
            <input type="text" class="form-control mb-3" placeholder="Search Name or ID"
                wire:model.debounce.500ms="search">
            {{-- <input type="text" class="form-control mb-3" placeholder="Search Name"> --}}
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Phone No</th>
                    <th>Status</th>
                    <th>Role</th>
                    <th>Created At</th>
                    {{-- <th>Actions</th>
                    <th>Permission</th> --}}
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Phone No</th>
                    <th>Status</th>
                    <th>Role</th>
                    <th>Created At</th>
                    {{-- <th>Actions</th>
                    <th>Permission</th> --}}
                </tr>
            </tfoot>
            <tbody>

                @forelse  ($administrators as $user)
                    <tr>
                        <td>
                            {{ $user->id }}
                        </td>
                        <td class="text-center">
                            <a target="_blank" href="{{ $user->profile_photo_url ?? '' }}">
                                <img width="40" height="40" class="img-profile rounded-circle"
                                    src="{{ $user->profile_photo_url ?? '' }}">
                            </a>
                        </td>
                        <td><b>{{ $user->name ?? 'Not Found' }}</b></td>
                        <td><b>{{ $user->teacherInfo->username ?? 'Not Found' }}</b></td>
                        <td>{{ $user->email ?? 'Not Found' }}</td>

                        <td>{{ $user->phone_no ?? 'Not Found' }}</td>


                        <td>
                            <div class="form-check form-switch ml-3">
                                <input wire:change="change_status({{ $user->id }},{{ $user->is_active }})"
                                    class="form-check-input" type="checkbox"
                                    @if ($user->is_active == 1) checked @endif
                                    id="flexSwitchCheckDefault{{ $user->id }}">
                                <label class="form-check-label" for="flexSwitchCheckDefault{{ $user->id }}">
                                    Is Active
                                </label>
                            </div>
                        </td>
                        <td>

                            @php
                                $roleName = collect($user->getRoleNames())->implode('-');
                            @endphp
                            {{ $roleName ?? 'Not Found' }}

                        </td>
                        <td>
                            {{ $user->created_at->format('d-M-Y') }}
                        </td>
                        {{-- <td>
                            <a class="btn btn-primary"
                                href="{{ route('administrator.edit', $user->id) }}"
                                target="_blank">
                                Edit
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-primary"
                                href="{{ route('administrator.edit', $user->id) }}"
                                target="_blank">
                                Permissions
                            </a>
                        </td> --}}
                    </tr>
                @empty
                    <tr>    
                        <td class="text-center" colspan="9"> No matching records found </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $administrators->links() }}
    </div>
</div>



@push('scripts')
    @livewireScripts()
@endpush

@push('styles')
    @livewireStyles()
    <style>
        .form-check-input:checked {
            background-color: #1cc88a;
            border-color: #1cc88a;
        }

        .sidebar-dark hr.sidebar-divider {
            border-top: 1px solid rgba(255, 255, 255, .7);
            box-sizing: content-box;
            height: 0;
            overflow: visible;
        }
    </style>
@endpush

@push('styles-before')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
@endpush
