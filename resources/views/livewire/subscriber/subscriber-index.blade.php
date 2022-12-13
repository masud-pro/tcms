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

                {{-- @forelse  ($subscriptions as $subscription)
                    <tr>
                        <td>
                            {{ $subscription->id }}
                        </td>

                        <td><b>{{ $subscription->name ?? 'Not Found' }}</b></td>
                        <td>{{ $subscription->price ?? 'Not Found' }}</td>


                        <td>
                            {{ $subscription->days }}
                        </td>
                        <td>
                            {{ $subscription->created_at->format('d-M-Y') }}
                        </td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('subscription.edit', $subscription->id) }}"
                                target="_blank">
                                Edit
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="9"> No matching records found </td>
                    </tr>
                @endforelse --}}
            </tbody>
        </table>
        {{-- {{ $subscriptions->links() }} --}}
    </div>
</div>



@push('scripts')
    @livewireScripts()
@endpush

@push('styles')
    @livewireStyles()
@endpush

