<?php

namespace App\Http\Controllers;

use App\Models\Dropdown;
use App\Models\Name;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;

class TransportationController extends Controller
{
    public function index(Request $request){
        $options = $request->options;
        switch($options){
            case 'lists':
               return $this->lists($request);
            break;
            default : 
            return inertia('Modules/Transportation/Index',[
                'counts' => $this->counts()
            ]);
        }
    }

    public function store(Request $request){
        $data = \DB::transaction(function () use ($request){
            if($request->editable){
                $data = Name::where('id',$request->id)->first();
                $data->update($request->except('editable'));
                return $data;
            }else{
                return $data = Name::create($request->all());
            }
            
        });
        $message = ($request->editable) ? 'updated' : 'created';
        return back()->with([
            'message' => 'Transportation '.$message.' successfully. Thanks',
            'data' => new DefaultResource($data),
            'type' => 'bxs-check-circle',
            'color' => 'success'
        ]); 
    }

    public function lists($request){
        $data = DefaultResource::collection(
            Name::with('type')
            ->whereHas('type',function ($query){
                $query->where('type','Transportation');
            })
            ->when($request->keyword, function ($query, $keyword) {
                $query->where('name', 'LIKE', '%'.$keyword.'%');
            })
            ->when($request->type, function ($query, $type) {
                $query->where('type_id',$type);
            })
            ->orderBy('id','asc')
            ->paginate($request->counts)
            ->withQueryString()
        );

        return $data;
    }

    public function counts(){
        $transpo = Dropdown::select('id','name','icon')->where('type','Transportation')->withCount('names')->get();
        return $transpo;
    }
}
