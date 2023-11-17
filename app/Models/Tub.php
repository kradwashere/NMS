<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tub extends Model
{
    use HasFactory;

    protected $fillable = [
        'id','quantity','amount','is_sold','type_id','carrier_id'
    ];

    public function carrier()
    {
        return $this->belongsTo('App\Models\Carrier', 'carrier_id', 'id');
    } 

    public function type()
    {
        return $this->belongsTo('App\Models\Name', 'type_id', 'id');
    } 

    public function sales()
    {
        return $this->hasMany('App\Models\SaleList', 'tub_id');
    } 

    public function getUpdatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }
}
