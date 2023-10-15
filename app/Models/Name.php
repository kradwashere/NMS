<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Name extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'name', 'role', 'contact', 'type_id', 'subtype_id'
    ];

    public function getNameAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    public function type()
    {
        return $this->belongsTo('App\Models\Dropdown', 'type_id', 'id');
    } 

    public function subtype()
    {
        return $this->belongsTo('App\Models\Dropdown', 'subtype_id', 'id');
    } 

    public function loans()
    {
        return $this->hasMany('App\Models\Loan', 'name_id');
    }
}
