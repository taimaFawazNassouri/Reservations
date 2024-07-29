<div class="container">
    <h2>Select your departing flight from <strong>DAM</strong> to <strong>SHJ</strong></h2>
    <div class="progress-bar">
        <ul>
            <li class="completed">Search</li>
            <li class="current">Select flight</li>
            <li>Enter details</li>
            <li>Add extras</li>
            <li>Pay and confirm</li>
        </ul>
    </div>

    <button wire:click="test">test</button>
    <div class="date-selection">
        @foreach ($allResponses as $date => $response)
            <div wire:click.prevent="select(@js($date))">
                <livewire:trip :key="$date" :date="$date" :data-array="$response" :selected="$selected === $date" />
            </div>
        @endforeach
    </div>

    @if ($this->selectedDay)
        <table class="flight-table">
            <thead>
                <tr>
                    <th>Departure Time</th>
                    <th>Flight Information</th>
                    <th>Arrival Time</th>
                    <th>Economy Class</th>
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
                        <td class="economy-class">{{ '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
