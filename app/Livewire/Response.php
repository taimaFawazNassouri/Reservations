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

class Response extends Component
{

    public $FareBasisCodes;
    public $FareRuleReference;
    public $DepartureAirport;
    public $ArrivalAirport;
    public $DepartureDateTime;
    public $ArrivalDateTime;
    public $FlightNumber;
    public $TotalFareWithCCFee;
    public $TotalEquivFareWithCCFee;
    public $allResponses = [];



    public function mount()
    {
        $this->allResponses = session('allResponses');
        //dd( $this->allResponses);
        // $this->FareRuleReference = session('fare_rule_reference');
        // $this->DepartureAirport = session('DepartureAirport');
        // $this->ArrivalAirport = session('ArrivalAirport');
        // $this->DepartureDateTime = session('DepartureDateTime');
        // $this->ArrivalDateTime = session('ArrivalDateTime');
        // $this->FlightNumber = session('FlightNumber');
        // $this->TotalFareWithCCFee = session('TotalFareWithCCFee');
        // $this->TotalEquivFareWithCCFee = session('TotalEquivFareWithCCFee');
      
    }
    public function render()
    {
        return view('livewire.response');
    }
}
