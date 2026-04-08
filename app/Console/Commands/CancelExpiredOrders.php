<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CancelExpiredOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:cancel-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Membatalkan pesanan yang belum dibayar setelah melewati batas waktu';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai pengecekan pesanan kedaluwarsa...');

        // Ambil pesanan yang statusnya 'pending', 
        // memiliki payment_deadline,
        // deadline sudah lewat,
        // dan metode pembayaran BUKAN COD.
        $expiredOrders = Order::where('status', 'pending')
            ->whereNotNull('payment_deadline')
            ->where('payment_deadline', '<', Carbon::now())
            ->whereHas('payment', function($query) {
                $query->where('method', '!=', 'cod');
            })
            ->with('items.product')
            ->get();

        if ($expiredOrders->isEmpty()) {
            $this->info('Tidak ada pesanan kedaluwarsa ditemukan.');
            return 0;
        }

        foreach ($expiredOrders as $order) {
            /** @var \App\Models\Order $order */
            $this->info("Membatalkan pesanan: {$order->order_code}");

            // 1. Mengembalikan stok produk
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->qty);
                    $this->line("   - Stok produk '{$item->product->name}' bertambah (+{$item->qty})");
                }
            }

            // 2. Ubah status order & payment
            $order->update(['status' => 'cancelled']);
            
            if ($order->payment) {
                $order->payment()->update(['status' => 'cancelled']);
            }

            Log::info("Order {$order->order_code} otomatis dibatalkan karena melewati batas waktu.");
        }

        $this->info('Selesai memproses ' . $expiredOrders->count() . ' pesanan.');
        return 0;
    }
}
