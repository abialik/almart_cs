<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the customer's orders.
     */
    public function index()
    {
        $orders = Order::where('customer_id', Auth::id())
            ->with(['payment'])
            ->latest()
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Ensure the order belongs to the authenticated customer
        if ($order->customer_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['items.product', 'payment']);

        return view('customer.orders.show', compact('order'));
    }

    /**
     * Display orders filtered by status.
     */
    public function status(Request $request)
    {
        $status = $request->get('s'); // e.g., 'pending', 'processing', etc.

        $query = Order::where('customer_id', Auth::id())
            ->with(['payment', 'items.product']);

        if ($status && $status !== 'all') {
            if ($status === 'processing') {
                $query->whereIn('status', ['paid', 'processing']);
            } elseif ($status === 'delivering') {
                $query->whereIn('status', ['delivering', 'ready_for_pickup']);
            } elseif ($status === 'completed') {
                $query->where('status', 'delivered');
            } else {
                $query->where('status', $status);
            }
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        return view('customer.orders.status', compact('orders', 'status'));
    }

    /**
     * Cancel the specified order (only if pending).
     */
    public function cancel(Order $order)
    {
        // Ensure the order belongs to the authenticated customer
        if ($order->customer_id !== Auth::id()) {
            abort(403);
        }

        // Only allowed to cancel if status is 'pending'
        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Pesanan ini tidak dapat dibatalkan karena sudah dalam proses.');
        }

        // Increment stock back
        foreach ($order->items as $item) {
            if ($item->product) {
                $item->product->increment('stock', $item->qty);
            }
        }

        // Update status
        $order->update(['status' => 'cancelled']);

        return redirect()->route('customer.orders.status', ['s' => 'cancelled'])
            ->with('success', 'Pesanan ' . $order->order_code . ' berhasil dibatalkan.');
    }
}
