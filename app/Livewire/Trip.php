<?php

namespace App\Livewire;
use SimpleXMLElement;
use GuzzleHttp\Client;
use Livewire\Component;
use App\Models\Credential;
use App\Models\Reservation;
use GuzzleHttp\Psr7\Request;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class Trip extends Component
{
    public $dataArray;

    public function mount($dataArray){
       $this->dataArray = $dataArray;
    
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
        $DepartureAirport = $this->dataArray['ns1OTA_AirAvailRS']['ns1OriginDestinationInformation']['ns1OriginDestinationOptions']['ns1OriginDestinationOption']['ns1FlightSegment']['ns1DepartureAirport']['@attributes']['LocationCode']?? null;
        return $DepartureAirport ? str($DepartureAirport)->squish()->toString() : null;
    }
    public function render()
    {
        return view('livewire.trip');
    }
}
