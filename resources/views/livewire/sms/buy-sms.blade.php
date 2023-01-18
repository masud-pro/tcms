
    {{-- <button type="button" wire:click="flushCreate" class="btn btn-primary mb-3" data-toggle="modal" data-target="#createModal"> --}}
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#createModal">
        Buy Message
    </button>


    <!-- Create Modal -->
    <div wire:ignore.self class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form wire:submit.prevent="createAccount">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Add to Accounts</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ( $errors->any() )
                        <span class="text-danger">Please fillup all the data correctly</span><br>
                    @endif
                    <label><b>Account For</b></label>
                    <input wire:model.lazy="account.name" type="text" class="form-control" placeholder="i.e House Rent" required>

                    <label class="mt-3"><b>Some Description</b></label>
                    <textarea wire:model.lazy="account.description" name="" id="" cols="30" rows="2" class="form-control"></textarea>

                    <label class="mt-3"><b>It's a</b></label>
                    <select wire:model.lazy="account.status" name="" class="form-control">
                        <option value="Revenue">Revenue</option>
                        <option value="Expense">Expense</option>
                    </select>
                    
                    <label class="mt-3"><b>Amount</b></label>
                    <input wire:model.lazy="account.paid_amount" type="number" min="0" class="form-control" required>

                    <label class="mt-3"><b>Month</b></label>
                    <input wire:model.lazy="account.month" type="text" id="createMonth" class="form-control" placeholder="Account For Month">

                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Create">
                </div>
            </form>
        </div>
        </div>
    </div>

