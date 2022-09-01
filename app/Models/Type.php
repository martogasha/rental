<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
    protected $fillable = [
        'type','amount','invoice_id','date'
    ];
    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }
}
