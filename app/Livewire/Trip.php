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
    #[Computed]
    public function DepartureDateTime()
    { 
        $flightSegment = $this->dataArray['ns1OTA_AirAvailRS']['ns1OriginDestinationInformation']['ns1OriginDestinationOptions']['ns1OriginDestinationOption']['ns1FlightSegment'] ?? null;

        // Check if flightSegment exists and is an array
        if (is_array($flightSegment)) {
            // If it contains '@attributes', ensure it's wrapped in another array
            if (array_key_exists('@attributes', $flightSegment)) {
                $flightSegment = [$flightSegment];
            }
            dd($flightSegment);
    
            // Iterate over each segment (assuming there might be multiple)
            foreach ($flightSegment as $segment) {
                if (isset($segment['@attributes']['DepartureDateTime'])) {
                    // Return the DepartureDateTime from the @attributes
                    return $segment['@attributes']['DepartureDateTime'];
                }
            }
        }
    
        // Return null or an empty string if no DepartureDateTime found
        return null;
    }
    public function render()
    {
        return view('livewire.trip');
    }
}
