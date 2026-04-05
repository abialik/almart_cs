<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())
            ->with('items.product.category')
            ->first();

        $cartItems = $cart ? $cart->items : collect();

        return view('cart.index', compact('cartItems'));
    }

    public function add($productId)
    {
        $product = Product::findOrFail($productId);

        // cari atau buat cart
        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id()
        ]);

        // cek di cart_items
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            if ($cartItem->qty + 1 > $product->stock) {
                if (request()->ajax()) {
                    return response()->json(['success' => false, 'message' => 'Stok produk tidak mencukupi. Sisa: ' . $product->stock]);
                }
                return back()->with('error', 'Stok produk tidak mencukupi.');
            }
            $cartItem->qty += 1;
            $cartItem->save();
        } else {
            if ($product->stock < 1) {
                if (request()->ajax()) {
                    return response()->json(['success' => false, 'message' => 'Stok produk habis.']);
                }
                return back()->with('error', 'Stok produk habis.');
            }
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'qty' => 1
            ]);
        }

        if (request()->ajax()) {
            $totalCount = CartItem::where('cart_id', $cart->id)->sum('qty');
            return response()->json([
                'success' => true,
                'message' => $product->name . ' berhasil ditambahkan ke keranjang!',
                'cart_count' => $totalCount
            ]);
        }

        return redirect()->route('customer.cart.index');
    }

    public function remove($productId)
    {
        $cart = Cart::where('user_id', Auth::id())->first();

        if ($cart) {
            CartItem::where('cart_id', $cart->id)
                ->where('product_id', $productId)
                ->delete();
        }

        return back();
    }

    public function increase($productId)
{
    $cart = Cart::where('user_id', Auth::id())->first();

    if (!$cart) return back();

    $item = CartItem::where('cart_id', $cart->id)
        ->where('product_id', $productId)
        ->first();

    if ($item) {
        if ($item->qty + 1 > $item->product->stock) {
            return back()->with('error', 'Stok maksimal telah tercapai.');
        }
        $item->qty += 1;
        $item->save();
    }

    return back();
}

public function decrease($productId)
{
    $cart = Cart::where('user_id', Auth::id())->first();

    if (!$cart) return back();

    $item = CartItem::where('cart_id', $cart->id)
        ->where('product_id', $productId)
        ->first();

    if ($item) {
        if ($item->qty > 1) {
            $item->qty -= 1;
            $item->save();
        } else {
            $item->delete();
        }
    }

    return back();
}
}