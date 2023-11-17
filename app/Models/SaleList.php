<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleList extends Model
{
    use HasFactory;

    public function sale()
    {
        return $this->belongsTo('App\Models\Sale', 'sale_id', 'id');
    } 

    public function tub()
    {
        return $this->belongsTo('App\Models\Tub', 'tub_id', 'id');
    } 
}
