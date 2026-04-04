<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'order_number',
        'complaint_type',
        'description',
        'status',
        'admin_response'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
