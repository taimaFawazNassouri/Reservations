<div>
    <table>
        <thead>
            <tr>
                <th>Fare Basis Codes</th>
                <th>Fare Rule Reference</th>
                <th>Departure Airport</th>
                <th>Arrival Airport</th>
                <th>Departure Date & Time</th>
                <th>Arrival Date & Time</th>
                <th>Flight Number</th>
                <th>Total Fare with CC Fee</th>
                <th>Total Equivalent Fare with CC Fee</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $FareBasisCodes }}</td>
                <td>{{ $FareRuleReference }}</td>
                <td>{{ $DepartureAirport }}</td>
                <td>{{ $ArrivalAirport }}</td>
                <td>{{ $DepartureDateTime }}</td>
                <td>{{ $ArrivalDateTime }}</td>
                <td>{{ $FlightNumber }}</td>
                <td>{{ $TotalFareWithCCFee }}</td>
                <td>{{ $TotalEquivFareWithCCFee }}</td>
            </tr>
        </tbody>
    </table>
</div>
     
{{-- <div>
        
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
                        <td>{{ $this->FareBasisCodes}}</td>
                        <td>{{ $this->FareRuleReference}}</td>
    
    
                    </tr>
                </tbody>
            </table>
        </div>
     
    </div> --}}