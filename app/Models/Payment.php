<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'method',
        'status',
        'payment_reference',
        'proof_of_payment',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
