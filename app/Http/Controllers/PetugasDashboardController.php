<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PetugasDashboardController extends Controller
{
    /**
     * Tampilkan halaman utama Dasbor Petugas dengan daftar antrean
     */
    public function index(Request $request)
    {
        // Parameter Tab Utama (Pesanan, Picking, Delivery, Self Service)
        $tab = $request->get('tab', 'pesanan');
        $subtab = $request->get('subtab', 'delivery_list');

        // Parameter Filter Status (Semua, Baru, Diproses, Selesai)
        $filter = $request->get('filter', 'semua');

        // Query Dasar Pesanan
        $query = Order::with(['items.product', 'customer', 'payment'])->latest();

        // Data Statistik (Kotak Scoreboard)
        $countBaru = (clone $query)->where('status', 'paid')->count();
        $countDiproses = (clone $query)->where('status', 'processing')->count();
        $countDelivery = (clone $query)->where('status', 'delivering')->count();
        $countReadyForPickup = (clone $query)->where('status', 'ready_for_pickup')->count();
        $countSelesai = (clone $query)->where('status', 'delivered')->whereDate('updated_at', today())->count();
        $countSemua = $countBaru + $countDiproses + $countDelivery + $countReadyForPickup; // Terhitung aktif

        // Filter berdasarkan tab aktif dan filter aktif
        if ($filter === 'baru') {
            $query->where('status', 'paid');
        } elseif ($filter === 'diproses') {
             $query->where('status', 'processing');
        } elseif ($filter === 'selesai') {
             $query->where('status', 'delivered');
        } else {
             $query->whereIn('status', ['paid', 'processing', 'delivering', 'ready_for_pickup']);
        }

        $orders = $query->paginate(20)->withQueryString();

        return view('dashboards.petugas', compact(
            'tab', 'subtab', 'filter', 'orders', 
            'countBaru', 'countDiproses', 'countSelesai', 'countSemua', 'countDelivery', 'countReadyForPickup'
        ));
    }

    /**
     * Ambil rincian pesanan (untuk Modal Detail List via AJAX)
     */
    public function show(Order $order)
    {
        $order->load(['items.product', 'customer']);
        
        // Mengembalikan serpihan HTML agar mempermudah render di frontend (AJAX modal)
        return response()->json([
            'html' => view('dashboards._petugas_detail', compact('order'))->render()
        ]);
    }

    /**
     * Ambil rincian pesanan khusus tab Picking
     */
    public function showPicking(Order $order)
    {
        $order->load(['items.product', 'customer']);
        
        return response()->json([
            'html' => view('dashboards._picking_detail', compact('order'))->render()
        ]);
    }
    /**
     * Update the status of the order (Terima/Tolak/Selesai).
     */
    public function updateStatus(Order $order, Request $request)
    {
        $request->validate([
            'status' => 'required|in:processing,delivered,cancelled'
        ]);

        $previousStatus = $order->status;
        $data = ['status' => $request->status];

        // Jika petugas menerima pesanan, catat ID petugas tersebut
        if ($request->status === 'processing' && $previousStatus === 'paid') {
            $data['petugas_id'] = auth()->id();
        }

        $order->update($data);

        // Jika pesanan ditolak/dibatalkan, kembalikan stok
        if ($request->status === 'cancelled' && $previousStatus !== 'cancelled') {
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->qty);
                }
            }
        }

        return redirect()->back()->with('success', 'Status pesanan ' . $order->order_code . ' berhasil diperbarui.');
    }

    /**
     * Selesaikan proses picking dan pindahkan ke tahap pengiriman/siap ambil.
     */
    public function completePicking(Order $order)
    {
        // Validasi: hanya pesanan yang sedang diproses yang bisa diselesaikan picking-nya
        if ($order->status !== 'processing') {
            return redirect()->back()->with('error', 'Pesanan tidak dalam status yang benar untuk diselesaikan picking-nya.');
        }

        // Tentukan status selanjutnya berdasarkan tipe pengiriman
        $nextStatus = ($order->shipping_type === 'pickup') ? 'ready_for_pickup' : 'delivering';

        $order->update(['status' => $nextStatus]);

        return redirect()->route('petugas.dashboard', ['tab' => 'picking'])
            ->with('success', 'Proses picking untuk ' . $order->order_code . ' telah selesai. Pesanan kini siap ' . ($nextStatus === 'delivering' ? 'dikirim.' : 'diambil.'));
    }

    /**
     * Validasi kode pickup dari dashboard petugas
     */
    public function validatePickup(Request $request)
    {
        $request->validate([
            'pickup_code' => 'required|string',
            'pickup_note' => 'nullable|string'
        ]);

        $order = Order::where('pickup_code', $request->pickup_code)
            ->where('status', 'ready_for_pickup')
            ->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Kode Pickup tidak valid atau pesanan belum siap diambil.');
        }

        $order->update([
            'status' => 'delivered',
            'pickup_note' => $request->pickup_note
        ]);

        return redirect()->back()->with('success', 'Pesanan ' . $order->order_code . ' berhasil divalidasi dan telah diambil.');
    }
}
