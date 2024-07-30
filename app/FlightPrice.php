<?php

namespace App;

use Illuminate\Contracts\Support\Arrayable;
use Livewire\Wireable;

class FlightPrice implements Arrayable, Wireable
{
    // ['ns1OTA_AirAvailRS']['ns1AAAirAvailRSExt']['ns1PricedItineraries']['ns1PricedItinerary']['ns1AirItineraryPricingInfo']['ns1ItinTotalFare']
    private $data;
    public $BaseFare;
    public $TotalFare;
    public $TotalEquivFare;
    public $TotalFareWithCCFee;
    public $TotalEquivFareWithCCFee;

    public function __construct(?array $data = [])
    {
        $this->data = $data;

        $this->BaseFare = isset($data['ns1BaseFare']['@attributes']['Amount'], $data['ns1BaseFare']['@attributes']['CurrencyCode']) ? $data['ns1BaseFare']['@attributes']['Amount'] . ' ' . $data['ns1BaseFare']['@attributes']['CurrencyCode'] : null;
        $this->TotalFare = isset($data['ns1TotalFare']['@attributes']['Amount'], $data['ns1TotalFare']['@attributes']['CurrencyCode']) ? $data['ns1TotalFare']['@attributes']['Amount'] . ' ' . $data['ns1TotalFare']['@attributes']['CurrencyCode'] : null;
        $this->TotalEquivFare = isset($data['ns1TotalEquivFare']['@attributes']['Amount'], $data['ns1TotalEquivFare']['@attributes']['CurrencyCode']) ? $data['ns1TotalEquivFare']['@attributes']['Amount'] . ' ' . $data['ns1TotalEquivFare']['@attributes']['CurrencyCode'] : null;
        $this->TotalFareWithCCFee = isset($data['ns1TotalFareWithCCFee']['@attributes']['Amount'], $data['ns1TotalFareWithCCFee']['@attributes']['CurrencyCode']) ? $data['ns1TotalFareWithCCFee']['@attributes']['Amount'] . ' ' . $data['ns1TotalFareWithCCFee']['@attributes']['CurrencyCode'] : null;
        $this->TotalEquivFareWithCCFee = isset($data['ns1TotalEquivFareWithCCFee']['@attributes']['Amount'], $data['ns1TotalEquivFareWithCCFee']['@attributes']['CurrencyCode']) ? $data['ns1TotalEquivFareWithCCFee']['@attributes']['Amount'] . ' ' . $data['ns1TotalEquivFareWithCCFee']['@attributes']['CurrencyCode'] : null;
    }

    public function toArray()
    {
        return [
            'BaseFare' => $this->BaseFare,
            'TotalFare' => $this->TotalFare,
            'TotalEquivFare' => $this->TotalEquivFare,
            'TotalFareWithCCFee' => $this->TotalFareWithCCFee,
            'TotalEquivFareWithCCFee' => $this->TotalEquivFareWithCCFee,
        ];
    }

    public function toLivewire()
    {
        return [
            'BaseFare' => $this->BaseFare,
            'TotalFare' => $this->TotalFare,
            'TotalEquivFare' => $this->TotalEquivFare,
            'TotalFareWithCCFee' => $this->TotalFareWithCCFee,
            'TotalEquivFareWithCCFee' => $this->TotalEquivFareWithCCFee,
        ];
    }

    public static function fromLivewire($value)
    {
        $instance = new self;
        $instance->BaseFare = $value['BaseFare'];
        $instance->TotalFare = $value['TotalFare'];
        $instance->TotalEquivFare = $value['TotalEquivFare'];
        $instance->TotalFareWithCCFee = $value['TotalFareWithCCFee'];
        $instance->TotalEquivFareWithCCFee = $value['TotalEquivFareWithCCFee'];

        return $instance;
    }
}
