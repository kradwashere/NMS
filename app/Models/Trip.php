<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'id','code','date','note','is_completed','has_departed','boat_id'
    ];

    public function boat()
    {
        return $this->belongsTo('App\Models\Name', 'boat_id', 'id');
    } 

    public function carriers()
    {
        return $this->hasMany('App\Models\Carrier', 'trip_id');
    } 

    public function expenses()
    {
        return $this->hasMany('App\Models\Expense', 'trip_id')->orderBy('created_at','DESC');
    } 

    public function sales()
    {
        return $this->hasMany('App\Models\Sale', 'trip_id');
    } 

    public function getUpdatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getDateAttribute($value)
    {
        return date('M d, Y', strtotime($value));
    }
}
