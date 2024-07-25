<div>
        <div>
            @if ($this->loaded)
            <div class="table-responsive">
                <button type="button" class="btn btn-primary" wire:click.prevent="test">
                    test
                </button>
                <table id="datatable" class="table  table-hover table-sm table-bordered p-0"data-page-length="50"style="text-align: center">
                   <thead>
                        <tr>
                                
                            <th>DepartureAirport</th>
                            <th>ArrivalAirport</th>
                            <th>DepartureDateTime</th>
                            <th>ArrivalDateTime</th>
                            <th>FlightNumber</th>
                            <th>JourneyDuration</th>
                            <th>TotalFareWithCCFee</th>
                            <th>TotalEquivFareWithCCFee</th>
                            <th>FareBasisCodes</th>
                            <th>FareRuleReference</th>
                        </tr>
                    </thead>
                    <tbody>
                      
                        <tr>
                            <td>{{ $this->DepartureAirport }}</td>
                            <td>{{ $this->ArrivalAirport}}</td>
                            <td>{{ $this->DepartureDateTime}}</td>
                            <td>{{ $this->ArrivalDateTime}}</td>
                            <td>{{ $this->FlightNumber}}</td>
                            <td>{{ $this->JourneyDuration}}</td>
                            <td>
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <div class="group dark:hover:bg-gray-900 hover:bg-gray-100 flex items-center gap-1 p-1 transition duration-300 rounded-full cursor-pointer" :class="{ 'dark:bg-gray-900 bg-gray-100': open }">
                                            {{ $this->TotalFareWithCCFee }}
                                        </div>
                                    </x-slot>
        
                                     <x-slot name="content">
                                        <button wire:click="setBasis" class="text-start w-full bg-white border-0">
                                            <x-dropdown-link>
                                                BaseFare
                                            </x-dropdown-link>
                                        </button>
                                          <!-- Button to select Taxes -->
                                        <button wire:click="setTaxes" class="text-start w-full bg-white border-0">
                                            <x-dropdown-link>
                                                Taxes
                                            </x-dropdown-link>
                                        </button>
                                        <button wire:click="setFees" class="text-start w-full bg-white border-0">
                                            <x-dropdown-link>
                                                Fees
                                            </x-dropdown-link>
                                        </button>
                                    </x-slot>
                                </x-dropdown>
                            </td>
    
                            @if ($selectedOption)
                            <div class="selected-details">
                                <p><strong>Details:</strong> {{ $this->Basis }}</p>
                                @if (!empty($this->taxes))
                                    @foreach ($this->taxes as $index => $taxDetail)
                                       <div>
                                            <p wire:click="toggleTaxDetail({{ $index }})" class="cursor-pointer">
                                                    <strong>Show Tax Detail {{ $index + 1 }}</strong>
                                            </p>
                                            @if (!empty($this->expandedTaxDetails[$index]) && $this->expandedTaxDetails[$index])
                                                <div class="ml-4">
                                                    <p>{{ $taxDetail }}</p> <!-- Display more detailed information here -->
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                                @if (!empty($this->fees))
                                    @foreach ($this->fees as $index => $feeDetail)
                                       <div>
                                            <p wire:click="toggleFeeDetail({{ $index }})" class="cursor-pointer">
                                                    <strong>Show Fee Detail {{ $index + 1 }}</strong>
                                            </p>
                                            @if (!empty($this->expandedFeeDetails[$index]) && $this->expandedFeeDetails[$index])
                                                <div class="ml-4">
                                                    <p>{{ $feeDetail }}</p> <!-- Display more detailed information here -->
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            @endif
                            <td wire:click.prevent="showDetails">{{ $this->TotalEquivFareWithCCFee}}</td>
                            <td>{{ $this->TransactionIdentifier}}</td>
                            <td>{{ $this->FareRuleReference}}</td>
        
        
                        </tr>
                    </tbody>
                </table>
            </div>
            @endif
        </div>
      
        <div class="form-container"  x-data="{ isVisible: true }" x-init="window.addEventListener('hideForm', () => {isVisible = false;})">
            
            {{-- @if ($response)
                <div class="flex flex-col gap-6">
                    <div>
                        <p>{{ $response }}</p>
                    </div>
                </div>
            @endif --}}
            <form x-show="isVisible" wire:submit.prevent="submitted">
                <div class="trip-type-container">
                    <div class="trip-back">
                        <button type="button" id="round-trip" wire:click.prevent="$set('tripType','round-trip')" class="{{ $tripType === 'round-trip' ? 'active' : '' }}">ROUND TRIP</button>
                    </div>
                    <div class="trip-back">
                        <button type="button" id="one-way" wire:click.prevent="$set('tripType','one-way')" class="{{ $tripType === 'one-way' ? 'active' : '' }}">ONE WAY</button>
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
                            <option value="SHJ">Sharjah International Airport (SHJ)</option>
                            <option value='DAM'>Damascus International Airport (DAM)</option>
                            <!-- Add more options as needed -->
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="depart-date">DEPART DATE*</label>
                        <input type="date" id="depart-date" wire:model="selDepartureDate">
                    </div>
                    @if ($tripType === 'round-trip')
                        <div class="form-group" id="return_date">
                            <label for="return-date">RETURN DATE*</label>
                            <input type="date" id="return-date" wire:model="elReturnDate">
                        </div>
                    @endif
                   
                   
    
                   
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <input type="checkbox" id="flexible-dates" class="checkbox" wire:model="flexibleDates">

                        <label for="flexible-dates" class="checklabel">+/- 3 days</label>
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
                        <select id="children" wire:model="children">
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
                        <select id="infants" wire:model="infants">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="class">Class</label>
                        <select id="class" name="class">
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
                        <select id="orign" name="orign">
                            <option value="ADM" disabled selected>Syrian Arab Republic</option>
                            <option value="ADM">Syrian Arab Republic</option>
                            <!-- Add more options as needed -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="currency">Currency*</label>
                        <select id="currency" name="currency">
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
 
    