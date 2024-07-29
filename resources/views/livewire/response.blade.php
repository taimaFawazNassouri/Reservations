<div class="container">
    <div class="flag-container">
        <span>SYP</span>
        <img src="https://via.placeholder.com/30x20" alt="Flag">
    </div>
    <h2>Select your departing flight from DAM to SHJ</h2>

   
    <div class="flight-selection">
        @foreach ($allResponses as $date => $response)
            <div wire:click.prevent="select(@js($date))">
                <livewire:trip :key="$date" :date="$date" :data-array="$response" :selected="$selected === $date" />
            </div>
        @endforeach
    </div>

    @if ($this->selectedDay)
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
                    @foreach ($this->flights as $flight)
                       <tr>
                            @php
                               $departure = \Carbon\Carbon::parse($flight['ns1DepartureDateTime']);
                               $arrival = \Carbon\Carbon::parse($flight['ns1ArrivalDateTime']);
                            @endphp
                            <td>{{ $departure->format('H:i') }}</td>
                            <td class="flight-info">
                                {{ $flight['ns1OriginDestinationOptions']['ns1OriginDestinationOption']['ns1FlightSegment']['@attributes']['FlightNumber'] }}
                                <br>DAM/SHJ<br>
                                3 hour(s) / Direct Flight
                            </td>
                            <td>{{ $arrival->format('H:i') }}</td>
                            <td class="economy-class">{{ $this->TotalEquivFareWithCCFee }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
