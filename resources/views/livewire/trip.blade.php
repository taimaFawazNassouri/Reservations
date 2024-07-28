<div @class(['date', 'active' => $selected])>
    @if ($this->available)
        @php
            $carbon = \Carbon\Carbon::parse($this->DepartureDateTime);
        @endphp
        {{ $carbon->format('D') }}
        <br>
        {{ $carbon->format('d M') }}
        <br>
        {{ $this->TotalEquivFareWithCCFee }}
    @else
        Unavailable
        <br>
        Unavailable
        <br>
        Unavailable
    @endif
</div>
