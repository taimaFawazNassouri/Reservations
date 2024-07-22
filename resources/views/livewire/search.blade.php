<div>
    <div class="form-container">
        <h2>FIND YOUR FLIGHT</h2>
        {{-- @if ($this->loaded)
        <div class="flex flex-col gap-6">
            <div>
                <span>البطاقة</span>
                <p>{{ $this->$response }}</p>
            
            </div>
        </div>
        @endif --}}
        @if ($response)
        <div class="flex flex-col gap-6">
        <div>
            <p>{{ $response }}</p>
        </div>
        </div>
        @endif
        <form wire:submit.prevent="submitted">
            <div class="trip-type-container">
                <div class="trip-back">
                    <input type="radio" id="round-trip" wire:model="trip-type" value="round-trip" checked>
                    <label for="round-trip">ROUND TRIP</label>
                </div>
                <div class="trip-back">
                    <input type="radio" id="one-way" name="trip-type" value="one-way">
                    <label for="one-way">ONE WAY</label>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="from">FROM*</label>
                    <select id="from" wire:model="from" required>
                        <option value="" disabled selected>Choose your departure city</option>
                        <option value='DAM'>Damascus International Airport (DAM)</option>
					    <option value='LTK'>Latakia Bassel Al-Assad International Airport (LTK)</option>
					    <option value='ALP'>Aleppo International Airport (ALP)</option>
						<option value='BGW'>Baghdad International Airport (BGW)</option>
						<option value='BSR'>Basra International Airport (BSR)</option>
						<option value='BEY'>Beirut Rafic Hariri International Airport (BEY)</option>
						<option value='BEN'>Benghazi Benina International Airport (BEN)</option>
	                    <option value='EBL'>Erbil International Airport (EBL)</option>
						<option value='KAC'>Kamishly Airport (KAC)</option>
						<option value='KRT'>Khartoum International Airport (KRT)</option>
						<option value='KWI'>Kuwait International Airport (KWI)</option>
						<option value='MCT'>Muscat International Airport (MCT)</option>
						<option value='NJF'>Al Najaf International Airport (NJF)</option>
				        <option value='IKA'>Tehran International Airport (IKA)</option>
					    <option value='SHJ'>Sharjah International Airport (SHJ)</option>
						<option value='SVO'>Moscow Sheremetyevo International Airport (SVO)</option>
						<option value='EVN'>Yerevan - Zvartnots International Airport (EVN)</option>
						<option value='AUH'>Abu Dhabi International Airport (AUH)</option>
						<option value='KHI'>Karachi - Jinnah International Airport (KHI)</option>
		
                        <!-- Add more options as needed -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="to">TO*</label>
                    <select id="to" wire:model="to" required>
                        <option value="" disabled selected>Choose your departure city</option>
                        <option value="SHJ">Al_shrika</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="depart-date">DEPART DATE*</label>
                    <input type="date" id="depart-date" wire:model="selDepartureDate" >
                </div>
                <div class="form-group">
                    <label for="return-date">RETURN DATE*</label>
                    <input type="date" id="return-date"  wire:model="elReturnDate" >
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="adults">ADULTS</label>
                    <select id="adults" wire:model="adults">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="children">CHILDREN</label>
                    <select id="children"  wire:model="children">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="infants">INFANTS</label>
                    <select id="infants"  wire:model="infants">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="class">Class</label>
                    <select id="class" name="class" >
                        <option value="" disabled selected>Economy Class</option>
                        <option value="economy">Economy Class</option>
                        <option value="business">Business Class</option>
                        <!-- Add more options as needed -->
                    </select>

                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="orign">Orign*</label>
                    <select id="orign" name="orign" >
                        <option value="ADM" disabled selected>Syrian Arab Republic</option>
                        <option value="ADM">Syrian Arab Republic</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="currency">Currency*</label>
                    <select id="currency" name="currency" >
                        <option value="" disabled selected>SYP</option>
                        <option value="SYP"> SYP</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>
            </div>
            <button type="submit"> SUBMIT</button>
        </form>
    </div>
</div>
