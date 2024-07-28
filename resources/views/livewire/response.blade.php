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
        @foreach ($allResponses as $uuid => $response)
            <div wire:click.prevent="select(@js($uuid))">
                <livewire:trip :key="$uuid" :data-array="$response" :selected="$selected === $uuid" />
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
                {{-- @foreach ($this->dataArray as )
                    
                @endforeach --}}
                <tr>
                   



                    <td class="economy-class">SYP 8033762</td>
                </tr>
                <tr>
                    <td>14:45</td>
                    <td class="flight-info">6Q747<br>DAM/SHJ<br>3 hour(s) / Direct Flight</td>
                    <td>18:45</td>
                    <td class="economy-class">SYP 8033762</td>
                </tr>
            </tbody>
        </table>
    @endif
</div>
