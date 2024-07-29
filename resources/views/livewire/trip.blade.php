<div @class(['date', 'active' => $selected])>
    {{ $date->translatedFormat('l') }}
    <br>
    <span style="text-transform: uppercase;">
        {{ $date->format('d M') }}
    </span>
    <br>
    @if ($this->available)
        {{ $this->TotalEquivFareWithCCFee }}
    @else
        No Flights
    @endif
</div>
