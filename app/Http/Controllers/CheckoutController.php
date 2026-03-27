<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Events\NewOrderEvent;


class CheckoutController extends Controller
{
    /**
     * Tampilkan halaman checkout dengan order summary dari cart.
     */
    public function index(Request $request)
    {
        $selectedItemIds = $request->input('items', []);

        $cart = Cart::where('user_id', Auth::id())
            ->with(['items.product' => function($q) use ($selectedItemIds) {
                if (!empty($selectedItemIds)) {
                    // This doesn't actually filter the items in the relationship collection correctly this way in Laravel with()
                    // Better filter the collection afterwards or use whereHas for the main query.
                }
            }])
            ->first();

        $cartItems = $cart ? $cart->items : collect();

        // Filter items if specific ones were selected in cart
        if (!empty($selectedItemIds)) {
            $cartItems = $cartItems->whereIn('id', $selectedItemIds);
        }

        if ($cartItems->isEmpty()) {
            return redirect()->route('customer.cart.index')
                ->with('error', 'Silakan pilih produk yang ingin dicheckout terlebih dahulu.');
        }

        $addresses = Auth::user()->addresses()->latest()->get();

        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->qty);
        $shippingFee = 0;
        $total = $subtotal + $shippingFee;

        return view('checkout.index', compact('cartItems', 'subtotal', 'shippingFee', 'total', 'addresses', 'selectedItemIds'));
    }

    /**
     * Proses "Place Order" — buat Order + OrderItems dari cart.
     */
    public function store(Request $request)
    {
        $request->validate([
            'address_id'    => 'nullable|exists:addresses,id',
            'full_name'     => 'required_without:address_id|nullable|string|max:255',
            'address'       => 'required_without:address_id|nullable|string|max:500',
            'city'          => 'required_without:address_id|nullable|string|max:100',
            'post_code'     => 'required_without:address_id|nullable|string|max:10',
            'province'      => 'required_without:address_id|nullable|string|max:100',
            'phone'         => 'required_without:address_id|nullable|string|max:20',
            'payment_method'=> 'required|in:transfer,ewallet,qris,cod',
            'items'         => 'required|array',
            'items.*'       => 'exists:cart_items,id'
        ]);

        $selectedItemIds = $request->input('items', []);

        $cart = Cart::where('user_id', Auth::id())
            ->with('items.product')
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('customer.cart.index')
                ->with('error', 'Cart kamu kosong.');
        }

        $cartItems = $cart->items->whereIn('id', $selectedItemIds);

        if ($cartItems->isEmpty()) {
            return redirect()->route('customer.cart.index')
                ->with('error', 'Tidak ada item yang dipilih untuk dicheckout.');
        }

        // Tentukan data alamat
        if ($request->filled('address_id')) {
            $addr = Address::where('user_id', Auth::id())->where('id', $request->address_id)->firstOrFail();
            $addressData = [
                'full_name' => $addr->full_name,
                'address'   => $addr->address,
                'city'      => $addr->city,
                'post_code' => $addr->post_code,
                'province'  => $addr->province,
                'phone'     => $addr->phone,
            ];
        } else {
            $addressData = [
                'full_name' => $request->full_name,
                'address'   => $request->address,
                'city'      => $request->city,
                'post_code' => $request->post_code,
                'province'  => $request->province,
                'phone'     => $request->phone,
            ];

            // Simpan alamat baru secara otomatis agar bisa dipakai lagi
            Address::create(array_merge($addressData, [
                'user_id' => Auth::id(),
                'label'   => 'Alamat Baru'
            ]));
        }

        $subtotal    = $cartItems->sum(fn($item) => $item->product->price * $item->qty);
        $shippingFee = 0;
        $total       = $subtotal + $shippingFee;

        // Buat order
        $order = Order::create(array_merge([
            'order_code'  => 'ORD-' . strtoupper(Str::random(8)),
            'customer_id' => Auth::id(),
            'subtotal'    => $subtotal,
            'shipping_fee'=> $shippingFee,
            'total'       => $total,
            'status'      => 'pending',
        ], $addressData));

        // Trigger Real-time Event for Admin
        event(new NewOrderEvent($order));

        // Buat order items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id'  => $order->id,
                'product_id'=> $item->product_id,
                'price'     => $item->product->price,
                'qty'       => $item->qty,
                'subtotal'  => $item->product->price * $item->qty,
            ]);
        }

        // Buat record payment
        Payment::create([
            'order_id' => $order->id,
            'method'   => $request->payment_method,
            'status'   => 'unpaid',
        ]);

        // Kosongkan HANYA item yang dicheckout
        CartItem::whereIn('id', $selectedItemIds)->delete();

        return redirect()->route('customer.checkout.payment', $order->id)
            ->with('success', 'Order berhasil dibuat! Silakan upload bukti pembayaran.');
    }

    /**
     * Halaman upload bukti pembayaran.
     */
    public function payment(Order $order)
    {
        // Pastikan order milik user yang login
        if ($order->customer_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items.product', 'payment');

        return view('checkout.payment', compact('order'));
    }

    /**
     * Proses upload bukti pembayaran.
     */
    public function uploadProof(Request $request, Order $order)
    {
        if ($order->customer_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'proof_of_payment' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $file = $request->file('proof_of_payment');
        $filename = 'payment_' . $order->order_code . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('payments', $filename, 'public');

        // Update payment record
        $payment = $order->payment;
        if ($payment) {
            $payment->update([
                'proof_of_payment' => $path,
                'status'           => 'paid',
            ]);
        }

        // Update order status
        $order->update(['status' => 'paid']);

        // Notification for payment updated
        event(new NewOrderEvent($order));

        return redirect()->route('customer.checkout.payment', $order->id)
            ->with('success', 'Bukti pembayaran berhasil diupload! Pesanan kamu sedang diproses.');
    }
}
