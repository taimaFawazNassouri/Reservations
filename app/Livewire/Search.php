<?php

namespace App\Livewire;


use SimpleXMLElement;
use GuzzleHttp\Client;
use Livewire\Component;
use App\Models\Credential;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class Search extends Component
{
    public $tripType = 'round-trip';
    public $from;
    public $to;
    public $selDepartureDate;
    public $elReturnDate;
    public $adults = 1;
    public $children = 0;
    public $infants = 0;
    public $flexibleDates;
    public $isDropdownVisible = false;
    public $selectedOption = null;
    public $expandedTaxDetails = [];
    public $expandedFeeDetails = [];
    public $dataArray = [];
    public $response = null;
    public $username;
    public $password;
    public $allResponses = [];

    public function mount(): void
    {
        $this->from = 'DAM';
        $this->to = 'SHJ';
        $credentials = Credential::find(1);
        $this->username = $credentials->user_name;
        $this->password = $credentials->password;
    }

    public function submitted()
    {
        $departureDate = Carbon::parse($this->selDepartureDate);

        // Create an array to hold the different date variations
        $dateVariations = [];

        // Populate the array with the current date, three days before, and three days after
        // for ($i = -3; $i <= 3; $i++) {
        //     $dateVariations[] = $departureDate->clone()->addDays($i);
        // }
        for ($i = -7; $i <= 7; $i++) {
            $dateVariations[] = $departureDate->clone()->addDays($i);
        }

        $client = new Client([
            'headers' => [
                'Content-Type' => 'application/xml',
            ]
        ]);

        // foreach ($dateVariations as $selDepartureDate) {
        //     // Prepare the SOAP request body for each date
        //     $body = '
        //         <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
        //             <soap:Header>
        //                 <wsse:Security soap:mustUnderstand="1" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
        //                     <wsse:UsernameToken wsu:Id="UsernameToken-17855236" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
        //                         <wsse:Username>' . $this->username . '</wsse:Username>
        //                         <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">' . $this->password . '</wsse:Password>
        //                     </wsse:UsernameToken>
        //                 </wsse:Security>
        //             </soap:Header>
        //             <soap:Body xmlns:ns1="http://www.opentravel.org/OTA/2003/05">
        //                 <ns1:OTA_AirAvailRQ EchoToken="11868765275150-1300257933" PrimaryLangID="en-us" SequenceNmbr="1" TimeStamp="' . date('Y-m-d\TH:i:s') . '" Version="20061.00" Target="TEST">
        //                     <ns1:POS>
        //                         <ns1:Source TerminalID="TestUser/Test Runner">
        //                             <ns1:RequestorID ID="' . $this->username . '" Type="4"/>
        //                             <ns1:BookingChannel Type="12"/>
        //                         </ns1:Source>
        //                     </ns1:POS>
        //                     <ns1:OriginDestinationInformation>
        //                         <ns1:DepartureDateTime WindowAfter="P0D" WindowBefore="P0D">' . $selDepartureDate->format('Y-m-d\TH:i:s.v') . '</ns1:DepartureDateTime>
        //                         <ns1:OriginLocation LocationCode="' . $this->from . '"/>
        //                         <ns1:DestinationLocation LocationCode="' . $this->to . '"/>
        //                     </ns1:OriginDestinationInformation>
        //     ';

        //     if ($this->tripType === 'round-trip') {
        //         $body .= '
        //             <ns1:OriginDestinationInformation>
        //                 <ns1:DepartureDateTime>' . $this->elReturnDate . '</ns1:DepartureDateTime>
        //                 <ns1:OriginLocation LocationCode="' . $this->to . '"/>
        //                 <ns1:DestinationLocation LocationCode="' . $this->from . '"/>
        //             </ns1:OriginDestinationInformation>
        //         ';
        //     }

        //     $body .= '
        //                     <ns1:TravelerInfoSummary>
        //                         <ns1:AirTravelerAvail>
        //                             <ns1:PassengerTypeQuantity Code="ADT" Quantity="' . $this->adults . '"/>
        //                             <ns1:PassengerTypeQuantity Code="CHD" Quantity="' . $this->children . '"/>
        //                             <ns1:PassengerTypeQuantity Code="INF" Quantity="' . $this->infants . '"/>
        //                         </ns1:AirTravelerAvail>
        //                     </ns1:TravelerInfoSummary>
        //                 </ns1:OTA_AirAvailRQ>
        //             </soap:Body>
        //         </soap:Envelope>
        //     ';

        //     Log::info('SOAP Request: ' . $body);

        //     try {
        //         $request = new Request('POST', 'https://6q15.isaaviations.com/webservices/services/AAResWebServices', [], $body);
        //         $res = $client->sendAsync($request)->wait();
        //         $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", (string) $res->getBody());
        //         $xml = new SimpleXMLElement($response);
        //         $body = $xml->xpath('//soapBody')[0];
        //         $this->dataArray = json_decode(json_encode((array)$body), TRUE);

        //         // Use dd() to dump the last added element in the array
        //         $this->allResponses[$selDepartureDate->format('Y-m-d')] = $this->dataArray;
        //     } catch (\Exception $e) {
        //         Log::error('SOAP Request Error: ' . $e->getMessage());
        //     }
        // }
        
   
            // Prepare the SOAP request body for each date
        // foreach ($dateVariations as $selDepartureDate) {
            $body = '
                <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
                    <soap:Header>
                        <wsse:Security soap:mustUnderstand="1" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
                            <wsse:UsernameToken wsu:Id="UsernameToken-17855236" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
                                <wsse:Username>' . $this->username . '</wsse:Username>
                                <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">' . $this->password . '</wsse:Password>
                            </wsse:UsernameToken>
                        </wsse:Security>
                    </soap:Header>
                    <soap:Body xmlns:ns1="http://www.opentravel.org/OTA/2003/05">
                        <ns1:OTA_AirAvailRQ EchoToken="11868765275150-1300257933" PrimaryLangID="en-us" SequenceNmbr="1" TimeStamp="' . date('Y-m-d\TH:i:s') . '" Version="20061.00" Target="TEST">
                            <ns1:POS>
                                <ns1:Source TerminalID="TestUser/Test Runner">
                                    <ns1:RequestorID ID="' . $this->username . '" Type="4"/>
                                    <ns1:BookingChannel Type="12"/>
                                </ns1:Source>
                            </ns1:POS>
                            <ns1:OriginDestinationInformation>
                            <ns1:DepartureDateTime WindowAfter="P3D" WindowBefore="P3D">2024-08-20T00:00:00.000</ns1:DepartureDateTime>
                            <ns1:OriginLocation LocationCode="'. $this->to .'"/>
                            <ns1:DestinationLocation LocationCode="'. $this->from .'"/>
                        </ns1:OriginDestinationInformation>
                        <ns1:OriginDestinationInformation>
                            <ns1:DepartureDateTime>2024-08-30T00:00:00.000</ns1:DepartureDateTime>
                            <ns1:OriginLocation LocationCode="'. $this->from .'"/>
                            <ns1:DestinationLocation LocationCode="'. $this->to .'"/>
                        </ns1:OriginDestinationInformation>
                        <ns1:TravelerInfoSummary>
                            <ns1:AirTravelerAvail>
                                <ns1:PassengerTypeQuantity Code="ADT" Quantity="1"/>
                                <ns1:PassengerTypeQuantity Code="CHD" Quantity="0"/>
                                <ns1:PassengerTypeQuantity Code="INF" Quantity="0"/>
                            </ns1:AirTravelerAvail>
                        </ns1:TravelerInfoSummary>
                    </ns1:OTA_AirAvailRQ>
                </soap:Body>
            </soap:Envelope>
            ';

            Log::info('SOAP Request: ' . $body);

            try {
                $request = new Request('POST', 'https://6q15.isaaviations.com/webservices/services/AAResWebServices', [], $body);
                $res = $client->sendAsync($request)->wait();
                $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", (string) $res->getBody());
                $xml = new SimpleXMLElement($response);
                $body = $xml->xpath('//soapBody')[0];
                $this->dataArray = json_decode(json_encode((array)$body), TRUE);

                // Use dd() to dump the last added element in the array
                $this->allResponses[] = $this->dataArray;
            } catch (\Exception $e) {
                Log::error('SOAP Request Error: ' . $e->getMessage());
            }
  
      
             

        
      
        dd($this->allResponses);

        return $this->send();
    }

    public function toggleDropdown()
    {
        $this->isDropdownVisible = !$this->isDropdownVisible;
    }

    #[Computed]
    public function loaded(): bool
    {
        return count($this->dataArray) > 0;
    }

    #[Computed]
    public function DepartureAirport()
    {
        $DepartureAirport = $this->dataArray['ns1OTA_AirAvailRS']['ns1OriginDestinationInformation']['ns1OriginDestinationOptions']['ns1OriginDestinationOption']['ns1FlightSegment']['ns1DepartureAirport']['@attributes']['LocationCode'] ?? null;
        return $DepartureAirport ? str($DepartureAirport)->squish()->toString() : null;
    }

    #[Computed]
    public function ArrivalAirport()
    {
        $ArrivalAirport = $this->dataArray['ns1OTA_AirAvailRS']['ns1OriginDestinationInformation']['ns1OriginDestinationOptions']['ns1OriginDestinationOption']['ns1FlightSegment']['ns1ArrivalAirport']['@attributes']['LocationCode'] ?? null;
        return $ArrivalAirport ? str($ArrivalAirport)->squish()->toString() : null;
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
        $ArrivalDateTime = $this->dataArray['ns1OTA_AirAvailRS']['ns1OriginDestinationInformation']['ns1OriginDestinationOptions']['ns1OriginDestinationOption']['ns1FlightSegment']['@attributes']['ArrivalDateTime'] ?? null;
        return $ArrivalDateTime ? str($ArrivalDateTime)->squish()->toString() : null;
    }

    #[Computed]
    public function FlightNumber()
    {
        $FlightNumber = $this->dataArray['ns1OTA_AirAvailRS']['ns1OriginDestinationInformation']['ns1OriginDestinationOptions']['ns1OriginDestinationOption']['ns1FlightSegment']['@attributes']['FlightNumber'] ?? null;
        return $FlightNumber ? str($FlightNumber)->squish()->toString() : null;
    }

    #[Computed]
    public function JourneyDuration()
    {
        $JourneyDuration = $this->dataArray['ns1OTA_AirAvailRS']['ns1OriginDestinationInformation']['ns1OriginDestinationOptions']['ns1OriginDestinationOption']['ns1FlightSegment']['@attributes']['JourneyDuration'] ?? null;
        return $JourneyDuration ? str($JourneyDuration)->squish()->toString() : null;
    }

    #[Computed]
    public function TransactionIdentifier()
    {
        $TransactionIdentifier = $this->dataArray['ns1OTA_AirAvailRS']['@attributes']['TransactionIdentifier'] ?? null;
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
        $RPH = $this->dataArray['ns1OTA_AirAvailRS']['ns1OriginDestinationInformation']['ns1OriginDestinationOptions']['ns1OriginDestinationOption']['ns1FlightSegment']['@attributes']['RPH'] ?? null;
        return $RPH ? str($RPH)->squish()->toString() : null;
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
    public function FareRuleReference()
    {
        $FareRuleReference = $this->dataArray['ns1OTA_AirAvailRS']['ns1AAAirAvailRSExt']['ns1PricedItineraries']['ns1PricedItinerary']['ns1AirItineraryPricingInfo']['ns1PTC_FareBreakdowns']['ns1PTC_FareBreakdown']['ns1FareInfo']['ns1FareRuleReference'] ?? null;
        return $FareRuleReference ? str($FareRuleReference)->squish()->toString() : null;
    }

    #[Computed]
    public function Basis()
    {
        // Extract the ns1BaseFare array
        $baseFareAttributes = $this->dataArray['ns1OTA_AirAvailRS']['ns1AAAirAvailRSExt']['ns1PricedItineraries']['ns1PricedItinerary']['ns1AirItineraryPricingInfo']['ns1PTC_FareBreakdowns']['ns1PTC_FareBreakdown']['ns1PassengerFare']['ns1BaseFare']['@attributes'] ?? [];

        // Get Amount, CurrencyCode, and DecimalPlaces
        $amount = $baseFareAttributes['Amount'] ?? null;
        $currencyCode = $baseFareAttributes['CurrencyCode'] ?? null;
        $decimalPlaces = $baseFareAttributes['DecimalPlaces'] ?? null;

        // Format the output as a string
        return $amount && $currencyCode
            ? "Amount: {$amount}, CurrencyCode: {$currencyCode}, DecimalPlaces: {$decimalPlaces}"
            : null;
    }

    #[Computed]
    public function taxes()
    {
        // Extract the ns1Taxes array
        $taxes = $this->dataArray['ns1OTA_AirAvailRS']['ns1AAAirAvailRSExt']['ns1PricedItineraries']['ns1PricedItinerary']['ns1AirItineraryPricingInfo']['ns1PTC_FareBreakdowns']['ns1PTC_FareBreakdown']['ns1PassengerFare']['ns1Taxes']['ns1Tax'] ?? [];

        // Check if taxes array is empty and return null if so
        if (empty($taxes)) {
            return null;
        }

        // Prepare to collect formatted tax details
        $taxDetails = [];

        // Iterate over each tax and format the details
        foreach ($taxes as $tax) {
            $attributes = $tax['@attributes'] ?? [];
            $amount = $attributes['Amount'] ?? 'N/A';
            $currencyCode = $attributes['CurrencyCode'] ?? 'N/A';
            $decimalPlaces = $attributes['DecimalPlaces'] ?? 'N/A';
            $taxCode = $attributes['TaxCode'] ?? 'N/A';
            $taxName = $attributes['TaxName'] ?? 'N/A';

            // Add formatted tax information to the array
            $taxDetails[] = "Amount: {$amount}, CurrencyCode: {$currencyCode}, DecimalPlaces: {$decimalPlaces}, TaxCode: {$taxCode}, TaxName: {$taxName}";
        }

        // Return the joined string of all tax details for the current output format
        return $taxDetails;
    }

    #[Computed]
    public function fees()
    {
        // Extract the ns1Taxes array
        $fees = $this->dataArray['ns1OTA_AirAvailRS']['ns1AAAirAvailRSExt']['ns1PricedItineraries']['ns1PricedItinerary']['ns1AirItineraryPricingInfo']['ns1PTC_FareBreakdowns']['ns1PTC_FareBreakdown']['ns1PassengerFare']['ns1Fees']['ns1Fee'] ?? [];

        // Check if taxes array is empty and return null if so
        if (empty($fees)) {
            return null;
        }

        // Prepare to collect formatted tax details
        $feeDetails = [];

        // Iterate over each tax and format the details
        foreach ($feeDetails as $fee) {
            $attributes = $fee['@attributes'] ?? [];
            $amount = $attributes['Amount'] ?? 'N/A';
            $currencyCode = $attributes['CurrencyCode'] ?? 'N/A';
            $decimalPlaces = $attributes['DecimalPlaces'] ?? 'N/A';
            $feeCode = $attributes['FeeCode'] ?? 'N/A';


            // Add formatted tax information to the array
            $feeDetails[] = "Amount: {$amount}, CurrencyCode: {$currencyCode}, DecimalPlaces: {$decimalPlaces}, FeeCode: {$feeCode}";
        }
        // dd($feeDetails);
        // Return the joined string of all tax details for the current output format
        return $feeDetails;
    }

    public function setBasis()
    {
        $this->selectedOption = $this->Basis();
    }

    public function setTaxes()
    {
        $this->selectedOption = $this->taxes(); // Store the option type, not the data itself
    }

    public function setFees()
    {
        $this->selectedOption = $this->fees(); // Store the option type, not the data itself
    }

    public function toggleTaxDetail($index)
    {
        // Initialize the index if not already set
        if (!isset($this->expandedTaxDetails[$index])) {
            $this->expandedTaxDetails[$index] = false;
        }

        // Toggle the visibility of the specific tax detail
        $this->expandedTaxDetails[$index] = !$this->expandedTaxDetails[$index];
    }

    public function toggleFeeDetail($index)
    {
        // Initialize the index if not already set
        if (!isset($this->expandedFeeDetails[$index])) {
            $this->expandedFeeDetails[$index] = false;
        }

        // Toggle the visibility of the specific tax detail
        $this->expandedFeeDetails[$index] = !$this->expandedFeeDetails[$index];
    }

    public function send()
    {
        Session::put('selDepartureDate', $this->selDepartureDate);

        return redirect()->route('response'); // Make sure to define a route named 'details'
    }

    // public function showDetails()
    // {
    //     Session::put('fare_basis_codes', $this->FareBasisCodes);
    //     Session::put('fare_rule_reference', $this->FareRuleReference);
    //     Session::put('DepartureAirport', $this->DepartureAirport);
    //     Session::put('ArrivalAirport', $this->ArrivalAirport);
    //     Session::put('DepartureDateTime', $this->DepartureDateTime);
    //     Session::put('ArrivalDateTime', $this->ArrivalDateTime);
    //     Session::put('FlightNumber', $this->FlightNumber);
    //     Session::put('TotalFareWithCCFee', $this->TotalFareWithCCFee);
    //     Session::put('TotalEquivFareWithCCFee', $this->TotalEquivFareWithCCFee);
    //     Session::put('TransactionIdentifier', $this->TransactionIdentifier);
    //     Session::put('RPH', $this->RPH);

    //     return redirect()->route('details'); // Make sure to define a route named 'details'
    // }

    public function test()
    {
        dd($this->dataArray);
    }

    public function render()
    {
        return view('livewire.search');
    }
}
