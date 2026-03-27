<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | Table (optional kalau nama table bukan "carts")
    |--------------------------------------------------------------------------
    */
    protected $table = 'carts';

    /*
    |--------------------------------------------------------------------------
    | Mass Assignment
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'user_id',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // 1 Cart milik 1 User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 1 Cart punya banyak CartItem
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Helper: Hitung total quantity
    |--------------------------------------------------------------------------
    */
    public function totalItems()
    {
        return $this->items()->sum('qty');
    }
}