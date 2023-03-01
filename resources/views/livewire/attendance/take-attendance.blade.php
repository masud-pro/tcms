<div>

    <div class="btn-group mb-4 mt-1 mr-3" wire:ignore.self>
        <button class="btn btn-outline-primary btn-sm mt-3 dropdown-toggle" type="button" id="dropdownMenuButton"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Take Attendance
        </button>

        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" wire:ignore.self>
            <div class="px-8 sm-hight">
                <input wire:model.prevent="search" name="name" class="form-control sm-hight" id="name"
                    type="text">
            </div>


            @foreach ($filteredBatches as $batch)
                <li>
                    <a class="dropdown-item pt-2"
                        href="{{ route('course.attendance.create', $batch->id) }}">{{ $batch->name }}</a>
                </li>
            @endforeach

        </ul>

    </div>

</div>


@push('scripts')
    @livewireScripts()
@endpush


@push('styles')
    @livewireStyles()
@endpush
