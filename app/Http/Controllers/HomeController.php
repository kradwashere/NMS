<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Name;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return inertia('Modules/Home/Index',[
            'trip' => Trip::with('boat','expenses.name.type','expenses.name.subtype','carriers.tubs.type','carriers.name')->where('is_completed',0)->first(),
            'carriers' => Name::with('type')->where('type_id',2)->get(),
            'fishes' => Name::with('type')->where('type_id',13)->get(),
        ]);
    }
}
