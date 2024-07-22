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

    public $dataArray = [];
    public $response = null;

    public function mount(): void
    {
        $this->from = 'DAM';
        $this->to = 'SHJ';
    }

    public function submitted()
    {
        $client = new Client([
            'headers' => [
                'Content-Type' => 'application/xml',
            ]
        ]);

        // Prepare the SOAP request body
        $body = '
        <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
            <soap:Header>
                <wsse:Security soap:mustUnderstand="1" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
                    <wsse:UsernameToken wsu:Id="UsernameToken-17855236" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
                        <wsse:Username>WSALHARAMPAY</wsse:Username>
                        <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">1234pass</wsse:Password>
                    </wsse:UsernameToken>
                </wsse:Security>
            </soap:Header>
            <soap:Body xmlns:ns1="http://www.opentravel.org/OTA/2003/05">
                <ns1:OTA_AirAvailRQ EchoToken="11868765275150-1300257933" PrimaryLangID="en-us" SequenceNmbr="1" TimeStamp="' . date('Y-m-d\TH:i:s') . '" Version="20061.00" Target="TEST">
                    <ns1:POS>
                        <ns1:Source TerminalID="TestUser/Test Runner">
                            <ns1:RequestorID ID="WSALHARAMPAY" Type="4"/>
                            <ns1:BookingChannel Type="12"/>
                        </ns1:Source>
                    </ns1:POS>
                    <ns1:OriginDestinationInformation>
                        <ns1:DepartureDateTime WindowAfter="P0D" WindowBefore="P0D">' . $this->selDepartureDate . 'T00:00:00.000</ns1:DepartureDateTime>
                        <ns1:OriginLocation LocationCode="' . $this->from . '"/>
                        <ns1:DestinationLocation LocationCode="' . $this->to . '"/>
                    </ns1:OriginDestinationInformation>';

        if ($this->tripType === 'round-trip') {
            $body .= '
                    <ns1:OriginDestinationInformation>
                        <ns1:DepartureDateTime>' . $this->elReturnDate . 'T00:00:00.000</ns1:DepartureDateTime>
                        <ns1:OriginLocation LocationCode="' . $this->to . '"/>
                        <ns1:DestinationLocation LocationCode="' . $this->from . '"/>
                    </ns1:OriginDestinationInformation>';
        }
        $body .= '
                    <ns1:TravelerInfoSummary>
                        <ns1:AirTravelerAvail>
                            <ns1:PassengerTypeQuantity Code="ADT" Quantity="' . $this->adults . '"/>
                            <ns1:PassengerTypeQuantity Code="CHD" Quantity="' . $this->children . '"/>
                            <ns1:PassengerTypeQuantity Code="INF" Quantity="' . $this->infants . '"/>
                        </ns1:AirTravelerAvail>
                    </ns1:TravelerInfoSummary>
                </ns1:OTA_AirAvailRQ>
            </soap:Body>
        </soap:Envelope>';


        Log::info('SOAP Request: ' . $body);

        try {
            $request = new Request('POST', 'https://6q15.isaaviations.com/webservices/services/AAResWebServices', [], $body);
            $res = $client->sendAsync($request)->wait();

            // Capture and store the response body
            $this->response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", (string) $res->getBody());
            Log::info('SOAP Response: ' . $this->response);
            dd($this->response);
        } catch (\Exception $e) {
            // Log the error for debugging
            $responseBody = $e->getResponse() ? (string) $e->getResponse()->getBody() : 'No response body';
            Log::error('SOAP Request Error: ' . $e->getMessage());
            Log::error('SOAP Request Error Body: ' . $responseBody);
            dd($e->getMessage(), $responseBody);
        }
    }

    #[Computed]
    public function loaded(): bool
    {
        return count($this->dataArray) > 0;
    }

    public function render()
    {
        return view('livewire.search');
    }
}
