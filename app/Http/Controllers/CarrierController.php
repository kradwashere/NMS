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

        $data = \DB::transaction(function () use ($request){
            $count = Carrier::where('trip_id',$request->trip_id)->count();
            $request['order'] = $this->numberToOrdinal($count+1);
            $carrier = Carrier::create($request->all());
            if($carrier){
                $tubs = $request->tubs;
                foreach($tubs as $tub){
                    $data = new Tub;
                    $data->type_id = $tub['type'];
                    $data->quantity = $tub['quantity'];
                    $data->amount = $tub['amount'];
                    $data->carrier_id = $carrier->id;
                    $data->save();
                }
            }
        });
    }

    public function numberToOrdinal($number) {
        if ($number % 100 >= 11 && $number % 100 <= 13) {
            $ordinal = $number . 'th';
        } else {
            switch ($number % 10) {
                case 1:
                    $ordinal = $number . 'st';
                    break;
                case 2:
                    $ordinal = $number . 'nd';
                    break;
                case 3:
                    $ordinal = $number . 'rd';
                    break;
                default:
                    $ordinal = $number . 'th';
                    break;
            }
        }
        return $ordinal;
    }
}
