<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;

class ExpenseController extends Controller
{
    public function index(Request $request){
        $options = $request->options;
        switch($options){
            case 'lists':
               return $this->lists($request);
            break;
            default : 
            return inertia('Modules/Expense/Index');
        }
    }

    public function store(Request $request){
        $data = \DB::transaction(function () use ($request){
            if($request->editable){
                $request->amount = trim(str_replace(',','',$request->amount),'₱ ');
                $data = Expense::with('name.type','name.subtype')->where('id',$request->id)->first();
                $data->update($request->except('editable'));
                return $data;
            }else{
                $data = new Expense;
                $data->amount = trim(str_replace(',','',$request->amount),'₱ ');
                $data->name_id = $request->name_id;
                $data->save();
                return $data = Expense::with('name.type','name.subtype')->where('id',$data->id)->first();
            }
        });
        $message = ($request->editable) ? 'updated' : 'created';
        return back()->with([
            'message' => 'Loan '.$message.' successfully. Thanks',
            'data' => new DefaultResource($data),
            'type' => 'bxs-check-circle',
            'color' => 'success'
        ]); 
    }

    public function lists($request){

    }

}
