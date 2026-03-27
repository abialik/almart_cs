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
        // 1. Total Transaksi Hari Ini
        $totalOrdersToday = Order::whereDate('created_at', Carbon::today())->count();

        // 2. Total Pendapatan (Pesanan yang Sukses)
        $totalRevenue = Order::where('status', 'Diterima')->orWhere('status', 'Dikirim')->sum('total');

        // 3. Produk Tersedia
        $totalProducts = Product::where('stock', '>', 0)->where('is_active', true)->count();

        // 4. Total Member (Customers)
        $totalMembers = User::where('role', 'customer')->count();

        // 5. Transaksi Mingguan (Online vs Offline - assuming all online for now unless is_cod is checked but we don't have offline POS)
        // Let's just group orders by last 7 days
        $weeklyData = [];
        $weeklyLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $weeklyLabels[] = $date->translatedFormat('D');
            $weeklyData[] = Order::whereDate('created_at', $date)->count();
        }

        // 6. Transaksi Bulanan (Pesanan tahun ini per bulan)
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
            'Terkirim' => Order::where('status', 'Diterima')->count(),
            'Dalam Proses' => Order::whereIn('status', ['Diproses', 'Dikirim'])->count(),
            'Pending' => Order::where('status', 'Baru')->count(),
            'Dibatalkan' => Order::where('status', 'Dibatalkan')->count(),
        ];

        // 8. Transaksi Terbaru (Limit 5)
        $recentTransactions = Order::with('customer')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalOrdersToday',
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
