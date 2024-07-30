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
    public function showDetails()
    {
        Session::put('fare_basis_codes', $this->FareBasisCodes);
        Session::put('fare_rule_reference', $this->FareRuleReference);
        Session::put('DepartureAirport', $this->DepartureAirport);
        Session::put('ArrivalAirport', $this->ArrivalAirport);
        Session::put('DepartureDateTime', $this->DepartureDateTime);
        Session::put('ArrivalDateTime', $this->ArrivalDateTime);
        Session::put('FlightNumber', $this->FlightNumber);
        Session::put('TotalFareWithCCFee', $this->TotalFareWithCCFee);
        Session::put('TotalEquivFareWithCCFee', $this->TotalEquivFareWithCCFee);
        Session::put('TransactionIdentifier', $this->TransactionIdentifier);
        Session::put('RPH', $this->RPH);

        return redirect()->route('details'); // Make sure to define a route named 'details'
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
    public function FareRuleReference()
    {
        $FareRuleReference = $this->dataArray['ns1OTA_AirAvailRS']['ns1AAAirAvailRSExt']['ns1PricedItineraries']['ns1PricedItinerary']['ns1AirItineraryPricingInfo']['ns1PTC_FareBreakdowns']['ns1PTC_FareBreakdown']['ns1FareInfo']['ns1FareRuleReference'] ?? null;
        return $FareRuleReference ? str($FareRuleReference)->squish()->toString() : null;
    }
    #[Computed]
     public function DepartureAirport()
     {
         $DepartureAirport = $this->selectedDay['ns1OTA_AirAvailRS']['ns1OriginDestinationInformation']['ns1OriginDestinationOptions']['ns1OriginDestinationOption']['ns1FlightSegment']['ns1DepartureAirport']['@attributes']['LocationCode'] ?? null;
         return $DepartureAirport ? str($DepartureAirport)->squish()->toString() : null;
     }
 
    #[Computed]
     public function ArrivalAirport()
     {
         $ArrivalAirport = $this->selectedDay['ns1OTA_AirAvailRS']['ns1OriginDestinationInformation']['ns1OriginDestinationOptions']['ns1OriginDestinationOption']['ns1FlightSegment']['ns1ArrivalAirport']['@attributes']['LocationCode'] ?? null;
         return $ArrivalAirport ? str($ArrivalAirport)->squish()->toString() : null;
     }
 
    #[Computed]
     public function DepartureDateTime()
     {
         $flightSegment = $this->selectedDay['ns1OTA_AirAvailRS']['ns1OriginDestinationInformation']['ns1OriginDestinationOptions']['ns1OriginDestinationOption']['ns1FlightSegment'] ?? null;
 
         // Check if flightSegment exists and is an array
         if (is_array($flightSegment)) {
             // If it contains '@attributes', ensure it's wrapped in another array
             if (array_key_exists('@attributes', $flightSegment)) {
                 $flightSegment = [$flightSegment];
             }
 
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
 
    #[Computed]
     public function ArrivalDateTime()
     {
         $ArrivalDateTime = $this->selectedDay['ns1OTA_AirAvailRS']['ns1OriginDestinationInformation']['ns1OriginDestinationOptions']['ns1OriginDestinationOption']['ns1FlightSegment']['@attributes']['ArrivalDateTime'] ?? null;
         return $ArrivalDateTime ? str($ArrivalDateTime)->squish()->toString() : null;
     }
 
    #[Computed]
     public function FlightNumber()
     {
         $FlightNumber = $this->selectedDay['ns1OTA_AirAvailRS']['ns1OriginDestinationInformation']['ns1OriginDestinationOptions']['ns1OriginDestinationOption']['ns1FlightSegment']['@attributes']['FlightNumber'] ?? null;
         return $FlightNumber ? str($FlightNumber)->squish()->toString() : null;
     }
 
    
    #[Computed]
     public function TransactionIdentifier()
     {
         $TransactionIdentifier = $this->selectedDay['ns1OTA_AirAvailRS']['@attributes']['TransactionIdentifier'] ?? null;
         if ($TransactionIdentifier) {
             // Use str_replace to replace 'DEMO' with 'demo'
             $TransactionIdentifier = str_replace('DEMO', 'demo', $TransactionIdentifier);
             return str($TransactionIdentifier)->squish()->toString();
         }
 
         return null;
     }
 
     #[Computed]
     public function RPH()
     {
         $RPH = $this->selectedDay['ns1OTA_AirAvailRS']['ns1OriginDestinationInformation']['ns1OriginDestinationOptions']['ns1OriginDestinationOption']['ns1FlightSegment']['@attributes']['RPH'] ?? null;
         return $RPH ? str($RPH)->squish()->toString() : null;
     }
 
    #[Computed]
    public function FareBasisCodes()
    {
        // Extract the ns1FareBasisCode array
        $fareBasisCodes = $this->selectedDay['ns1OTA_AirAvailRS']['ns1AAAirAvailRSExt']['ns1PricedItineraries']['ns1PricedItinerary']['ns1AirItineraryPricingInfo']['ns1PTC_FareBreakdowns']['ns1PTC_FareBreakdown']['ns1FareBasisCodes']['ns1FareBasisCode'] ?? [];

        // Get the second element from the array
        $secondFareBasisCode = $fareBasisCodes[1] ?? null;

        // Return the second FareBasisCode or null if it doesn't exist
        return $secondFareBasisCode ? str($secondFareBasisCode)->squish()->toString() : null;
    }

    #[Computed]
    public function TotalFareWithCCFee()
    {  // Extract the total fare with credit card fee element
           $totalFareWithCCFee = $this->selectedDay['ns1OTA_AirAvailRS']['ns1AAAirAvailRSExt']['ns1PricedItineraries']['ns1PricedItinerary']['ns1AirItineraryPricingInfo']['ns1ItinTotalFare']['ns1TotalFareWithCCFee']['@attributes'] ?? [];
   
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
