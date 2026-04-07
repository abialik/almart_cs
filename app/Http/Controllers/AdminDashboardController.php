<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. Total Transaksi (Keseluruhan)
        $totalOrders = Order::count();

        // 2. Total Pendapatan (Hanya pesanan yang sudah dibayar/dikirim/siap ambil)
        $totalRevenue = Order::whereIn('status', ['paid', 'processing', 'delivering', 'ready_for_pickup', 'delivered'])->sum('total');

        // 3. Produk Tersedia
        $totalProducts = Product::where('stock', '>', 0)->where('is_active', true)->count();

        // 4. Total Member (Customers)
        $totalMembers = User::where('role', 'customer')->count();

        // 5. Transaksi Mingguan (Online vs Offline)
        $weeklyData = [];
        $weeklyLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $weeklyLabels[] = $date->translatedFormat('D');
            $weeklyData[] = Order::whereDate('created_at', $date)->count();
        }

        // 6. Transaksi Bulanan
        $monthlyData = array_fill(0, 12, 0);
        $ordersThisYear = Order::selectRaw('MONTH(created_at) as month, count(*) as total')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->get();
        foreach ($ordersThisYear as $order) {
            $monthlyData[$order->month - 1] = $order->total;
        }

        // 7. Status Pengiriman SAPA (Donut Chart)
        $statusCounts = [
            'Terkirim' => Order::where('status', 'delivered')->count(),
            'Dalam Proses' => Order::whereIn('status', ['paid', 'processing', 'delivering', 'ready_for_pickup'])->count(),
            'Pending' => Order::where('status', 'pending')->count(),
            'Dibatalkan' => Order::where('status', 'cancelled')->count(),
        ];

        // 8. Transaksi Terbaru (Limit 5)
        $recentTransactions = Order::with('customer')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalRevenue',
            'totalProducts',
            'totalMembers',
            'weeklyLabels',
            'weeklyData',
            'monthlyData',
            'statusCounts',
            'recentTransactions'
        ));
    }
}
