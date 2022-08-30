<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','number','property_id','lease_id','status','amount'
    ];
    public function property(){
        return $this->belongsTo(Property::class);
    }
}
