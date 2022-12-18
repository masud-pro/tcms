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
                    <th>Subscriber Name</th>
                    <th>Package Name</th>
                    <th>Expiry Day</th>
                    <th>Last Renew</th>
                    <th>Actions</th>

                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Subscriber Name</th>
                    <th>Package Name</th>
                    <th>Expiry Day</th>
                    <th>Last Renew</th>
                    <th>Actions</th>

                </tr>
            </tfoot>
            <tbody>

                @forelse  ($subscriptionUsers as $userData)
                    <tr>
                        <td>
                            {{ $userData->id }}
                        </td>

                        <td><b>{{ $userData->user->name ?? 'Not Found' }}</b></td>
                        <td>{{ $userData->subscription->name ?? 'Not Found' }}</td>


                        <td>
                            {{ Carbon\Carbon::parse($userData->expiry_date)->format('d M Y') }}


                        </td>
                        <td>
                            {{ $userData->created_at->format('d-M-Y') }}
                        </td>
                         <td>
                            <a class="btn btn-primary" href="{{ route('subscription.edit', $userData->id) }}"
                                target="_blank">
                                Renew
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
        {{ $subscriptionUsers->links() }}
    </div>
</div>



@push('scripts')
    @livewireScripts()
@endpush

@push('styles')
    @livewireStyles()
@endpush
