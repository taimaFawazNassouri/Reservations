<?php

namespace App;

use SimpleXMLElement;
use Illuminate\Support\Collection;

class FlightResponse
{
    private $response;
    private $xml;
    public $body;

    public function __construct(string $response = null)
    {
        $this->response = $response;
        $this->response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", (string) $response);
        $this->xml = new SimpleXMLElement($this->response);
        $this->body = json_decode(json_encode((array) $this->xml->xpath('//soapBody')[0]), TRUE);
    }

    public function getFlights(): Collection
    {
        $flights = collect([]);

        if (isset($this->body['ns1OTA_AirAvailRS']['ns1OriginDestinationInformation'])) {
            $informations = $this->body['ns1OTA_AirAvailRS']['ns1OriginDestinationInformation'];
            if (array_key_exists('@attributes', $informations)) {
                $informations = [$informations];
            }

            foreach ($informations as $key => $information) {
                if (isset($information['ns1OriginDestinationOptions']['ns1OriginDestinationOption'])) {
                    $option = $information['ns1OriginDestinationOptions']['ns1OriginDestinationOption'];

                    if (count($option) == 1) {
                        $option = [$option];
                    }

                    foreach ($option as $key => $flightRecord) {
                        $data = $flightRecord['ns1FlightSegment'];
                        $priceData = $this->body['ns1OTA_AirAvailRS']['ns1AAAirAvailRSExt']['ns1PricedItineraries']['ns1PricedItinerary']['ns1AirItineraryPricingInfo']['ns1ItinTotalFare'] ?? null;
                        $flight = new Flight($data, $priceData);

                        $flights->push($flight);
                    }
                }
            }
        }

        return $flights;
    }

    public function errors(): Collection
    {
        return collect($this->body['ns1OTA_AirAvailRS']['ns1Errors']);
    }
}
