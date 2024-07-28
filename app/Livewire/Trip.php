<?php

namespace App\Livewire;

use SimpleXMLElement;
use GuzzleHttp\Client;
use Livewire\Component;
use App\Models\Credential;
use App\Models\Reservation;
use GuzzleHttp\Psr7\Request;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Reactive;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class Trip extends Component
{
    #[Reactive]
    public $selected;
    public $dataArray;

    public function mount($dataArray, bool $selected)
    {
        $this->selected = $selected;
        $this->dataArray = $dataArray;
    }

    public function test()
    {
        dd($this->dataArray);
    }

    #[Computed]
    public function Available()
    {
        return array_key_exists('ns1AAAirAvailRSExt', $this->dataArray['ns1OTA_AirAvailRS']);
    }

    #[Computed]
    public function FareBasisCodes()
    {
        // Extract the ns1FareBasisCode array
        $fareBasisCodes = $this->dataArray['ns1OTA_AirAvailRS']['ns1AAAirAvailRSExt']['ns1PricedItineraries']['ns1PricedItinerary']['ns1AirItineraryPricingInfo']['ns1PTC_FareBreakdowns']['ns1PTC_FareBreakdown']['ns1FareBasisCodes']['ns1FareBasisCode'] ?? [];

        // Get the second element from the array
        $secondFareBasisCode = $fareBasisCodes[1] ?? null;

        // Return the second FareBasisCode or null if it doesn't exist
        return $secondFareBasisCode ? str($secondFareBasisCode)->squish()->toString() : null;
    }

    #[Computed]
    public function DepartureAirport()
    {
        $DepartureAirport = $this->dataArray['ns1OTA_AirAvailRS']['ns1OriginDestinationInformation']['ns1OriginDestinationOptions']['ns1OriginDestinationOption']['ns1FlightSegment']['ns1DepartureAirport']['@attributes']['LocationCode'] ?? null;
        return $DepartureAirport ? str($DepartureAirport)->squish()->toString() : null;
    }

    #[Computed]
    public function DepartureDateTime()
    {
        if (array_key_exists('@attributes', $this->dataArray['ns1OTA_AirAvailRS']['ns1OriginDestinationInformation'])) {
            $DepartureAirport = $this->dataArray['ns1OTA_AirAvailRS']['ns1OriginDestinationInformation']['ns1DepartureDateTime'] ?? null;
        } else {
            $DepartureAirport = $this->dataArray['ns1OTA_AirAvailRS']['ns1OriginDestinationInformation'][0]['ns1DepartureDateTime'] ?? null;
        }
        return $DepartureAirport ? str($DepartureAirport)->squish()->toString() : null;;
    }

    #[Computed]
    public function TotalFareWithCCFee()
    {  // Extract the total fare with credit card fee element
        $totalFareWithCCFee = $this->dataArray['ns1OTA_AirAvailRS']['ns1AAAirAvailRSExt']['ns1PricedItineraries']['ns1PricedItinerary']['ns1AirItineraryPricingInfo']['ns1ItinTotalFare']['ns1TotalFareWithCCFee']['@attributes'] ?? [];

        // Get the amount and currency code
        $amount = $totalFareWithCCFee['Amount'] ?? null;
        $currencyCode = $totalFareWithCCFee['CurrencyCode'] ?? null;

        // Format the amount
        $formattedAmount = $amount ? str($amount)->squish()->toString() : null;

        // Return formatted string
        return $formattedAmount && $currencyCode
            ? "{$formattedAmount} {$currencyCode}"
            : null;
    }

    #[Computed]
    public function TotalEquivFareWithCCFee()
    {
        // Extract the total fare with credit card fee element
        $TotalEquivFareWithCCFee = $this->dataArray['ns1OTA_AirAvailRS']['ns1AAAirAvailRSExt']['ns1PricedItineraries']['ns1PricedItinerary']['ns1AirItineraryPricingInfo']['ns1ItinTotalFare']['ns1TotalEquivFareWithCCFee']['@attributes'] ?? [];

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
        return view('livewire.trip');
    }
}
