<?php

namespace App\Http\Controllers;

use App\Models\Dropdown;
use App\Models\Name;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;

class NameController extends Controller
{
    public function index(Request $request){
        $options = $request->options;
        switch($options){
            case 'lists':
               return $this->lists($request);
            break;
            case 'search':
                return $this->search($request);
             break;
            default : 
            return inertia('Modules/Name/Index',[
                'counts' => $this->counts()
            ]);
        }
    }

    public function store(Request $request){
        $data = \DB::transaction(function () use ($request){
            if($request->editable){
                $data = Name::with('type','subtype')->where('id',$request->id)->first();
                $data->update($request->except('editable'));
                return $data;
            }else{
                $data = Name::with('type','subtype')->create($request->all());
               return $data = Name::with('type','subtype')->where('id',$data->id)->first();
            }
            
        });
        $message = ($request->editable) ? 'updated' : 'created';
        return back()->with([
            'message' => 'Name '.$message.' successfully. Thanks',
            'data' => new DefaultResource($data),
            'type' => 'bxs-check-circle',
            'color' => 'success'
        ]); 
    }

    public function lists($request){
        $data = DefaultResource::collection(
            Name::with('type')
            ->whereHas('type',function ($query){
                $query->where('type','Name');
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

    public function search($request){
        $data = DefaultResource::collection(
            Name::query()
            ->with('subtype')
            ->whereHas('type',function ($query){
                $query->where('name','Person');
            })
            ->when($request->keyword, function ($query, $keyword) {
                $query->where('name','LIKE', "%{$keyword}%");
            })
            ->get()
        );
        return $data;
    }

    public function counts(){
        $transpo = Dropdown::select('id','name','icon')->where('type','Name')->withCount('names')->get();
        return $transpo;
    }
}
