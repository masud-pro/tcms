<div>

    <div class="card-body">
        <div class="form-row mb-4">
            <div class="col-md-4" wire:ignore>
                <label>User Role</label>
                <select wire:model.debounce.500ms="batch" id="batch" class="form-control js-example-disabled-results">
                    <option value="">Select Role</option>
                    @foreach ($roles as $roleData)
                        <option value="{{ $roleData->id }}">{{ $roleData->name }}</option>
                    @endforeach
                </select>
            </div>

        </div>

        {{-- Pages permission --}}
        <div class="row">
            <div class="col-md-12">
                <div class="form-check mt-3 mb-3">
                    <input class="form-check-input" id="selectAll" type="checkbox">
                    <label class="form-check-label" for="selectAll">Select All Check</label>
                </div>
            </div>

            {{-- 
                
            
            'courses.archived',
            'courses.authorization_panel',
            'courses.authorize_users',
            'courses.reauthorize_users',
            'courses.create',
            'courses.edit',
            'courses.update',
            'courses.destroy',
            'feed.create',
            'feed.edit',
            'feed.update',
            'feed.destroy',
            'feed.create_link',
            'feed.store',
            'feed.store_link',
            'feed.edit_link',
            'feed.update_link',
                

                --}}


            <div class="col-md-6">
                <div class="card">

                    <div class="card-body">
                        <h5 class="card-title"><u>Course</u> </h5>

                        {{-- courses.index --}}
                        <div class="form-check">
                            <input class="form-check-input checkbox" type="checkbox" value="2" name="checkHh" id="2">
                            <label class="form-check-label" for="chcek-{{ 2 }}">Course List</label>
                        </div>

                        {{-- courses.create --}}
                        <div class="form-check">
                            <input class="form-check-input checkbox" type="checkbox" value="3" name="checkHh" id="3">
                            <label class="form-check-label" for="chcek-{{ 3 }}">Course Create</label>
                        </div>

                        {{-- courses.authorization_panel --}}
                        <div class="form-check">
                            <input class="form-check-input checkbox" type="checkbox" value="4" name="checkHh"
                                id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">Courses Edit</label>
                        </div>

                        {{-- courses.authorization_panel --}}
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="courses.index" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">Courses Delete</label>
                        </div>

                        {{-- courses.authorization_panel --}}
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="courses.index" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">Courses Archived</label>
                        </div>

                        {{-- courses.authorization_panel --}}
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="courses.index" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">Courses Authorization Panel</label>
                        </div>

                        {{-- courses.authorization_panel --}}
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="courses.index" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">Courses Authorize Student</label>
                        </div>

                    </div>


                </div>


            </div>

            <div class="col-md-6">
                <div class="card">

                    <div class="card-body">
                        <h5 class="card-title"><u>Feed</u> </h5>

                        {{-- feed.create --}}
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">Feed Create</label>
                        </div>

                        {{-- feed.edit --}}
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">Feed Edit</label>
                        </div>



                        {{-- feed.edit --}}
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">Feed Delete</label>
                        </div>


                        {{-- feed.edit --}}
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">Feed Create Link</label>
                        </div>

                        {{-- feed.edit --}}
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">Feed Edit Link</label>
                        </div>

                        {{-- feed.edit --}}
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">Feed Delete Link</label>
                        </div>


                    </div>


                </div>


            </div>

        </div>



        {{-- New Portion --}}
        {{-- <div class="row">
            <div class="col-md-6 mt-4">
                <div class="card">


                    <div class="card-body">
                        <h5 class="card-title"><u>Amistration</u> </h5>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Default checkbox
                            </label>
                        </div>

                    </div>


                </div>


            </div>
            <div class="col-md-6 mt-4">
                <div class="card">


                    <div class="card-body">
                        <h5 class="card-title"><u>Amistration</u> </h5>


                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Default checkbox
                            </label>
                        </div>

                    </div>


                </div>


            </div>

        </div> --}}

    </div>

</div>

@push('styles')
    @livewireStyles()
    {{-- // <link href="{{ asset('assets') }}/css/datepicker/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css"> --}}
@endpush
@push('scripts')
    @livewireScripts()

    <script>
        $("#selectAll").click(function() {
            $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
        });
    </script>
@endpush
