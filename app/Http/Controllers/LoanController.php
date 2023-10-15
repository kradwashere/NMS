<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Name;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;

class LoanController extends Controller
{
    public function index(Request $request){
        $options = $request->options;
        switch($options){
            case 'lists':
               return $this->lists($request);
            break;
            default : 
            return inertia('Modules/Loan/Index',[
                'breakdown' => $this->breakdown($request), 
                'top' => $this->top($request)
            ]);
        }
    }

    public function store(Request $request){
        $data = \DB::transaction(function () use ($request){
            if($request->editable){
                $request->amount = trim(str_replace(',','',$request->amount),'₱ ');
                $data = Loan::with('name.type','name.subtype')->where('id',$request->id)->first();
                $data->update($request->except('editable'));
                return $data;
            }else{
                $data = new Loan;
                $data->amount = trim(str_replace(',','',$request->amount),'₱ ');
                $data->name_id = $request->name_id;
                $data->save();
                return $data = Loan::with('name.type','name.subtype')->where('id',$data->id)->first();
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
        $data = DefaultResource::collection(
            Loan::with('name.type','name.subtype')
            ->when($request->keyword, function ($query, $keyword) {
                $query->whereHas('name',function ($query) use ($keyword){
                    $query->where('name','LIKE','%'.$keyword.'%');
                });
            })
            ->orderBy('is_paid', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate($request->counts)
            ->withQueryString()
        );
        return $data;
    }

    public function breakdown($request){
        return [
            [
                'title' => 'Total Paid',
                'total' => Loan::where('is_paid',1)->sum('amount'),
                'count' => Loan::where('is_paid',1)->count(),
                'text' => 'with paid loans',
                'icon' =>  'ri-safe-fill',
                'color' => 'success'
            ],
            [
                'title' => 'Total Unpaid',
                'total' => Loan::where('is_paid',0)->sum('amount'),
                'count' => Loan::where('is_paid',0)->count(),
                'text' => 'with unpaid loans',
                'icon' =>  'ri-safe-2-fill',
                'color' => 'danger'
            ],
        ];
    }

    public function top($request){
        $paid = Loan::
        select(
            'name_id',
            \DB::raw('SUM(CASE WHEN is_paid = true THEN 1 ELSE 0 END) as paid_loan_count'),
            \DB::raw('SUM(CASE WHEN is_paid = true THEN amount ELSE 0 END) as paid_total_amount'),
        )
        ->with('name')
        ->groupBy('name_id')
        ->orderByDesc('paid_total_amount')
        ->take(5)
        ->get();

        $unpaid = Loan::
        select(
            'name_id',
            \DB::raw('SUM(CASE WHEN is_paid = false THEN 1 ELSE 0 END) as unpaid_loan_count'),
            \DB::raw('SUM(CASE WHEN is_paid = false THEN amount ELSE 0 END) as unpaid_total_amount')
        )
        ->with('name')
        ->groupBy('name_id')
        ->orderByDesc('unpaid_total_amount')
        ->take(5)
        ->get();

        return [
            'paid' => $paid,
            'unpaid' => $unpaid
        ];
            // return DefaultResource::collection($data);
    }
}
