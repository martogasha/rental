<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lease extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id','house_id','transaction_id'
    ];
    public function house(){
        return $this->belongsTo(House::class);
    }
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    public function transaction(){
        return $this->belongsTo(Transaction::class);
    }

}
