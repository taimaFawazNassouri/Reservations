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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class DetailsPassenger extends Component
{
    use WithFileUploads;

    public $title;
    public $first_name;
    public $last_name;
    public $nationality;
    public $date_of_birth;
    public $passport_number;
    public $passport_issued_country;
    public $passport_expiry_date;
    public $city;
    public $country_of_residence;
    public $email;
    public $country_code_phone;
    public $phone;
    public $country_code_travel;
    public $phone_travel;
    public $document_path;


    public $username;
    public $password;


    public $FareBasisCodes;
    public $FareRuleReference;
    public $DepartureAirport;
    public $ArrivalAirport;
    public $DepartureDateTime;
    public $ArrivalDateTime;
    public $FlightNumber;
    public $TotalFareWithCCFee;
    public $TotalEquivFareWithCCFee;
    public $TransactionIdentifier;
    public $RPH;
    public $ticketAdvisoryMessage;

    public $dataArray = [];

    public $goingTrip;
    public $returningTrip;


    public function mount()
    {
        $this->FareBasisCodes = session('fare_basis_codes');
        $this->FareRuleReference = session('fare_rule_reference');
        $this->DepartureAirport = session('DepartureAirport');
        $this->ArrivalAirport = session('ArrivalAirport');
        $this->DepartureDateTime = session('DepartureDateTime');
        $this->ArrivalDateTime = session('ArrivalDateTime');
        $this->FlightNumber = session('FlightNumber');
        $this->TotalFareWithCCFee = session('TotalFareWithCCFee');
        $this->TotalEquivFareWithCCFee = session('TotalEquivFareWithCCFee');
        $this->TransactionIdentifier = session('TransactionIdentifier');
        $this->RPH = session('RPH');

        $flights = session('flights');
        $tripType = session('tripType');
        $from = session('from');
        $to = session('to');
        $goingTrip = session('goingTrip');
        $goingDate = session('goingDate');
        $returningTrip = session('returningTrip');
        $returningDate = session('returningDate');

        $this->goingTrip = $flights
            ->where('Path',  $from . '/' . $to)
            ->where('FlightNumber', $goingTrip)
            ->where('DepartureDate', $goingDate)
            ->first();

        if ($tripType == 'round-trip') {
            $this->returningTrip = $flights
                ->where('Path',  $to . '/' . $from)
                ->where('FlightNumber', $returningTrip)
                ->where('DepartureDate', $returningDate)
                ->first();
        }

        //dd($this->goingTrip);


        $credentials = Credential::find(1);
        $this->username = $credentials->user_name;
        $this->password = $credentials->password;
    }



    public function submitDetails()
    {
        $totalFareWithCCFeeString = $this->goingTrip->TotalFareWithCCFee;


        $amount = '0.00';
        $currencyCode = '';

        if (!empty($totalFareWithCCFeeString)) {
            $parts = explode(' ', $totalFareWithCCFeeString);

            // Check if we have at least two parts after splitting
            if (count($parts) >= 2) {
                $amount = $parts[0];
                $currencyCode = $parts[1];
            } else {
                // Log a warning if the string format is not as expected
                Log::warning('Unexpected format for TotalFareWithCCFee: ' . $totalFareWithCCFeeString);
            }
        } else {
            Log::warning('TotalFareWithCCFee returned an empty or null string.');
        }
        $totalFare = number_format((float)$amount, 2, '.', '');

        $documentPath = $this->document_path ? $this->document_path->store('documents') : null;

        $countryCodeTravel = ltrim($this->country_code_travel, '+');
        $countryCodePhone = ltrim($this->country_code_phone, '+');
        $validator = Validator::make([
            'phone_travel' => $this->phone_travel,
            'phone' => $this->phone,
        ], [
            'phone_travel' => ['required', 'max:10',  'not_regex:/^0/'],
            'phone' => ['required', 'max:10',  'not_regex:/^0/'],
        ]);

        if ($validator->fails()) {
            // Handle validation failure (e.g., return an error response or throw an exception)
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $passengerDetails = PassengerDetail::create([
            'title' => $this->title,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'nationality' => strtoupper(substr($this->nationality, 0, 2)),
            'date_of_birth' => $this->date_of_birth,
            'passport_number' => $this->passport_number,
            'passport_issued_country' => substr($this->passport_issued_country, 0, 2),
            'passport_expiry_date' => $this->passport_expiry_date,
            'city' => strtoupper(substr($this->city, 0, 2)),
            'country_of_residence' => strtoupper(substr($this->country_of_residence, 0, 2)),
            'email' => $this->email,
            'country_code_phone' => $this->country_code_phone,
            'phone' => $this->phone,
            'country_code_travel' => $this->country_code_travel,
            'phone_travel' => $this->phone_travel,
            'document_path' => $documentPath,

        ]);
        $nationality1 = $passengerDetails->nationality;
        $title1 = $passengerDetails->title;
        $first_name1 = $passengerDetails->first_name;
        $last_name1 = $passengerDetails->last_name;
        $date_of_birth1 = $passengerDetails->date_of_birth;
        $email1 = $passengerDetails->email;
        $city1 = $passengerDetails->city;
        $country_of_residence1 = $passengerDetails->country_of_residence;
        $country_code_phone1 = $passengerDetails->country_code_phone;
        $country_code_travel1 = $passengerDetails->country_code_travel;
        $phone1 = $passengerDetails->phone;
        $phone_travel1 = $passengerDetails->phone_travel;



        $client = new Client([
            'headers' => [
                'Content-Type' => 'application/xml',
            ]
        ]);

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
        <soap:Body xmlns:ns1="http://www.isaaviation.com/thinair/webservices/OTA/Extensions/2003/05" xmlns:ns2="http://www.opentravel.org/OTA/2003/05">
            <ns2:OTA_AirBookRQ EchoToken="11868765275150-1300257933" PrimaryLangID="en-us" SequenceNmbr="1" TimeStamp="2008-08-25T16:15:59" TransactionIdentifier="' . $this->goingTrip->TransactionIdentifier . '" Version="20061.00">
                <ns2:POS>
                    <ns2:Source TerminalID="TestUser/Test Runner">
                        <ns2:RequestorID ID="' . $this->username . '" Type="4" />
                        <ns2:BookingChannel Type="12" />
                    </ns2:Source>
                </ns2:POS>
                <ns2:AirItinerary>
                    <ns2:OriginDestinationOptions>
                        <ns2:OriginDestinationOption>
                            <ns2:FlightSegment ArrivalDateTime="' . $this->goingTrip->ArrivalDateTime . '"
                                               DepartureDateTime="' . $this->goingTrip->DepartureDateTime . '"
                                               FlightNumber="' . $this->goingTrip->FlightNumber . '"
                                               RPH="' . $this->goingTrip->RPH . '"
                                               returnFlag="false">
                                <ns2:DepartureAirport LocationCode="' . $this->goingTrip->DepartureAirport . '"/>
                                <ns2:ArrivalAirport LocationCode="' . $this->goingTrip->ArrivalAirport . '"/>
                                <ns2:OperatingAirline Code="6Q"/>
                            </ns2:FlightSegment>
                        </ns2:OriginDestinationOption>
                    </ns2:OriginDestinationOptions>
                </ns2:AirItinerary>
                <ns2:TravelerInfo>
                    <ns2:AirTraveler BirthDate="' . $date_of_birth1 . '" PassengerTypeCode="ADT">
                        <ns2:PersonName>
                            <ns2:GivenName> ' . $first_name1 . '</ns2:GivenName>
                            <ns2:Surname>' . $last_name1 . '</ns2:Surname>
                            <ns2:NameTitle>' . $title1 . '</ns2:NameTitle>
                        </ns2:PersonName>
                        <ns2:Telephone AreaCityCode="' . $city1 . '" CountryAccessCode="' . $country_code_phone1 . '" PhoneNumber="' . $phone1 . '" />
                        <ns2:Address>
                            <ns2:CountryName Code="' . $country_of_residence1 . '" />
                        </ns2:Address>
                        <ns2:Document DocHolderNationality="' . $nationality1 . '" />
                        <ns2:TravelerRefNumber RPH="A1" />
                    </ns2:AirTraveler>
                    <ns2:SpecialReqDetails>
                        <ns2:SSRRequests>
                        </ns2:SSRRequests>
                    </ns2:SpecialReqDetails>
                </ns2:TravelerInfo>
                <ns2:Fulfillment>
                    <ns2:PaymentDetails>
                        <ns2:PaymentDetail>
                            <ns2:DirectBill>
                                <ns2:CompanyName Code="DAM175" />
                            </ns2:DirectBill>
                            <ns2:PaymentAmount Amount="' . $totalFare . '" CurrencyCode="USD" DecimalPlaces="2" />
                        </ns2:PaymentDetail>
                    </ns2:PaymentDetails>
                </ns2:Fulfillment>
            </ns2:OTA_AirBookRQ>
            <ns1:AAAirBookRQExt>
                <ns1:ContactInfo>
                    <ns1:PersonName>
                        <ns1:Title>' . $title1 . '</ns1:Title>
                        <ns1:FirstName>' . $first_name1 . '</ns1:FirstName>
                        <ns1:LastName>' . $last_name1 . '</ns1:LastName>
                    </ns1:PersonName>
                    <ns1:Telephone>
                        <ns1:PhoneNumber>"' . $phone1 . '"</ns1:PhoneNumber>
                        <ns1:CountryCode>' . $country_of_residence1 . '</ns1:CountryCode>
                        <ns1:AreaCode>' . $city1 . '</ns1:AreaCode>
                    </ns1:Telephone>
                    <ns1:Mobile>
                        <ns1:PhoneNumber>"' . $phone1 . '"</ns1:PhoneNumber>
                        <ns1:CountryCode>' . $country_of_residence1 . '</ns1:CountryCode>
                        <ns1:AreaCode>' . $city1 . '</ns1:AreaCode>
                    </ns1:Mobile>
                    <ns1:Email>' . $email1 . '</ns1:Email>
                    <ns1:Address>
                        <ns1:CountryName>
                            <ns1:CountryName>' . $country_of_residence1 . '</ns1:CountryName>
                            <ns1:CountryCode>' . $country_of_residence1 . '</ns1:CountryCode>
                        </ns1:CountryName>
                        <ns1:CityName>' . $city1 . '</ns1:CityName>
                    </ns1:Address>
                </ns1:ContactInfo>
            </ns1:AAAirBookRQExt>
        </soap:Body>
    </soap:Envelope>';

      
        $request = new Request('POST', 'https://6q15.isaaviations.com/webservices/services/AAResWebServices', [], $body);
        $res = $client->sendAsync($request)->wait();
        $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", (string) $res->getBody());
        $xml = new SimpleXMLElement($response);
        $body = $xml->xpath('//soapBody')[0];
        $this->dataArray = json_decode(json_encode((array)$body), TRUE);
        //dd( $this->dataArray);
        // try {
        //     $request = new Request('POST', 'https://6q15.isaaviations.com/webservices/services/AAResWebServices', [], $body);
        //     $res = $client->sendAsync($request)->wait();

        //     // Capture and store the response body
        //     $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", (string) $res->getBody());
        //     Log::info('SOAP Response: ' . $response);
        //     dd($response);
        // } catch (\Exception $e) {
        //     // Log the error for debugging
        //     $responseBody = $e->getResponse() ? (string) $e->getResponse()->getBody() : 'No response body';
        //     Log::error('SOAP Request Error: ' . $e->getMessage());
        //     Log::error('SOAP Request Error Body: ' . $responseBody);
        //     dd($e->getMessage(), $responseBody);
        // }



    }
    #[Computed]
    public function ticketAdvisory()
    {
        $ticket_advisory = $this->dataArray['ns1OTA_AirBookRS']['ns1AirReservation']['ns1Ticketing']['ns1TicketAdvisory'] ?? null;
        $documentPath = $this->document_path ? $this->document_path->store('documents') : null;

        $passengerData = [
            'title' => $this->title,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'nationality' => strtoupper(substr($this->nationality, 0, 2)),
            'date_of_birth' => $this->date_of_birth,
            'passport_number' => $this->passport_number,
            'passport_issued_country' => substr($this->passport_issued_country, 0, 2),
            'passport_expiry_date' => $this->passport_expiry_date,
            'city' => strtoupper(substr($this->city, 0, 2)),
            'country_of_residence' => strtoupper(substr($this->country_of_residence, 0, 2)),
            'email' => $this->email,
            'country_code_phone' => $this->country_code_phone,
            'phone' => $this->phone,
            'country_code_travel' => $this->country_code_travel,
            'phone_travel' => $this->phone_travel,
            'document_path' => $documentPath,
        ];
    
        if ($ticket_advisory) {
            if (str($ticket_advisory)->contains('Reservation is fully paid and confirmed')) {
                // Store in the details_passenger_confirm table
                \DB::table('detail_passenger_confirms')->insert($passengerData);
    
                 $this->ticketAdvisoryMessage = "Your ticket has been confirmed successfully. 
                        Details:
                        - Flight Number: {$this->goingTrip->FlightNumber}
                        - Departure: {$this->goingTrip->DepartureDateTime} from {$this->goingTrip->DepartureAirport}
                        - Arrival: {$this->goingTrip->ArrivalDateTime} at {$this->goingTrip->ArrivalAirport}";
                return;
            }
             // Store in the details_passenger_unconfirm table if not confirmed
            \DB::table('detail_passenger_unconfirms')->insert($passengerData);
    
             return "Your ticket could not be confirmed at this time.";
        }
    
       
    }
    public function render()
    {
        return view('livewire.details-passenger');
    }
}
