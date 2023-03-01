<div>
    @forelse ($assessments as $assessment)
        @if ($assessment->type == 'Assignment')
            <div class="card mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <div class="m-0 font-weight-bold">
                        <h6 class="m-0 font-weight-bold text-dark">Assignment @if (auth()->user()->role == 'Admin')
                                - Id {{ $assessment->id }}
                            @endif
                        </h6>
                        <span class="small">
                            {{ $assessment->created_at ? $assessment->created_at->format('dS-M-Y h:i A') : '' }}</span>
                    </div>

                    @if (auth()->user()->role == 'Admin')
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuAssessment"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuAssessment">
                                {{-- <div class="dropdown-header">Options</div> --}}
                                <a class="dropdown-item"
                                    href="{{ route('assessments.edit', ['assessment' => $assessment->id]) }}">
                                    Edit Asssignment
                                </a>
                                <form action="{{ route('assessments.destroy', ['assessment' => $assessment->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit"
                                        onclick="return confirm('Are you sure you want to delete this post?')"
                                        class="dropdown-item" value="Delete Assessment">
                                </form>
                            </div>
                        </div>
                    @endif

                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <h5 class="mt-2 card-title text-dark">{{ $assessment->name }}</h5>
                    <hr>
                    {!! $assessment->description !!}
                    <a href="{{ route('assessments.show', ['assessment' => $assessment->id]) }}" target="_blank"
                        class="btn btn-primary mt-3 mb-2">

                        <i class="fas fa-external-link-alt"></i>
                        See Assignment
                    </a>
                    @if (auth()->user()->role == 'Admin')
                        <a href="{{ route('assessment.responses', ['assessment' => $assessment->id]) }}"
                            class="btn btn-primary mt-3 mb-2">

                            {{-- <i class="fas fa-external-link-alt"></i> --}}
                            See Responses
                        </a>
                    @endif
                </div>
            </div>
        @endif
    @empty
        <p>No Assessments Found</p>
    @endforelse

    @if ($assessments->count() > 0 && $assessments->count() < $total)
        <button class="btn btn-primary" wire:click="loadmore()">Load More</button>
    @endif
    <div wire:loading>
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>


</div>

@push('scripts')
    @livewireScripts()
@endpush

@push('styles')
    @livewireStyles()
@endpush
