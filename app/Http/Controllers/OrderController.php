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
            $query->where('status', $status);
        }

        $orders = $query->latest()->get();

        return view('customer.orders.status', compact('orders', 'status'));
    }
}
