<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'lease_id','date','status'
    ];
    public function lease(){
        return $this->belongsTo(Lease::class);
    }
}
