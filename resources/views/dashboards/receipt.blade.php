<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pesanan - {{ $order->order_code }}</title>
    <style>
        @page {
            size: 80mm auto;
            margin: 0;
        }
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            color: #000;
            margin: 0;
            padding: 10px;
            width: 70mm; /* Narrow for thermal printer */
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .mb-2 { margin-bottom: 8px; }
        .mt-2 { margin-top: 8px; }
        .divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
        .item-list {
            width: 100%;
            border-collapse: collapse;
        }
        .item-list td {
            padding: 2px 0;
            vertical-align: top;
        }
        .receipt-header {
            margin-bottom: 15px;
        }
        .store-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 2px;
        }
        .store-info {
            font-size: 10px;
            color: #333;
        }
        .order-info {
            font-size: 11px;
            margin-bottom: 10px;
        }
        .total-row {
            font-size: 14px;
            font-weight: bold;
        }
        @media print {
            .no-print { display: none; }
            body { padding: 0; margin: 0; }
        }
        .print-btn {
            background: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
            font-family: sans-serif;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="no-print text-center">
        <button onclick="window.print()" class="print-btn">CETAK STRUK SEKARANG</button>
    </div>

    <div class="receipt-header text-center">
        <div class="store-name">ALMART</div>
        <div class="store-info">
            Perbelanjaan Modern & Hemat<br>
            Jl. Raya Almart No. 123, Indonesia<br>
            Telp: (021) 1234-5678
        </div>
    </div>

    <div class="divider"></div>

    <div class="order-info">
        <div>No. Struk : {{ $order->order_code }}</div>
        <div>Tanggal   : {{ $order->created_at->format('d/m/Y H:i') }}</div>
        <div>Kasir/Petugas : {{ auth()->user()->name }}</div>
        <div>Pelanggan : {{ $order->customer->name ?? $order->full_name }}</div>
    </div>

    <div class="divider"></div>

    <table class="item-list">
        @foreach($order->items as $item)
        <tr>
            <td colspan="2">{{ $item->product->name ?? 'Produk Dihapus' }}</td>
        </tr>
        <tr>
            <td>{{ $item->qty }} x {{ number_format($item->price, 0, ',', '.') }}</td>
            <td class="text-right">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </table>

    <div class="divider"></div>

    <table class="item-list">
        <tr>
            <td class="font-bold">Total Harga</td>
            <td class="text-right font-bold">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Biaya Kirim</td>
            <td class="text-right">Rp{{ number_format($order->shipping_fee, 0, ',', '.') }}</td>
        </tr>
        <tr class="total-row">
            <td>TOTAL AKHIR</td>
            <td class="text-right">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <div class="order-info">
        <div>Metode Bayar : {{ $order->payment ? strtoupper($order->payment->method) : 'N/A' }}</div>
        <div>Status Pembayaran : {{ $order->payment ? strtoupper($order->payment->status) : 'UNPAID' }}</div>
    </div>

    <div class="divider"></div>

    <div class="text-center mt-2">
        <div class="font-bold">TERIMA KASIH</div>
        <div style="font-size: 10px;">Sudah Berbelanja di Almart</div>
        <div style="font-size: 9px; margin-top: 4px;">{{ $order->shipping_type === 'delivery' ? 'Pesanan Sedang Dikirim' : 'Pesanan Diambil di Toko' }}</div>
    </div>

    <script>
        // Auto print when page loads (optional, typical for receipt printing)
        window.onload = function() {
            // setTimeout(() => { window.print(); }, 500);
        }
    </script>
</body>
</html>
