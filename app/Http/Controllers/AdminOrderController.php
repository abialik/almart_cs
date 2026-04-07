<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of all orders for Admin/Petugas.
     */
    public function index(Request $request)
    {
        $query = Order::with(['payment', 'customer', 'items'])->latest();

        if ($request->has('search')) {
            $query->where('order_code', 'like', '%' . $request->search . '%')
                  ->orWhereHas('customer', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
        }

        $orders = $query->paginate(15);

        // Stats calculation
        $allOrders = Order::with('payment')->get();
        $totalOrders = $allOrders->count();
        $totalRevenue = $allOrders->whereIn('status', ['paid', 'processing', 'delivering', 'ready_for_pickup', 'delivered'])->sum('total');
        $offlineOrders = $allOrders->filter(function($order) {
            return strtolower(optional($order->payment)->method) === 'tunai' || strtolower(optional($order->payment)->method) === 'cod';
        })->count();
        $onlineOrders = $totalOrders - $offlineOrders;

        return view('admin.orders.index', compact('orders', 'totalOrders', 'totalRevenue', 'onlineOrders', 'offlineOrders'));
    }

    /**
     * Display the specified order detail for verification.
     */
    public function show(Order $order)
    {
        $order->load(['items.product', 'payment', 'user']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the status of the order.
     */
    public function updateStatus(Order $order, Request $request)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,processing,delivering,ready_for_pickup,delivered,cancelled'
        ]);

        $previousStatus = $order->status;
        $order->update(['status' => $request->status]);

        // If status changed to paid, ensure payment status is also paid
        if ($request->status === 'paid' && $order->payment) {
            $order->payment->update(['status' => 'paid']);
        }

        // Jika pesanan dibatalkan, kembalikan stok ke gudang
        if ($request->status === 'cancelled' && $previousStatus !== 'cancelled') {
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->qty);
                }
            }
        } elseif ($previousStatus === 'cancelled' && $request->status !== 'cancelled') {
            // Jika pesanan yang tadinya dibatalkan DIBUKA KEMBALI, potong lagi stoknya
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->decrement('stock', $item->qty);
                }
            }
        }

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui menjadi ' . strtoupper($request->status));
    }

    /**
     * Export orders to CSV.
     */
    public function export(Request $request)
    {
        $fileName = 'transaksi_' . date('Y_m_d_H_i_s') . '.csv';
        $orders = Order::with(['payment', 'customer', 'items'])->latest()
            ->when($request->search, function($query, $search) {
                return $query->where('order_code', 'like', "%{$search}%")
                             ->orWhereHas('customer', function($q) use ($search) {
                                 $q->where('name', 'like', "%{$search}%");
                             });
            })->get();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = ['ID Transaksi', 'Tanggal', 'Customer', 'Total Items', 'Total Belanja', 'Metode Pembayaran', 'Status'];

        $callback = function() use($orders, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($orders as $order) {
                fputcsv($file, array(
                    $order->order_code,
                    $order->created_at->format('Y-m-d H:i:s'),
                    $order->customer->name ?? $order->user->name ?? '-',
                    $order->items ? $order->items->count() : 1,
                    $order->total,
                    $order->payment ? $order->payment->method : '-',
                    $order->status
                ));
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
