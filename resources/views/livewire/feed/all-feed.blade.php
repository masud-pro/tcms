<div>

    <div class="card border-bottom-primary shadow mt-3">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list"></i>
                Feed
            </h6>
        </div>

        <div class="card-body">

            @forelse ($feeds as $feed)
                @if ( $feed->type == "post" )
                    <div class="card mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <div class="m-0 font-weight-bold">
                                <div class="d-flex">
                                    <img width="40" height="40" class="img-profile rounded-circle mt-1" src="{{ $feed->user->profile_photo_url ?? "" }}">
                                    <div class="ml-3">
                                        <p class="m-0 font-weight-bold text-dark">{{ $feed->user->name }}</p>
                                        <span class="small">{{ $feed->created_at ? $feed->created_at->format("dS M Y g:i A") : "" }}</span>
                                    </div>
                                </div>
                                
                            </div>


                            @if ( auth()->user()->role == "Admin" )
                                <div class="dropdown no-arrow">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                        aria-labelledby="dropdownMenuLink">
                                        {{-- <div class="dropdown-header">Options</div> --}}
                                        <a class="dropdown-item" href="{{ route("feeds.edit",["course"=>$course->id,"type"=>"post","feed"=>$feed->id]) }}">Edit post</a>
                                        <form action="{{ route("feeds.destroy",["feed"=>$feed->id]) }}" method="POST">
                                            @csrf
                                            @method("DELETE")
                                            <input type="submit" onclick="return confirm('Are you sure you want to delete this post?')" class="dropdown-item" value="Delete Post">
                                        </form>
                                    </div>
                                </div>
                            @endif

                        </div>
                        
                        <!-- Card Body -->
                        <div class="card-body">
                            <h5 class="mt-2 card-title text-dark">{{ $feed->name ?? "" }}</h5>
                            <hr>
                            <p class="card-text">
                                {!! Illuminate\Support\Str::words( $feed->description ,50) !!}
                                @if (Illuminate\Support\Str::wordCount( $feed->description) > 50)   
                                    <a data-toggle="collapse" href="#collapseExample{{ $feed->id }}" role="button" 
                                        aria-expanded="false" aria-controls="collapseExample">Read More</a>
                                @endif
                            </p>
                            <div class="collapse" id="collapseExample{{ $feed->id }}">
                                <div class="card card-body">
                                    {!! $feed->description !!}
                                </div>
                            </div>                              
                        </div>
                    </div>
                @elseif ($feed->type == "link")
                    <div class="card mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <div class="m-0 font-weight-bold">
                                
                                <div class="d-flex">
                                    <img width="40" height="40" class="img-profile rounded-circle mt-1" src="{{ $feed->user->profile_photo_url ?? "" }}">
                                    <div class="ml-3">
                                        <p class="m-0 font-weight-bold text-dark">{{ $feed->user->name }}</p>
                                        <span class="small">{{ $feed->created_at ? $feed->created_at->format("dS M Y g:i A") : "" }}</span>
                                    </div>
                                </div>
                            </div>

                            @if ( auth()->user()->role == "Admin" )
                                <div class="dropdown no-arrow">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                        aria-labelledby="dropdownMenuLink">
                                        {{-- <div class="dropdown-header">Options</div> --}}
                                        <a class="dropdown-item" href="{{ route("feeds.edit-link",["course"=>$course->id,"type"=>"link","feed"=>$feed->id]) }}">Edit Link</a>
                                        <form action="{{ route("feeds.destroy",["feed"=>$feed->id]) }}" method="POST">
                                            @csrf
                                            @method("DELETE")
                                            <input type="submit" onclick="return confirm('Are you sure you want to delete this post?')" class="dropdown-item" value="Delete Link">
                                        </form>
                                    </div>
                                </div>
                            @endif

                        </div>

                        <!-- Card Body -->
                        <div class="card-body">
                            <h5 class="mt-2 card-title text-dark">{!! $feed->name ?? "" !!}</h5>
                            <a href="{{ $feed->link ?? "" }}" target="_blank" class="btn btn-primary mt-3 mb-2">
                                <i class="fas fa-external-link-alt"></i>
                                Go to link
                            </a>                            
                        </div>
                    </div>
                @endif
            @empty
                <p>No Posts Found</p>
            @endforelse
    
            @if ( $feeds->count() > 0 && $feeds->count() < $total )
                <button class="btn btn-primary" wire:click="load">Load More</button> 
            @endif
            

            <div wire:loading>
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

        </div>
    </div>
</div>


@push("scripts")
    @livewireScripts()
@endpush

@push("styles")
    @livewireStyles()
@endpush