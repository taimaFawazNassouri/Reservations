<div class="container">
    @if ($this->loaded)
        <div class="flex flex-col gap-6">
            <div>
                <span>البطاقة</span>
                <p>{{ $this->ticket_advisory }}</p>
                <p>{{ $this->count_passengers }}</p>
                <p>{{ $this->checkTravelersNationality }}</p>
                <p>{{ $this->checkDestination }}</p>
            </div>
        </div>
    @endif
    {{-- @if ($response)
    <div class="flex flex-col gap-6">
        <div>
            <p>{{ $response }}</p>
        </div>
    </div>
    @endif --}}

    <!-- Button to Open the Modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#formModal">
        {{trans('reservations.inquiry_about_number')}}
    </button>

    <button type="button" class="btn btn-primary" wire:click.prevent="test">
        test
    </button>


    <!-- The Modal -->
    <div class="modal" id="formModal" wire:ignore x-on:close-modal.window="$refs.close.click()">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">{{trans('main_trans.reservations')}}</h4>
                    <button type="button" class="close" x-ref="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">

                    <div class="card-body">


                        <form wire:submit.prevent="submitted" autocomplete="off">

                            <!-- Input field with JavaScript for uppercase conversion -->
                            <div class="form-group">
                                <label for="inputField">{{trans('reservations.inter_number_reservation')}}</label>
                                <input wire:model="reservation_number" type="text" class="form-control" id="inputField" name="number_reservation" pattern="[A-Za-z0-9]{6}" title="Number reservation must be exactly 6 alphanumeric characters" required>
                                <small class="error" id="error-message">{{trans('reservations.warning')}}</small>
                            </div>


                            <!-- Modal Footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">{{trans('reservations.close')}}</button>
                                <button type="submit" onclick="validateInput()" class="btn btn-primary">{{trans('reservations.submite')}}</button>
                            </div>

                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
