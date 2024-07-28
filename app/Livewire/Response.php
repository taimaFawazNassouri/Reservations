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
    public $selected = null;
    public $allResponses = [];

    public function mount()
    {
        $this->allResponses = session('allResponses');

        // select first available day
        foreach ($this->allResponses as $uuid => $response) {
            if (array_key_exists('ns1AAAirAvailRSExt', $response['ns1OTA_AirAvailRS'])) {
                $this->selected = $uuid;
                break;
            }
        }
    }

    public function test()
    {
        dd($this->selectedDay);
    }

    public function select($uuid)
    {
        $this->selected = $uuid;
    }

    #[Computed]
    public function selectedDay()
    {
        return $this->allResponses[$this->selected] ?? null;
    }

    public function render()
    {
        return view('livewire.response');
    }
}
