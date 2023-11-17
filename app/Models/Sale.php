<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'total', 'type_id', 'truck_id', 'buyer_id', 'trip_id', 'is_sold'
    ];

    public function trip()
    {
        return $this->belongsTo('App\Models\Trip', 'trip_id', 'id');
    } 

    public function type()
    {
        return $this->belongsTo('App\Models\Dropdown', 'type_id', 'id');
    } 

    public function buyer()
    {
        return $this->belongsTo('App\Models\Name', 'buyer_id', 'id');
    } 

    public function truck()
    {
        return $this->belongsTo('App\Models\Name', 'truck_id', 'id');
    } 

    public function lists()
    {
        return $this->hasMany('App\Models\SaleList', 'sale_id');
    } 
}
