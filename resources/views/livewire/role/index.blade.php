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
                    <th>Role Name</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Role Name</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>

                @forelse  ($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>        
                        <td>
                            {{ $role->created_at->format('d-M-Y') }}
                        </td>
                        <td>
                            <a class="btn btn-primary"
                                href="{{ route('role.edit', $role->id) }}"
                                target="_blank">
                                Edit
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>    
                        <td class="text-center" colspan="9"> No matching records found </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
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
