<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Cart;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
        'is_active',
        'discount',
        'rating',
        'warranty'
    ];

    /*
    |--------------------------------------------------------------------------
    | AUTO GENERATE SLUG
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // 1 product bisa ada di banyak cart
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    // Relasi ke detail pesanan (untuk hitung jumlah terjual)
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relasi langsung ke user lewat carts
    public function usersInCart()
    {
        return $this->belongsToMany(User::class, 'carts')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPE ACTIVE
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}