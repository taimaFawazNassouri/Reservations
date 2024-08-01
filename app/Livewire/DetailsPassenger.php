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
    public $documentPath;

    public $username;
    public $password;

    public $dataArray = [];
    public $ticketAdvisoryMessage;

    public $goingTrip;
    public $returningTrip;

    public function mount()
    {
        $this->title = fake()->randomElement(['MR', 'MS', 'MRS', 'DR']);
        $this->first_name = fake()->name();
        $this->last_name = fake()->lastName();
        $this->nationality = 'Canada';
        $this->date_of_birth = fake()->date(max: '-18 years');
        $this->passport_number = fake()->randomNumber(9, true);
        $this->passport_issued_country = 'Canada';
        $this->passport_expiry_date = '2029-09-20';
        $this->city = fake()->city();
        $this->country_of_residence = 'Canada';
        $this->email = fake()->email();
        $this->country_code_phone = '+1';
        $this->phone = str(fake()->phoneNumber())->swap([
            '-' => '',
            ' ' => '',
            '+' => '',
            '.' => '',
            '(' => '',
            ')' => '',
        ])->take(10);
        $this->country_code_travel =  $this->country_code_phone;
        $this->phone_travel =  $this->phone;

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

        $credentials = Credential::find(1);
        $this->username = $credentials->user_name;
        $this->password = $credentials->password;
    }

    public function render()
    {
        return view('livewire.details-passenger');
    }

    public function submitDetails()
    {
        $totalFareWithCCFeeString = $this->goingTrip->TotalFareWithCCFee;
        $amount = str($totalFareWithCCFeeString)->before(' ');
        $currencyCode = str($totalFareWithCCFeeString)->after(' ');

        $this->documentPath = $this->document_path ? $this->document_path->store('documents') : null;

        $this->validate([
            'phone_travel' => ['required', 'max:10'],
            'phone' => ['required', 'max:10'],
        ]);

        $passengerDetails = PassengerDetail::create($this->passengerData);

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
                            <ns2:AirTraveler BirthDate="' . $passengerDetails->date_of_birth . '" PassengerTypeCode="ADT">
                                <ns2:PersonName>
                                    <ns2:GivenName> ' . $passengerDetails->first_name . '</ns2:GivenName>
                                    <ns2:Surname>' . $passengerDetails->last_name . '</ns2:Surname>
                                    <ns2:NameTitle>' . $passengerDetails->title . '</ns2:NameTitle>
                                </ns2:PersonName>
                                <ns2:Telephone AreaCityCode="' . $passengerDetails->city . '" CountryAccessCode="' . $passengerDetails->country_code_phone . '" PhoneNumber="' . $passengerDetails->phone . '" />
                                <ns2:Address>
                                    <ns2:CountryName Code="' . $passengerDetails->country_of_residence . '" />
                                </ns2:Address>
                                <ns2:Document DocHolderNationality="' . $passengerDetails->nationality . '" />
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
                                    <ns2:PaymentAmount Amount="' . $amount->toString() . '" CurrencyCode="' . $currencyCode->toString() . '" DecimalPlaces="2" />
                                </ns2:PaymentDetail>
                            </ns2:PaymentDetails>
                        </ns2:Fulfillment>
                    </ns2:OTA_AirBookRQ>
                    <ns1:AAAirBookRQExt>
                        <ns1:ContactInfo>
                            <ns1:PersonName>
                                <ns1:Title>' . $passengerDetails->title . '</ns1:Title>
                                <ns1:FirstName>' . $passengerDetails->first_name . '</ns1:FirstName>
                                <ns1:LastName>' . $passengerDetails->last_name . '</ns1:LastName>
                            </ns1:PersonName>
                            <ns1:Telephone>
                                <ns1:PhoneNumber>"' . $passengerDetails->phone . '"</ns1:PhoneNumber>
                                <ns1:CountryCode>' . $passengerDetails->country_of_residence . '</ns1:CountryCode>
                                <ns1:AreaCode>' . $passengerDetails->city . '</ns1:AreaCode>
                            </ns1:Telephone>
                            <ns1:Mobile>
                                <ns1:PhoneNumber>"' . $passengerDetails->phone . '"</ns1:PhoneNumber>
                                <ns1:CountryCode>' . $passengerDetails->country_of_residence . '</ns1:CountryCode>
                                <ns1:AreaCode>' . $passengerDetails->city . '</ns1:AreaCode>
                            </ns1:Mobile>
                            <ns1:Email>' . $passengerDetails->email . '</ns1:Email>
                            <ns1:Address>
                                <ns1:CountryName>
                                    <ns1:CountryName>' . $passengerDetails->country_of_residence . '</ns1:CountryName>
                                    <ns1:CountryCode>' . $passengerDetails->country_of_residence . '</ns1:CountryCode>
                                </ns1:CountryName>
                                <ns1:CityName>' . $passengerDetails->city . '</ns1:CityName>
                            </ns1:Address>
                        </ns1:ContactInfo>
                    </ns1:AAAirBookRQExt>
                </soap:Body>
            </soap:Envelope>
        ';

        $request = new Request('POST', 'https://6q15.isaaviations.com/webservices/services/AAResWebServices', [], $body);
        $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", (string) $client->sendAsync($request)->wait()->getBody());

        $xml = new SimpleXMLElement($response);
        $body = $xml->xpath('//soapBody')[0];
        $this->dataArray = json_decode(json_encode((array)$body), TRUE);

        if ($this->ticket_advisory) {
            if (!str($this->ticket_advisory)->contains('Reservation is fully paid and confirmed')) {
                // Store in the details_passenger_unconfirm table if not confirmed
                DB::table('detail_passenger_unconfirms')->insert($this->passengerData);
                return;
            } else {
                // Store in the details_passenger_confirm table
                DB::table('detail_passenger_confirms')->insert($this->passengerData);

                $this->ticketAdvisoryMessage = "Your ticket has been confirmed successfully. 
                        Details:
                        - Flight Number: {$this->goingTrip->FlightNumber}
                        - Departure: {$this->goingTrip->DepartureDateTime} from {$this->goingTrip->DepartureAirport}
                        - Arrival: {$this->goingTrip->ArrivalDateTime} at {$this->goingTrip->ArrivalAirport}";
                return;
            }
        }

        dd($this->dataArray);
    }

    #[Computed]
    public function ticketAdvisory(): ?string
    {
        return $this->dataArray['ns1OTA_AirBookRS']['ns1AirReservation']['ns1Ticketing']['ns1TicketAdvisory'] ?? null;
    }

    #[Computed]
    public function passengerData()
    {
        return [
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
            'document_path' => $this->documentPath,
        ];
    }
}
