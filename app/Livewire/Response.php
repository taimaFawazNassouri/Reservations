<?php

namespace App\Livewire;

use App\FlightResponse;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;

class Response extends Component
{
    public array $response = [];

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
        $this->response = session('response', []);
        $this->tripType = session('tripType');
        $this->from = session('from');
        $this->to = session('to');
        $this->goingDate = session('goingDate');
        $this->returningDate = session('returningDate');

        // Initialize dates
        $this->initializeDates();

        // Initialize flight groups
        $this->goingFlightsGroups = collect([]);
        $this->returningFlightsGroups = collect([]);

        // Process each response
        $this->processResponses();
    }

    private function initializeDates()
    {
        // Initialize going dates
        $goingDate = Carbon::parse($this->goingDate)->startOfDay();
        $this->goingDates = collect([]);
        for ($i = -3; $i <= 3; $i++) {
            $this->goingDates->push($goingDate->clone()->addDays($i));
        }

        // Initialize returning dates
        $returningDate = Carbon::parse($this->returningDate)->startOfDay();
        $this->returningDates = collect([]);
        for ($i = -3; $i <= 3; $i++) {
            $this->returningDates->push($returningDate->clone()->addDays($i));
        }
    }

    private function processResponses()
    {
        foreach ($this->response as $responseXml) {
            if (!is_string($responseXml)) {
                continue; // Skip if the response is not a string
            }

            $flightResponse = new FlightResponse($responseXml);
            $flights = $flightResponse->getFlights();

            // Process going flights
            $goingFlights = $flights
                ->where('Path', $this->from . '/' . $this->to)
                ->unique(fn($flight) => $flight->FlightNumber . $flight->DepartureDate)
                ->groupBy('DepartureDate');

            $this->goingFlightsGroups = $this->goingFlightsGroups->merge($goingFlights);

            // Process returning flights
            $returningFlights = $flights
                ->where('Path', $this->to . '/' . $this->from)
                ->unique(fn($flight) => $flight->FlightNumber . $flight->DepartureDate)
                ->groupBy('DepartureDate');

            $this->returningFlightsGroups = $this->returningFlightsGroups->merge($returningFlights);
        }
    }
    public function render()
    {
        return view('livewire.response');
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
        session()->put('response', $this->response);
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
