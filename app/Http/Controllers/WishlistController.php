<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::where('user_id', Auth::id())
            ->with('product')
            ->latest()
            ->get();

        return view('customer.wishlist.index', compact('wishlists'));
    }

    public function toggle($productId)
    {
        $product = Product::findOrFail($productId);
        
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $status = 'removed';
            $message = $product->name . ' dihapus dari wishlist!';
        } else {
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $productId
            ]);
            $status = 'added';
            $message = $product->name . ' ditambahkan ke wishlist!';
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'status' => $status,
                'message' => $message,
                'wishlist_count' => Wishlist::where('user_id', Auth::id())->count()
            ]);
        }

        return back()->with('success', $message);
    }

    public function remove($id)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();
            
        $wishlist->delete();

        return back()->with('success', 'Produk dihapus dari wishlist.');
    }
}
