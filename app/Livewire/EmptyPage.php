<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use App\Models\Reservation;
use App\Models\Credential;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Livewire\Attributes\Computed;

class EmptyPage extends Component
{
    public $reservation_number;
    public $username;
    public $password;
    public $response = null;
    public $dataArray = [];


    public function mount()
    {
        $credentials = Credential::find(1);
        $this->username = $credentials->user_name;
        $this->password = $credentials->password;
    } 

    public function render()
    {
        return view('livewire.empty-page');
    }

    // public function submitted()
    // {
    //     $url = 'https://6q15.isaaviations.com/webservices/services/AAResWebServices';
    //     $username = $this->username;
    //     $password = $this->password;
    //     $data = '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
    //         <soap:Header>
    //             <wsse:Security soap:mustUnderstand="1" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
    //                 <wsse:UsernameToken wsu:Id="UsernameToken-17099451" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
    //                     <wsse:Username>' . $this->username . '</wsse:Username>
    //                     <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">' . $this->password . '</wsse:Password>
    //                 </wsse:UsernameToken>
    //             </wsse:Security>
    //         </soap:Header>
    //         <soap:Body xmlns:ns1="http://www.isaaviation.com/thinair/webservices/OTA/Extensions/2003/05" xmlns:ns2="http://www.opentravel.org/OTA/2003/05">
    //             <ns2:OTA_ReadRQ EchoToken="11839640750780-171674061" PrimaryLangID="en-us" SequenceNmbr="1" TimeStamp="2023-02-28T20:00:00" Version="20061.00">
    //                 <ns2:POS>
    //                     <ns2:Source TerminalID="TestUser/Test Runner">
    //                         <ns2:RequestorID ID="' .$this->username. '" Type="4"/>
    //                         <ns2:BookingChannel Type="12"/>
    //                     </ns2:Source>
    //                 </ns2:POS>
    //                 <ns2:ReadRequests>
    //                     <ns2:ReadRequest>
    //                         <ns2:UniqueID ID="' . $this->reservation_number . '" Type="14"/>
    //                     </ns2:ReadRequest>
    //                     <ns2:AirReadRequest>
    //                         <ns2:DepartureDate>2023-10-12</ns2:DepartureDate>
    //                     </ns2:AirReadRequest>
    //                 </ns2:ReadRequests>
    //             </ns2:OTA_ReadRQ>
    //             <ns1:AAReadRQExt>
    //                 <ns1:AALoadDataOptions>
    //                     <ns1:LoadTravelerInfo>true</ns1:LoadTravelerInfo>
    //                     <ns1:LoadAirItinery>true</ns1:LoadAirItinery>
    //                     <ns1:LoadPriceInfoTotals>true</ns1:LoadPriceInfoTotals>
    //                     <ns1:LoadFullFilment>true</ns1:LoadFullFilment>
    //                 </ns1:AALoadDataOptions>
    //             </ns1:AAReadRQExt>
    //         </soap:Body>
    //     </soap:Envelope>';

    //     // dd(htmlentities($data));

    //     $req = Http::withHeaders([
    //         'Content-Type' => 'application/xml',
    //     ])->post($url, htmlentities($data));
    
    //     dd($req->body());
    // }

    public function submitted()
    {
        $user = Auth::user();
        $reservations = new Reservation();
        $reservations->number_reservation = $this->reservation_number;
        $reservations->user_id = $user->id;
        $reservations->save();
        
        $client = new Client([
            'headers' => [
                'Content-Type' => 'application/xml',
            ]
        ]);
        $body = '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
            <soap:Header>
                <wsse:Security soap:mustUnderstand="1" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
                    <wsse:UsernameToken wsu:Id="UsernameToken-17099451" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
                        <wsse:Username>'. $this->username .'</wsse:Username>
                        <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">'. $this->password .'</wsse:Password>
                    </wsse:UsernameToken>
                </wsse:Security>
            </soap:Header>
            <soap:Body xmlns:ns1="http://www.isaaviation.com/thinair/webservices/OTA/Extensions/2003/05" xmlns:ns2="http://www.opentravel.org/OTA/2003/05">
                <ns2:OTA_ReadRQ EchoToken="11839640750780-171674061" PrimaryLangID="en-us" SequenceNmbr="1" TimeStamp="2023-02-28T20:00:00" Version="20061.00">
                    <ns2:POS>
                        <ns2:Source TerminalID="TestUser/Test Runner">
                            <ns2:RequestorID ID="'. $this->username .'" Type="4"/>
                            <ns2:BookingChannel Type="12"/>
                        </ns2:Source>
                    </ns2:POS>
                    <ns2:ReadRequests>
                        <ns2:ReadRequest>
                            <ns2:UniqueID ID="'. $this->reservation_number .'" Type="14"/>
                        </ns2:ReadRequest>
                        <ns2:AirReadRequest>
                            <ns2:DepartureDate>2023-10-12</ns2:DepartureDate>
                        </ns2:AirReadRequest>
                    </ns2:ReadRequests>
                </ns2:OTA_ReadRQ>
                <ns1:AAReadRQExt>
                    <ns1:AALoadDataOptions>
                        <ns1:LoadTravelerInfo>true</ns1:LoadTravelerInfo>
                        <ns1:LoadAirItinery>true</ns1:LoadAirItinery>
                        <ns1:LoadPriceInfoTotals>true</ns1:LoadPriceInfoTotals>
                        <ns1:LoadFullFilment>true</ns1:LoadFullFilment>
                    </ns1:AALoadDataOptions>
                </ns1:AAReadRQExt>
            </soap:Body>
        </soap:Envelope>
        ';
        $request = new Request('POST', 'https://6q15.isaaviations.com/webservices/services/AAResWebServicesForPay', [], $body);
        $res = $client->sendAsync($request)->wait();

        $this->response = (string) $res->getBody();
        
        // $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", (string) $res->getBody());
        // $xml = new SimpleXMLElement($response);
        // $body = $xml->xpath('//soapBody')[0];
        // $this->dataArray = json_decode(json_encode((array)$body), TRUE);
    }

    

    #[Computed]
    public function loaded(): bool
    {
        return count($this->dataArray) > 0 ;
    }

    #[Computed]
    public function first_name()
    {
        $first_name = $this->dataArray['ns1OTA_AirBookRS']['ns1AirReservation']['ns1TravelerInfo']['ns1AirTraveler'][0]['ns1PersonName']['ns1GivenName'] ?? null;
        return $first_name ? str($first_name)->squish()->toString() : null;
    }
}
