<?php

namespace App\Livewire;

use SimpleXMLElement;
use Livewire\Component;
use App\Models\PassengerDetail;
use Livewire\WithFileUploads;
use GuzzleHttp\Client;
use App\Models\Credential;
use App\Models\Reservation;
use GuzzleHttp\Psr7\Request;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class Response extends Component
{
    public $selected = null;
    public $allResponses = [];

    public function mount()
    {
        $this->allResponses = session('allResponses');

        // select first available day
        $this->selected = session('selDepartureDate');
    }

    public function test()
    {
        dd($this->selectedDay);
    }

    public function select($uuid)
    {
        $this->selected = $uuid;
    }

    #[Computed]
    public function selectedDay()
    {
        return $this->allResponses[$this->selected] ?? null;
    }

    #[Computed]
    public function Available()
    {
        return array_key_exists('ns1AAAirAvailRSExt', $this->selectedDay['ns1OTA_AirAvailRS']);
    }

    #[Computed]
    public function flights()
    {
        if (!$this->Available) {
            return [];
        }

        if (array_key_exists('@attributes', $this->selectedDay['ns1OTA_AirAvailRS']['ns1OriginDestinationInformation'])) {
            return [$this->selectedDay['ns1OTA_AirAvailRS']['ns1OriginDestinationInformation']];
        }

        return $this->selectedDay['ns1OTA_AirAvailRS']['ns1OriginDestinationInformation'];
    }
    #[Computed]
    public function TotalEquivFareWithCCFee()
    {
        $TotalEquivFareWithCCFee = $this->selectedDay['ns1OTA_AirAvailRS']['ns1AAAirAvailRSExt']['ns1PricedItineraries']['ns1PricedItinerary']['ns1AirItineraryPricingInfo']['ns1ItinTotalFare']['ns1TotalEquivFareWithCCFee']['@attributes'] ?? [];

        // Get the amount and currency code
        $amount = $TotalEquivFareWithCCFee['Amount'] ?? null;
        $currencyCode = $TotalEquivFareWithCCFee['CurrencyCode'] ?? null;

        // Format the amount
        $formattedAmount = $amount ? str($amount)->squish()->toString() : null;

        // Return formatted string
        return $formattedAmount && $currencyCode
            ? "{$formattedAmount} {$currencyCode}"
            : null;
    }
 

    public function render()
    {
        return view('livewire.response');
    }
}
