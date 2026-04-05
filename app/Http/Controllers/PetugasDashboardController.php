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

        // Parameter Filter Status (Semua, Baru, Diproses, Selesai)
        $filter = $request->get('filter', 'semua');

        // Query Dasar Pesanan
        $query = Order::with(['items.product', 'customer', 'payment'])->latest();

        // Data Statistik (Kotak Scoreboard)
        $countBaru = (clone $query)->where('status', 'paid')->count();
        $countDiproses = (clone $query)->where('status', 'processing')->count();
        $countSelesai = (clone $query)->where('status', 'delivered')->whereDate('updated_at', today())->count();
        $countSemua = $countBaru + $countDiproses; // Jika Selesai dikecualikan dari 'Semua' atau bisa digabung

        // Filter berdasarkan tab aktif dan filter aktif
        if ($filter === 'baru') {
            $query->where('status', 'paid');
        } elseif ($filter === 'diproses') {
             $query->where('status', 'processing');
        } elseif ($filter === 'selesai') {
             $query->where('status', 'delivered');
        } else {
             // Default 'semua' menampilkan pekerjaan aktif
             $query->whereIn('status', ['paid', 'processing']);
        }

        $orders = $query->paginate(20)->withQueryString();

        return view('dashboards.petugas', compact(
            'tab', 'filter', 'orders', 
            'countBaru', 'countDiproses', 'countSelesai', 'countSemua'
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
}
