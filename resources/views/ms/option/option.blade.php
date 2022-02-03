@extends('layouts.cms')

@section('title')
    Settings
@endsection

@push("styles")
    <link href="{{ asset("assets") }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')

<div class="row">
    <div class="col-md-12">

        @if ( session('success') )
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        {{-- <a class="btn btn-primary mb-4" href="{{ route("course.create") }}">Add Course</a> --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Settings</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <form action="{{ route("settings.update") }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method("PATCH")
                        <table class="table table-hover table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Options</th>
                                    <th>Values</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Options</th>
                                    <th>Values</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($options as $option)
                                    @if ($option->slug == "manual_payment")
                                        
                                        <tr>
                                            <td>{{ $option->name }}</td>
                                            <td>
                                                
                                                <select name="options[{{ $option->slug }}][value]" class="form-control">
                                                    <option @if( $option->value == 1 ) selected @endif value="1">Active</option>
                                                    <option @if( $option->value == 0 ) selected @endif value="0">Not Active</option>
                                                </select>
                                                
                                            </td>
                                        </tr>

                                    @elseif ( $option->slug == "online_payment")
                                        @if (  env("STORE_ID") != null &&  env("STORE_PASSWORD") != null )
                                            <tr>
                                                <td>{{ $option->name }}</td>
                                                <td>
                                                    
                                                    <select name="options[{{ $option->slug }}][value]" class="form-control">
                                                        <option @if($option->value == 1) selected @endif value="1">Active</option>
                                                        <option @if($option->value == 0) selected @endif value="0">Not Active</option>
                                                    </select>
                                                    
                                                </td>
                                            </tr>
                                        @endif
                                        
                                    @elseif ( $option->slug == "bkash_number" || $option->slug == "rocket_number" || $option->slug == "nagad_number" )
                                        <tr>
                                            <td>{{ $option->name }}</td>
                                            <td>      
                                                <textarea class="form-control" name="options[{{ $option->slug }}][value]">{{ $option->value }}</textarea> 
                                            </td>
                                        </tr>
                                    @elseif ( $option->slug == "remaining_sms" )
                                        <tr>
                                            <td>{{ $option->name }}</td>
                                            <td>
                                                
                                                <input disabled type="text" class="form-control" value="{{ $option->value }}">
                                                
                                            </td>
                                        </tr>
                                    @elseif ( $option->slug == "can_student_see_friends" )
                                        <tr>
                                            <td>{{ $option->name }}</td>
                                            <td>
                                                
                                                <select name="options[{{ $option->slug }}][value]" class="form-control">
                                                    <option @if( $option->value == 1 ) selected @endif value="1">Students Can See Friends</option>
                                                    <option @if( $option->value == 0 ) selected @endif value="0">Students Cannot See Friends</option>
                                                </select>
                                                
                                            </td>
                                        </tr>
                                    @elseif ( $option->slug == "emoji_visibility" )
                                        <tr>
                                            <td>{{ $option->name }}</td>
                                            <td>
                                                
                                                <select name="options[{{ $option->slug }}][value]" class="form-control">
                                                    <option @if( $option->value == 1 ) selected @endif value="1">Emoji Visible</option>
                                                    <option @if( $option->value == 0 ) selected @endif value="0">Emoji Not Visible</option>
                                                </select>
                                                
                                            </td>
                                        </tr>
                                    @elseif ( $option->slug == "front_page_image" )
                                        <tr>
                                            <td>{{ $option->name }}</td>
                                            <td>
                                                
                                                <input type="file" name="options[{{ $option->slug }}][value]" 
                                                    class="form-control-file" onchange="readURL(this);">

                                                <a target="_blank" 
                                                    href="{{ $option->value == 0 ? asset("images/frontpage/bg.jpg") : Storage::url($option->value) }}">

                                                    <img src="{{ $option->value == 0 ? asset("images/frontpage/bg.jpg") : Storage::url($option->value) }}" class="img-fluid" 
                                                        style="width: 400px; margin-top: 10px" id="front-page-image"> <br>

                                                    <a href="{{ route("options.reset-frontpage-image") }}" class="mt-1 d-block" 
                                                        onclick="return confirm('Are you sure you want the old image back?')">
                                                        Reset to default
                                                    </a>
                                                </a>
                                            </td>
                                        </tr>
                                    @elseif ( $option->slug == "front_page_font_color" )
                                        <tr>
                                            <td>{{ $option->name }}</td>
                                            <td>
                                    
                                                <select name="options[{{ $option->slug }}][value]" class="form-control">
                                                    <option @if( $option->value == "dark" ) selected @endif value="dark">Dark</option>
                                                    <option @if( $option->value == "light" ) selected @endif value="light">Light</option>
                                                </select>

                                            </td>
                                        </tr>
                                    @elseif ( $option->slug == "dashboard_course_view" )
                                        <tr>
                                            <td>{{ $option->name }}</td>
                                            <td>
                                    
                                                <select name="options[{{ $option->slug }}][value]" class="form-control">
                                                    <option @if( $option->value == "grid" ) selected @endif value="grid">Grid</option>
                                                    <option @if( $option->value == "table" ) selected @endif value="table">Table</option>
                                                </select>

                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    No Options Found
                                @endforelse
                                    
                                    
                            </tbody>
                        </table>
                        <input type="submit" class="btn btn-primary" value="Update">
                        
                    </form>
                    <div class="text-right">
                        <a href="{{ route("dashboard") }}">Back</a>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

    
@endsection


@push('scripts')
    {{-- <!-- Page level plugins -->
    <script src="{{ asset("assets") }}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset("assets") }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset("assets") }}/js/demo/datatables-demo.js"></script> --}}
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#front-page-image')
                        .attr('src', e.target.result)
                        .width(400);
                        // .height(250);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush