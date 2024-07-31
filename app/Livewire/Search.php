<?php

namespace App\Livewire;

use App\FlightResponse;

use GuzzleHttp\Client;
use Livewire\Component;
use App\Models\Credential;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Log;

class Search extends Component
{
    // FORM
    public $tripType;
    public $from;
    public $to;
    public $selDepartureDate;
    public $elReturnDate;
    public $adults = 1;
    public $children = 0;
    public $infants = 0;

    // API CREDENTIALS    
    public $username;
    public $password;

    public $i;


    public function mount(): void
    {
        $this->tripType = 'round-trip';
        $this->from = 'DAM';
        $this->to = 'SHJ';

        $credentials = Credential::find(1);
        $this->username = $credentials->user_name;
        $this->password = $credentials->password;
    }

    public function render()
    {
        return view('livewire.search');
    }

    public function submitted()
    {
        $client = new Client([
            'headers' => [
                'Content-Type' => 'application/xml',
            ]
        ]);

        try {
            $flights = collect();
            for ($this->i = -3; $this->i <= 3; $this->i++) {
                $request = new Request('POST', 'https://6q15.isaaviations.com/webservices/services/AAResWebServices', [], $this->body());
                $response = (string) $client->sendAsync($request)->wait()->getBody();

                $flightResponse = new FlightResponse($response);

                if ($flightResponse->errors()->count()) {
                    continue;
                }

                $flights = $flights->merge($flightResponse->getFlights());
            }

            if ($this->tripType == 'round-trip') {
                list($this->from, $this->to) = array($this->to, $this->from);
                list($this->selDepartureDate, $this->elReturnDate) = array($this->elReturnDate, $this->selDepartureDate);

                for ($this->i = -3; $this->i <= 3; $this->i++) {
                    $request = new Request('POST', 'https://6q15.isaaviations.com/webservices/services/AAResWebServices', [], $this->body());
                    $response = (string) $client->sendAsync($request)->wait()->getBody();

                    $flightResponse = new FlightResponse($response);

                    if ($flightResponse->errors()->count()) {
                        continue;
                    }

                    $flights = $flights->merge($flightResponse->getFlights());
                }

                list($this->from, $this->to) = array($this->to, $this->from);
                list($this->selDepartureDate, $this->elReturnDate) = array($this->elReturnDate, $this->selDepartureDate);
            }

            session()->put('flights', $flights);
            session()->put('tripType', $this->tripType);
            session()->put('from', $this->from);
            session()->put('to', $this->to);
            session()->put('goingDate', $this->selDepartureDate);
            session()->put('returningDate', $this->elReturnDate);

            return redirect()->route('response'); // Make sure to define a route named 'details'
        } catch (\Exception $e) {
            Log::error('SOAP Request Error: ' . $e->getMessage());
        }
    }

    #[Computed]
    public function body(): string
    {
        $departureDate = Carbon::parse($this->selDepartureDate)->addDays($this->i);
        $elReturnDate = Carbon::parse($this->elReturnDate);
        $pd = 'P0D';

        $bodyTemplate = '
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
                            <ns1:DepartureDateTime WindowAfter="' . $pd . '" WindowBefore="' . $pd . '">' . $departureDate->format('Y-m-d\TH:i:s.v') . '</ns1:DepartureDateTime>
                            <ns1:OriginLocation LocationCode="' . $this->from . '"/>
                            <ns1:DestinationLocation LocationCode="' . $this->to . '"/>
                        </ns1:OriginDestinationInformation>
                        <ns1:TravelerInfoSummary>
                            <ns1:AirTravelerAvail>
                                <ns1:PassengerTypeQuantity Code="ADT" Quantity="' . $this->adults . '"/>
                                <ns1:PassengerTypeQuantity Code="CHD" Quantity="' . $this->children . '"/>
                                <ns1:PassengerTypeQuantity Code="INF" Quantity="' . $this->infants . '"/>
                            </ns1:AirTravelerAvail>
                        </ns1:TravelerInfoSummary>
                    </ns1:OTA_AirAvailRQ>
                </soap:Body>
            </soap:Envelope>
        ';

        return str($bodyTemplate);
    }
}
