<?php

namespace App\Livewire;

use App\FlightResponse;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;

class Response extends Component
{
    public Collection $responses;

    public ?string $tripType;
    public ?string $from;
    public ?string $to;
    public ?string $goingDate;
    public ?string $returningDate;

    public Collection $goingDates;
    public Collection $returningDates;

    public ?string $goingTrip = null;
    public ?string $returningTrip = null;

    public Collection $goingFlightsGroups;
    public Collection $returningFlightsGroups;

    public function mount()
    {
        $this->responses = session('responses');

        // dd($this->responses);

        $this->tripType = session('tripType');
        $this->from = session('from');
        $this->to = session('to');
        $this->goingDate = session('goingDate');
        $this->returningDate = session('returningDate');

        $goingDate = Carbon::parse($this->goingDate)->startOfDay();
        $this->goingDates = collect([]);
        for ($i = -3; $i <= 3; $i++) {
            $this->goingDates->push($goingDate->clone()->addDays($i));
        }

        $returningDate = Carbon::parse($this->returningDate)->startOfDay();
        $this->returningDates = collect([]);
        for ($i = -3; $i <= 3; $i++) {
            $this->returningDates->push($returningDate->clone()->addDays($i));
        }

        $flights = collect();
        foreach ($this->responses as $key => $response) {
            $flightResponse = new FlightResponse($response);
            $flights = $flights->merge($flightResponse->getFlights());
        }

        $this->goingFlightsGroups = $flights
            ->where('Path', $this->from . '/' . $this->to)
            ->unique(fn ($flight) => $flight->FlightNumber . $flight->DepartureDate)
            ->groupBy('DepartureDate');

        $this->returningFlightsGroups = $flights
            ->where('Path', $this->to . '/' . $this->from)
            ->unique(fn ($flight) => $flight->FlightNumber . $flight->DepartureDate)
            ->groupBy('DepartureDate');
    }

    public function render()
    {
        return view('livewire.response');
    }

    public function test()
    {
        dd($this->goingFlightsGroups);
    }

    public function setGoingDate($gDate)
    {
        $this->goingDate = $gDate;
        $this->goingTrip = null;
    }

    public function setReturningDate($rDate)
    {
        $this->returningDate = $rDate;
        $this->returningTrip = null;
    }

    public function goToPassengerDetails()
    {
        session()->put('responses', $this->responses);
        session()->put('tripType', $this->tripType);
        session()->put('from', $this->from);
        session()->put('to', $this->to);
        session()->put('goingDate', $this->goingDate);
        session()->put('returningDate', $this->returningDate);
        session()->put('goingTrip', $this->goingTrip);
        session()->put('returningTrip', $this->returningTrip);

        return to_route('details');
    }

    #[Computed]
    public function selectedGoingFlightsGroup()
    {
        return $this->goingFlightsGroups->get($this->goingDate);
    }

    #[Computed]
    public function selectedReturningFlightsGroup()
    {
        return $this->returningFlightsGroups->get($this->returningDate);
    }
}
