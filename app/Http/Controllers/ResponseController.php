<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public function show(Request $request)
    {
        $responseData = session('responseData', []);

        return view('livewire.response', compact('responseData'));
    }
}
