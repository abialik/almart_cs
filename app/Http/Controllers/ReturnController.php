<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\NewReturnEvent;


class ReturnController extends Controller
{
    public function index()
    {
        $returns = ProductReturn::with('order')
            ->where('customer_id', Auth::id())
            ->latest()
            ->get();

        return view('customer.returns.index', compact('returns'));
    }

    public function create(Order $order)
    {
        if ($order->customer_id !== Auth::id()) {
            abort(403);
        }

        // Only allow returns for certain statuses
        if (!in_array($order->status, ['paid', 'processing', 'delivered'])) {
            return redirect()->route('customer.orders.show', $order->id)
                ->with('error', 'Pesanan ini tidak dapat diajukan pengembalian.');
        }

        return view('customer.returns.create', compact('order'));
    }

    public function store(Request $request, Order $order)
    {
        if ($order->customer_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'reason'      => 'required|string|max:1000',
            'image_proof' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $path = null;
        if ($request->hasFile('image_proof')) {
            $file = $request->file('image_proof');
            $filename = 'return_' . $order->order_code . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('returns', $filename, 'public');
        }

        ProductReturn::create([
            'order_id'    => $order->id,
            'customer_id' => Auth::id(),
            'reason'      => $request->reason,
            'image_proof' => $path,
            'status'      => 'pending',
        ]);

        // Trigger Real-time Event for Admin
        event(new NewReturnEvent($productReturn));


        return redirect()->route('customer.orders.show', $order->id)
            ->with('success', 'Pengajuan pengembalian berhasil dikirim! Tim kami akan meninjau secepatnya.');
    }
}
