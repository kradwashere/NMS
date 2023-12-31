<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'amount', 'name_id', 'trip_id', 'note'
    ];

    public function name()
    {
        return $this->belongsTo('App\Models\Name', 'name_id', 'id');
    } 

    public function trip()
    {
        return $this->belongsTo('App\Models\Trip', 'trip_id', 'id');
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
