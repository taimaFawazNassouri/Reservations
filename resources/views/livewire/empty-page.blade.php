<div class="container">
    @if ($this->loaded)
        <div class="flex flex-col gap-6">
            <div>
                <span>الاسم</span>
                <p>{{ $this->first_name }}</p>
            </div>
        </div>
    @endif

    <!-- Button to Open the Modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#formModal">
        search
    </button>


    <!-- The Modal -->
    <div class="modal" id="formModal" wire:ignore x-on:close-modal.window="$refs.close.click()">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Reservation</h4>
                    <button type="button" class="close" x-ref="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">

                    <div class="card-body">


                        <form wire:submit.prevent="submitted" autocomplete="off">

                            <!-- Input field with JavaScript for uppercase conversion -->
                            <div class="form-group">
                                <label for="inputField">Enter Number Reservation:</label>
                                <input wire:model="reservation_number" type="text" class="form-control" id="inputField" name="number_reservation" pattern="[A-Za-z0-9]{6}" title="Number reservation must be exactly 6 alphanumeric characters" required>
                                <small class="error" id="error-message">Number reservation must be exactly 6 alphanumeric characters.</small>
                            </div>


                            <!-- Modal Footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" onclick="validateInput()" class="btn btn-primary">confirm</button>
                            </div>

                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
