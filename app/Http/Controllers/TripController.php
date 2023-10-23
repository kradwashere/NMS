<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Name;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;

class TripController extends Controller
{
    public function index(Request $request){
        $options = $request->options;
        switch($options){
            case 'lists':
               return $this->lists($request);
            break;
            default : 
            return inertia('Modules/Trip/Index',[
                'boats' => Name::where('type_id',1)->where('is_active',1)->get()
            ]);
        }
    }

    public function store(Request $request){
        $request->validate([
            'boat_id' => 'required',
            'date' => 'required',
            'note' => 'nullable'
        ]);
        $activeTrips = Trip::where('has_departed', 0)->where('is_completed', 0)->count();

        if($activeTrips > 0){
            return back()->with([
                'message' => 'You cannot add a new trip while there are active trips',
                'data' => [],
                'type' => 'bxs-check-circle',
                'color' => 'danger'
            ]); 
        }else{
            $data = \DB::transaction(function () use ($request){
                if($request->editable){
                    $data = Trip::with('boat')->where('id',$request->id)->first();
                    $data->update($request->except('editable'));
                    return $data;
                }else{
                    $code = 'TRP'.date('Y').date('m').date('d')."-".str_pad((Trip::count()+1), 4, '0', STR_PAD_LEFT);  
                    $data = Trip::create(array_merge($request->all(),['code' => $code]));
                    $update = Trip::where('id','!=',$data->id)->update(['is_completed' => 1]);
                    return $data = Trip::with('boat')->where('id',$data->id)->first();
                }
            });
            $message = ($request->editable) ? 'updated' : 'created';
            return back()->with([
                'message' => 'Trip '.$message.' successfully. Thanks',
                'data' => new DefaultResource($data),
                'type' => 'bxs-check-circle',
                'color' => 'success'
            ]); 
        }
    }

    public function lists($request){
        $data = DefaultResource::collection(
            Trip::with('boat:id,name')
            ->with('carriers.tubs','expenses')
            ->when($request->keyword, function ($query, $keyword) {
                $query->where('code','LIKE','%'.$keyword.'%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate($request->counts)
            ->withQueryString()
        );
        return $data;
    }
}
