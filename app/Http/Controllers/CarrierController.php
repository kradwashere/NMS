<?php

namespace App\Http\Controllers;

use App\Models\Carrier;
use App\Models\Tub;
use Illuminate\Http\Request;

class CarrierController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'carrier_id' => 'required',
            'trip_id' => 'required',
            'tubs' => 'required|array',
            'tubs.*' => 'required|array',
            'tubs.*.amount' => 'required',
            'tubs.*.type' => 'required',
            'tubs.*.quantity' => 'required|integer|min:1',
        ]);
    }
}
