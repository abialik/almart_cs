<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductReviewController extends Controller
{
    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_id'   => 'required|exists:orders,id',
            'rating'     => 'required|integer|min:1|max:5',
            'comment'    => 'nullable|string|max:1000',
            'photo'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $user = Auth::user();
        $order = Order::where('id', $request->order_id)
                      ->where('customer_id', $user->id)
                      ->where('status', 'delivered')
                      ->firstOrFail();

        // Check if the product is in this order
        $productExists = $order->items()->where('product_id', $request->product_id)->exists();
        if (!$productExists) {
            abort(403, 'Produk tidak ditemukan dalam pesanan ini.');
        }

        // Check if already reviewed
        $existingReview = Review::where('user_id', $user->id)
                                ->where('product_id', $request->product_id)
                                ->where('order_id', $request->order_id)
                                ->exists();
        
        if ($existingReview) {
            return redirect()->back()->with('error', 'Anda sudah memberikan ulasan untuk produk ini.');
        }

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('reviews', 'public');
        }

        $review = Review::create([
            'user_id'    => $user->id,
            'product_id' => $request->product_id,
            'order_id'   => $request->order_id,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
            'photo_path' => $photoPath,
        ]);

        // Dispatch Real-time Event
        event(new \App\Events\NewReviewEvent($review));

        return redirect()->back()->with('success', 'Ulasan Anda berhasil dikirim! Terima kasih atas feedback-nya.');
    }
}
