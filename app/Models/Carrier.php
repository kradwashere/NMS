<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrier extends Model
{
    use HasFactory;

    protected $fillable = [
        'id','order','total','carrier_id','trip_id'
    ];

    public function name()
    {
        return $this->belongsTo('App\Models\Name', 'carrier_id', 'id');
    } 

    public function trip()
    {
        return $this->belongsTo('App\Models\Trip', 'trip_id', 'id');
    } 

    public function tubs()
    {
        return $this->hasMany('App\Models\Tub', 'carrier_id');
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
