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


    protected $FareBasisCodes;
    protected $FareRuleReference;
    protected $DepartureAirport;
    protected $ArrivalAirport;
    protected $DepartureDateTime;
    protected $ArrivalDateTime;
    protected $FlightNumber;
    protected $TotalFareWithCCFee;
    protected $TotalEquivFareWithCCFee;
    protected $TransactionIdentifier;
    protected $RPH;
    
    public $dataArray = [];


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


        $credentials = Credential::find(1);
        $this->username = $credentials->user_name;
        $this->password = $credentials->password;
    }



    public function submitDetails()
    {
        $totalFareWithCCFeeString = $this->TotalFareWithCCFee;


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
            \Log::warning('Unexpected format for TotalFareWithCCFee: ' . $totalFareWithCCFeeString);
        }
        } else {
            \Log::warning('TotalFareWithCCFee returned an empty or null string.');
        }
        $totalFare = number_format((float)$amount, 2, '.', '');

        $documentPath = $this->document_path ? $this->document_path->store('documents') : null;

        PassengerDetail::create([
            'title' => $this->title,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'nationality' => $this->nationality,
            'date_of_birth' => $this->date_of_birth,
            'passport_number' => $this->passport_number,
            'passport_issued_country' => substr($this->passport_issued_country, 0, 2),
            'passport_expiry_date' => $this->passport_expiry_date,
            'city' => $this->city,
            'country_of_residence' => substr($this->country_of_residence, 0, 2),
            'email' => $this->email,
            'country_code_phone' => $this->country_code_phone,
            'phone' => $this->phone,
            'country_code_travel' => $this->country_code_travel,
            'phone_travel' => $this->phone_travel,
            'document_path' => $documentPath, 

        ]);
        $client = new Client([
            'headers' => [
                'Content-Type' => 'application/xml',
            ]
        ]);
 
        $body ='
        <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
            <soap:Header>
                <wsse:Security soap:mustUnderstand="1" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
                    <wsse:UsernameToken wsu:Id="UsernameToken-17855236" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
                        <wsse:Username>' . $this->username .'</wsse:Username>
                        <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">' . $this->password .'</wsse:Password>
                    </wsse:UsernameToken>
                </wsse:Security>
            </soap:Header>
            <soap:Body xmlns:ns1="http://www.isaaviation.com/thinair/webservices/OTA/Extensions/2003/05" xmlns:ns2="http://www.opentravel.org/OTA/2003/05">
                <ns2:OTA_AirBookRQ EchoToken="11868765275150-1300257933" PrimaryLangID="en-us" SequenceNmbr="1" TimeStamp="2008-08-25T16:15:59" TransactionIdentifier="'. $this->TransactionIdentifier .'" Version="20061.00">
                    <ns2:POS>
                        <ns2:Source TerminalID="TestUser/Test Runner">
                            <ns2:RequestorID ID="' . $this->username .'" Type="4" />
                            <ns2:BookingChannel Type="12" />
                        </ns2:Source>
                    </ns2:POS>
                    <ns2:AirItinerary>
                        <ns2:OriginDestinationOptions>
                            <ns2:OriginDestinationOption>
                                <ns2:FlightSegment ArrivalDateTime="' . $this->ArrivalDateTime .'"
                                    DepartureDateTime="'. $this->DepartureDateTime .'"
                                    FlightNumber="'. $this->FlightNumber .'"
                                    RPH="'. $this->RPH .'"
                                    returnFlag="false">
                                    <ns2:DepartureAirport LocationCode="'. $this->DepartureAirport .'"/>
                                    <ns2:ArrivalAirport LocationCode="'. $this->ArrivalAirport .'"/>
                                    <ns2:OperatingAirline Code="6Q"/>
                                </ns2:FlightSegment>
                            </ns2:OriginDestinationOption>
                            <ns2:OriginDestinationOption>
                                <ns2:FlightSegment ArrivalDateTime="'. $this->ArrivalDateTime .'"
                                        DepartureDateTime="'. $this->DepartureDateTime .'"
                                        FlightNumber="'. $this->FlightNumber .'"
                                        RPH="'. $this->RPH .'"
                                        returnFlag="false">
                                    <ns2:DepartureAirport LocationCode="'. $this->DepartureAirport .'"/>
                                    <ns2:ArrivalAirport LocationCode="'. $this->ArrivalAirport .'"/>
                                    <ns2:OperatingAirline Code="6Q"/>
                                </ns2:FlightSegment>
                            </ns2:OriginDestinationOption>
                        </ns2:OriginDestinationOptions>
                    </ns2:AirItinerary>
                    <ns2:TravelerInfo>
                        <ns2:AirTraveler BirthDate="'. $this->date_of_birth .'" PassengerTypeCode="ADT">
                            <ns2:PersonName>
                               <ns2:GivenName>'. $this->first_name .' </ns2:GivenName>
                               <ns2:Surname>'. $this->last_name .'</ns2:Surname>
                               <ns2:NameTitle>'. $this->title .'</ns2:NameTitle>
                            </ns2:PersonName>
                            <ns2:Telephone AreaCityCode="'. $this->city .'" CountryAccessCode="'. $this->country_code_phone .'" PhoneNumber="'. $this->phone .'" />
                            <ns2:Address>
                                <ns2:CountryName Code="'. $this->country_of_residence .'" />
                            </ns2:Address>
                            <ns2:Document DocHolderNationality="'. $this->nationality .'" />
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
                                <ns2:PaymentAmount Amount="'. $totalFare .'" CurrencyCode="USD" DecimalPlaces="2" />
                            </ns2:PaymentDetail>
                        </ns2:PaymentDetails>
                    </ns2:Fulfillment>
                </ns2:OTA_AirBookRQ>
                <ns1:AAAirBookRQExt>
                    <ns1:ContactInfo>
                        <ns1:PersonName>
                            <ns1:Title>'. $this->title .'</ns1:Title>
                            <ns1:FirstName> '. $this->first_name .' </ns1:FirstName>
                            <ns1:LastName>'. $this->last_name .'</ns1:LastName>
                        </ns1:PersonName>
                        <ns1:Telephone>
                            <ns1:PhoneNumber>"'. $this->phone .'"</ns1:PhoneNumber>
                            <ns1:CountryCode>'. $this->country_of_residence .'</ns1:CountryCode>
                            <ns1:AreaCode>'. $this->country_of_residence .'</ns1:AreaCode>
                        </ns1:Telephone>
                        <ns1:Mobile>
                            <ns1:PhoneNumber>"'. $this->phone_travel.'"</ns1:PhoneNumber>
                            <ns1:CountryCode>'. $this->country_of_residence .'</ns1:CountryCode>
                            <ns1:AreaCode>'. $this->country_of_residence .'</ns1:AreaCode>
                        </ns1:Mobile>
                        <ns1:Email>'. $this->email .'</ns1:Email>
                        <ns1:Address>
                            <ns1:CountryName>
                                <ns1:CountryName>'. $this->country_of_residence .'</ns1:CountryName>
                                <ns1:CountryCode>'. $this->country_of_residence .'</ns1:CountryCode>
                            </ns1:CountryName>
                            <ns1:CityName>'. $this->city .'</ns1:CityName>
                        </ns1:Address>
                    </ns1:ContactInfo>
                </ns1:AAAirBookRQExt>
            </soap:Body>
        </soap:Envelope>';
        // try {
        //     $request = new Request('POST', 'https://6q15.isaaviations.com/webservices/services/AAResWebServices', [], $body);
        //     $res = $client->sendAsync($request)->wait();
            
        //     // Capture and store the response body
        //     $this->response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", (string) $res->getBody());
        //     \Log::info('SOAP Response: ' . $this->response);
        //     dd($this->response);
        // } catch (\Exception $e) {
        //     // Log the error for debugging
        //     $responseBody = $e->getResponse() ? (string) $e->getResponse()->getBody() : 'No response body';
        //     \Log::error('SOAP Request Error: ' . $e->getMessage());
        //     \Log::error('SOAP Request Error Body: ' . $responseBody);
        //     dd($e->getMessage(), $responseBody);
        // }
        $request = new Request('POST', 'https://6q15.isaaviations.com/webservices/services/AAResWebServices', [], $body);
        $res = $client->sendAsync($request)->wait();
        $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", (string) $res->getBody());
        $xml = new SimpleXMLElement($response);
        $body = $xml->xpath('//soapBody')[0];
        $this->dataArray = json_decode(json_encode((array)$body), TRUE);
        dd( $this->dataArray);


        
    }
    public function render()
    {
        return view('livewire.details-passenger');
    }
}
