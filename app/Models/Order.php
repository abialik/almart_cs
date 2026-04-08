<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_code',
        'shipping_type',
        'pickup_code',
        'pickup_note',
        'customer_id',
        'petugas_id',
        'subtotal',
        'shipping_fee',
        'total',
        'status',
        // billing info
        'full_name',
        'address',
        'city',
        'post_code',
        'province',
        'phone',
        'payment_deadline',
        'shipped_at',
        'completed_at',
    ];

    protected $casts = [
        'payment_deadline' => 'datetime',
        'shipped_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Generate a unique pickup code (e.g. PICK-1234)
     */
    public static function generatePickupCode()
    {
        do {
            $code = 'PICK-' . rand(1000, 9999);
        } while (self::where('pickup_code', $code)->exists());

        return $code;
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function returns()
    {
        return $this->hasMany(ProductReturn::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
