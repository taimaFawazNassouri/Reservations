<div class="container">
    <div class="flag-container">
        <span>SYP</span>
        <img src="https://via.placeholder.com/30x20" alt="Flag">
    </div>

    <h2>
        @if ($tripType == 'round-trip')
            1.
        @endif
        Select your departing flight from {{ $this->from }} to {{ $this->to }}
    </h2>

    <button wire:click="test">test</button>
    <div class="flight-selection">
        @foreach ($goingDates as $gDate)
            <div wire:click.prevent="setGoingDate(@js($gDate->format('Y-m-d')))">
                <div @class(['date', 'active' => $goingDate === $gDate->format('Y-m-d')])>
                    {{ $gDate->translatedFormat('l') }}
                    <br>
                    <span style="text-transform: uppercase;">
                        {{ $gDate->format('d M') }}
                    </span>
                    <br>
                    @php
                        $group = $this->goingFlightsGroups->get($gDate->format('Y-m-d'));
                    @endphp
                    @if ($group)
                        {{ $group->min('TotalEquivFareWithCCFee') }}
                    @else
                        No Flights
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    @if ($this->selectedGoingFlightsGroup)
        <div class="flight-details">
            <h3>Economy Class</h3>
            <table>
                <thead>
                    <tr>
                        <th>Departure Time</th>
                        <th>Flight Information</th>
                        <th>Arrival Time</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->selectedGoingFlightsGroup as $flight)
                        <tr>
                            @php
                                $departure = \Carbon\Carbon::parse($flight->DepartureDateTime);
                                $arrival = \Carbon\Carbon::parse($flight->ArrivalDateTime);
                            @endphp
                            <td>{{ $departure->format('H:i') }}</td>
                            <td class="flight-info">
                                {{ $flight->FlightNumber }}
                                <br>
                                {{ $flight->DepartureAirport }}
                                /
                                {{ $flight->ArrivalAirport }}
                                <br>
                                {{ $arrival->diffForHumans($departure, true) }} / Direct Flight
                            </td>
                            <td>{{ $arrival->format('H:i') }}</td>
                            <td class="economy-class">
                                <label for="{{ $flight->FlightNumber }}">
                                    {{ $flight->TotalEquivFareWithCCFee }}
                                </label>
                                <input id="{{ $flight->FlightNumber }}" type="radio" wire:model.live="goingTrip" value="{{ $flight->FlightNumber }}" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif



    @if ($tripType == 'round-trip')
        <h2>2. Select your departing flight from {{ $this->to }} to {{ $this->from }}</h2>

        <div class="flight-selection">
            @foreach ($returningDates as $rDate)
                <div wire:click.prevent="setReturningDate(@js($rDate->format('Y-m-d')))">
                    <div @class([
                        'date',
                        'active' => $returningDate === $rDate->format('Y-m-d'),
                    ])>
                        {{ $rDate->translatedFormat('l') }}
                        <br>
                        <span style="text-transform: uppercase;">
                            {{ $rDate->format('d M') }}
                        </span>
                        <br>
                        @php
                            $group = $this->returningFlightsGroups->get($rDate->format('Y-m-d'));
                        @endphp
                        @if ($group)
                            {{ $group->min('TotalEquivFareWithCCFee') }}
                        @else
                            No Flights
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        @if ($this->selectedReturningFlightsGroup)
            <div class="flight-details">
                <h3>Economy Class</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Departure Time</th>
                            <th>Flight Information</th>
                            <th>Arrival Time</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->selectedReturningFlightsGroup as $flight)
                            <tr>
                                @php
                                    $departure = \Carbon\Carbon::parse($flight->DepartureDateTime);
                                    $arrival = \Carbon\Carbon::parse($flight->ArrivalDateTime);
                                @endphp
                                <td>{{ $departure->format('H:i') }}</td>
                                <td class="flight-info">
                                    {{ $flight->FlightNumber }}
                                    <br>
                                    {{ $flight->DepartureAirport }}
                                    /
                                    {{ $flight->ArrivalAirport }}
                                    <br>
                                    {{ $arrival->diffForHumans($departure, true) }} / Direct Flight
                                </td>
                                <td>{{ $arrival->format('H:i') }}</td>
                                <td class="economy-class">
                                    <label for="{{ $flight->FlightNumber }}">
                                        {{ $flight->TotalEquivFareWithCCFee }}
                                    </label>
                                    <input id="{{ $flight->FlightNumber }}" type="radio" wire:model.live="returningTrip" value="{{ $flight->FlightNumber }}" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endif

    @if ($tripType == 'round-trip')
        @if ($goingTrip && $returningTrip)
            <h2>Summary of your selection</h2>

            <button wire:click.prevent="goToPassengerDetails">
                Continue to Passenger Details
            </button>
        @endif
    @else
        @if ($goingTrip)
            <h2>Summary of your selection</h2>

            <button wire:click.prevent="goToPassengerDetails">
                Continue to Passenger Details
            </button>
        @endif
    @endif
</div>
