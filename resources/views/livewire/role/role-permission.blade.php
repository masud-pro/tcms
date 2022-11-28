<div>

    <div class="card-body">
        <div class="form-row mb-4">
            <div class="col-md-4" wire:ignore>
                <label>User Role</label>
                <select wire:model.debounce.500ms="batch" id="batch" class="form-control js-example-disabled-results">
                    <option value="">Select Role</option>
                    {{-- @foreach ($batches as $sbatch)
                            <option value="{{ $sbatch->id }}">{{ $sbatch->name }}</option>
                        @endforeach --}}
                </select>
            </div>

        </div>

        {{-- Pages permission --}}
        <div class="row">
            <div class="col-md-12">
                <div class="form-check mt-3 mb-3">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        Select All Check 
                    </label>
                </div>
            </div>


            <div class="col-md-6">
                <div class="card">
                    {{-- <h4>hekko</h4> --}}

                    <div class="card-body">
                        <h5 class="card-title"><u>Amistration</u> </h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                            the card's content.</p>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Default checkbox
                            </label>
                        </div>

                    </div>


                </div>


            </div>
            <div class="col-md-6">
                <div class="card">
                    {{-- <h4>hekko</h4> --}}
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                            the card's content.</p>

                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
