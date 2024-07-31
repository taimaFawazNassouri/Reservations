<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Livewire\Wireable;

class Flight extends FlightPrice implements Arrayable, Wireable
{
    public $TransactionIdentifier;

    // ['ns1OTA_AirAvailRS']['ns1AAAirAvailRSExt']['ns1PricedItineraries']['ns1PricedItinerary']['ns1AirItineraryPricingInfo']['ns1ItinTotalFare']
    private $priceData;
    private $Price;

    // ['ns1OTA_AirAvailRS']['ns1OriginDestinationInformation'][#each]['ns1OriginDestinationOptions']['ns1OriginDestinationOption']['ns1FlightSegment']
    private $data;

    public $ArrivalDateTime;
    public $DepartureDateTime;
    public $FlightNumber;
    public $JourneyDuration;
    public $RPH;
    public $SmokingAllowed;
    public $returnFlag;
    public $DepartureAirport;
    public $ArrivalAirport;

    public $Path;
    public $DepartureDate;

    public function __construct(array $data = [], ?array $priceData = [], $TransactionIdentifier = null)
    {
        $this->TransactionIdentifier = $TransactionIdentifier;

        $this->priceData = $priceData;
        $this->Price = new FlightPrice($priceData);

        foreach ($this->Price as $property => $value) {
            $this->{$property} = $value;
        }

        $this->data = $data;
        $this->ArrivalDateTime = $data['@attributes']['ArrivalDateTime'] ?? null;
        $this->DepartureDateTime = $data['@attributes']['DepartureDateTime'] ?? null;
        $this->FlightNumber = $data['@attributes']['FlightNumber'] ?? null;
        $this->JourneyDuration = $data['@attributes']['JourneyDuration'] ?? null;
        $this->RPH = $data['@attributes']['RPH'] ?? null;
        $this->SmokingAllowed = isset($data['@attributes']['SmokingAllowed']) ? filter_var($data['@attributes']['SmokingAllowed'], FILTER_VALIDATE_BOOLEAN) : null;
        $this->returnFlag = isset($data['@attributes']['returnFlag']) ? filter_var($data['@attributes']['returnFlag'], FILTER_VALIDATE_BOOLEAN) : null;
        $this->DepartureAirport = $data['ns1DepartureAirport']['@attributes']['LocationCode'] ?? null;
        $this->ArrivalAirport = $data['ns1ArrivalAirport']['@attributes']['LocationCode'] ?? null;

        // ADDETIONAL ATTRIBUTE TO USE WHEN GROUPING FLIGHTS
        $this->Path = isset($this->DepartureAirport, $this->ArrivalAirport) ? $this->DepartureAirport . '/' . $this->ArrivalAirport : null;
        $this->DepartureDate = isset($this->DepartureDateTime) ? Carbon::parse($this->DepartureDateTime)->format('Y-m-d') : null;
    }

    public function toArray()
    {
        $array = [
            'TransactionIdentifier' => $this->TransactionIdentifier,
            'ArrivalDateTime' => $this->ArrivalDateTime,
            'DepartureDateTime' => $this->DepartureDateTime,
            'FlightNumber' => $this->FlightNumber,
            'JourneyDuration' => $this->JourneyDuration,
            'RPH' => $this->RPH,
            'SmokingAllowed' => $this->SmokingAllowed,
            'returnFlag' => $this->returnFlag,
            'DepartureAirport' => $this->DepartureAirport,
            'ArrivalAirport' => $this->ArrivalAirport,
            'Price' => $this->Price->toArray(),
            'Path' => $this->Path,
            'DepartureDate' => $this->DepartureDate,
        ];

        foreach ($this->Price as $property => $value) {
            $array[$property] = $value;
        }

        return $array;
    }

    public function toLivewire()
    {
        $array = [
            'TransactionIdentifier' => $this->TransactionIdentifier,
            'ArrivalDateTime' => $this->ArrivalDateTime,
            'DepartureDateTime' => $this->DepartureDateTime,
            'FlightNumber' => $this->FlightNumber,
            'JourneyDuration' => $this->JourneyDuration,
            'RPH' => $this->RPH,
            'SmokingAllowed' => $this->SmokingAllowed,
            'returnFlag' => $this->returnFlag,
            'DepartureAirport' => $this->DepartureAirport,
            'ArrivalAirport' => $this->ArrivalAirport,
            'Price' => $this->Price,
            'Path' => $this->Path,
            'DepartureDate' => $this->DepartureDate,
        ];

        foreach ($this->Price as $property => $value) {
            $array[$property] = $value;
        }

        return $array;
    }

    public static function fromLivewire($value)
    {
        $instance = new self;
        $instance->TransactionIdentifier = $value['TransactionIdentifier'];
        $instance->ArrivalDateTime = $value['ArrivalDateTime'];
        $instance->DepartureDateTime = $value['DepartureDateTime'];
        $instance->FlightNumber = $value['FlightNumber'];
        $instance->JourneyDuration = $value['JourneyDuration'];
        $instance->RPH = $value['RPH'];
        $instance->SmokingAllowed = $value['SmokingAllowed'];
        $instance->returnFlag = $value['returnFlag'];
        $instance->DepartureAirport = $value['DepartureAirport'];
        $instance->ArrivalAirport = $value['ArrivalAirport'];
        $instance->Price = $value['Price'];
        $instance->Path = $value['Path'];
        $instance->DepartureDate = $value['DepartureDate'];

        foreach ($instance->Price as $property => $value) {
            $instance->{$property} = $value;
        }

        return $instance;
    }
}
