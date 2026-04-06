<?php

namespace App\Http\Controllers;

use App\Models\ProductReturn;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Events\NewOrderEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminReturnController extends Controller
{
    /**
     * Display a listing of the returns.
     */
    public function index(Request $request)
    {
        $query = ProductReturn::with(['order', 'customer'])->latest();

        // Filter by status if provided
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $returns = $query->paginate(10);
        return view('admin.returns.index', compact('returns'));
    }

    /**
     * Display the specified return.
     */
    public function show(ProductReturn $return)
    {
        $return->load(['order.items.product', 'customer']);
        return view('admin.returns.show', compact('return'));
    }

    /**
     * Update the status of the return.
     */
    public function update(Request $request, ProductReturn $return)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'admin_note' => 'nullable|string|max:1000',
            'send_replacement' => 'nullable|boolean',
        ]);

        \Illuminate\Support\Facades\DB::transaction(function() use ($request, $return) {
            $return->update([
                'status' => $request->status,
                'admin_note' => $request->admin_note,
            ]);

            // HANDLE AUTOMATED REPLACEMENT ORDER
            if ($request->status === 'approved' && $request->send_replacement) {
                $originalOrder = $return->order;
                
                // 1. Create New Order with Rp0
                $replacementOrder = Order::create([
                    'order_code'    => 'REPLACE-' . strtoupper(Str::random(8)),
                    'customer_id'   => $originalOrder->customer_id,
                    'subtotal'      => 0,
                    'shipping_fee'  => 0,
                    'total'         => 0,
                    'status'        => 'paid', // Mark as paid to bypass payment
                    'shipping_type' => $originalOrder->shipping_type,
                    'full_name'     => $originalOrder->full_name,
                    'address'       => $originalOrder->address,
                    'city'          => $originalOrder->city,
                    'post_code'     => $originalOrder->post_code,
                    'province'      => $originalOrder->province,
                    'phone'         => $originalOrder->phone,
                ]);

                // 2. Create Order Items & Deduct Stock
                foreach ($originalOrder->items as $item) {
                    OrderItem::create([
                        'order_id'   => $replacementOrder->id,
                        'product_id' => $item->product_id,
                        'price'      => 0, // Replacement is free
                        'qty'        => $item->qty,
                        'subtotal'   => 0,
                    ]);

                    // Deduct stock for the new item being sent
                    if ($item->product) {
                        $item->product->decrement('stock', $item->qty);
                    }
                }

                // 3. Create dummy payment record
                Payment::create([
                    'order_id' => $replacementOrder->id,
                    'method'   => 'transfer', // dummy
                    'status'   => 'paid',
                    'proof_of_payment' => 'Replacement Order',
                ]);

                // 4. Trigger Notification for Petugas / Admin
                event(new NewOrderEvent($replacementOrder));
            }
        });

        return redirect()->route('admin.returns.index')
            ->with('success', 'Status pengembalian berhasil diperbarui.');
    }
}
