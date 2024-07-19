<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Credential;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
  
    public function sendApiRequest($numberReservation, $userName, $password)
    {
        // Construct the XML with the specific structure
        $xml = new \SimpleXMLElement('<Request/>');

        $requestorID = $xml->addChild('ns2:RequestorID');
        $requestorID->addAttribute('ID', $userName);
        $requestorID->addAttribute('Type', '4');

        $readRequest = $xml->addChild('ns2:ReadRequest');
        $uniqueID = $readRequest->addChild('ns2:UniqueID');
        $uniqueID->addAttribute('ID', $numberReservation);
        $uniqueID->addAttribute('Type', '14');

        $wsse = $xml->addChild('wsse:Security');
        $wsse->addAttribute('xmlns:wsse', 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd');

        $usernameToken = $wsse->addChild('wsse:UsernameToken');
        $usernameToken->addChild('wsse:Username', $userName);
        $passwordNode = $usernameToken->addChild('wsse:Password', $password);
        $passwordNode->addAttribute('Type', 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText');

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/xml',
            ])->post('https://documenter.getpostman.com/view/25763370/2sA3kPo42c', $xml->asXML());

            return $response->body();
        } catch (\Exception $e) {
            // Handle exception
            return $e->getMessage();
        }
    }
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'number_reservation' => 'required|alpha_num|size:6'
        ]);

        // Get the credentials from the verifications table
        $credentials = Credential::getCredentials();

        // If you need to do something with the credentials before storing
        $userName = $credentials->user_name;
        $password = $credentials->password;

        // Perform any necessary operations with the credentials here

        // Store the reservation
        $user = Auth::user();
        $reservations = new Reservation();
        $reservations->number_reservation = $request->number_reservation;
        $reservations->user_id = $user->id;
        $reservations->save();

        // Send the API request
        $apiResponse = $this->sendApiRequest($request->number_reservation, $userName, $password);

        // Return a response or redirect
        return redirect()->back()->with('success', 'Reservation created successfully. API Response: ' . $apiResponse);

        return view('admin.empty2')->with([
            'apiResponse' => $apiResponse,
            'numberReservation' => $request->number_reservation,
            'userName' => $userName,
            'password' => $password
        ]);
    }

    
   
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
