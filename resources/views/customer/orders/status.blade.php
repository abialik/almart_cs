@extends('layouts.shop')

@section('title', 'Status Pesanan — Almart')

@section('content')

{{-- ===== TOP STATUS BAR ===== --}}
<div class="bg-pink-500 py-3 shadow-sm sticky top-[72px] z-40">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-white text-sm font-black uppercase tracking-[0.2em] text-center sm:text-left">Status Pesanan</h2>
    </div>
</div>

<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-6">
        
        <div class="flex flex-col lg:flex-row gap-8">
            
            {{-- SIDEBAR --}}
            <aside class="w-full lg:w-72 shrink-0">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 space-y-8">
                    
                    {{-- User Profile --}}
                    <div class="flex items-center gap-4 border-b border-gray-50 pb-6">
                        <div class="w-12 h-12 bg-gradient-to-r from-pink-500 to-rose-600 rounded-full flex items-center justify-center text-white font-black shadow-md">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 leading-tight">{{ auth()->user()->name }}</h3>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Pelanggan</p>
                        </div>
                    </div>

                    {{-- Navigation --}}
                    <nav class="space-y-6">
                        <div>
                            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Transaksi</h4>
                            <ul class="space-y-3">
                                <li>
                                    <a href="{{ route('customer.orders.status', ['s' => 'all']) }}" class="flex items-center justify-between text-sm {{ !$status || $status === 'all' ? 'text-pink-600 font-bold' : 'text-gray-500 hover:text-gray-900' }} transition">
                                        Semua
                                    </a>
                                </li>
                                @php
                                    $statuses = [
                                        'pending'    => 'Menunggu Pembayaran',
                                        'processing' => 'Sedang Diproses',
                                        'delivering' => 'Dikirim',
                                        'completed'  => 'Selesai',
                                        'cancelled'  => 'Ditolak / Batal',
                                    ];
                                @endphp
                                @foreach($statuses as $key => $label)
                                    <li>
                                        <a href="{{ route('customer.orders.status', ['s' => $key]) }}" class="flex items-center justify-between text-sm {{ $status === $key ? 'text-pink-600 font-bold' : 'text-gray-500 hover:text-gray-900' }} transition">
                                            {{ $label }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div>
                            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Akun Saya</h4>
                            <ul class="space-y-3">
                                <li>
                                    <a href="{{ route('profile.edit') }}" class="text-sm text-gray-500 hover:text-gray-900 transition">Pengaturan Akun</a>
                                </li>
                                <li>
                                    <a href="{{ route('customer.wishlist.index') }}" class="text-sm text-gray-500 hover:text-gray-900 transition">Wishlist</a>
                                </li>
                            </ul>
                        </div>
                    </nav>

                </div>
            </aside>

            {{-- MAIN CONTENT --}}
            <main class="flex-1 space-y-8">
                
                {{-- Horizontal Filter Tabs (Desktop) --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-2 overflow-x-auto">
                    <div class="flex items-center gap-1 min-w-max">
                        <a href="{{ route('customer.orders.status', ['s' => 'all']) }}" 
                           class="px-6 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition duration-300 {{ !$status || $status === 'all' ? 'bg-gray-900 text-white shadow-lg shadow-gray-200' : 'text-gray-400 hover:bg-gray-50' }}">
                            Tercipta
                        </a>
                        @foreach($statuses as $key => $label)
                            <a href="{{ route('customer.orders.status', ['s' => $key]) }}" 
                               class="inline-block px-6 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition duration-300 {{ $status === $key ? 'bg-pink-500 text-white shadow-lg shadow-pink-100' : 'text-gray-400 hover:bg-gray-50' }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Order List --}}
                <div class="space-y-6">
                    @forelse($orders as $order)
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:shadow-gray-200/50 transition duration-500">
                            
                            {{-- Order Header --}}
                            <div class="bg-gray-50/50 px-8 py-4 border-b border-gray-100 flex flex-wrap justify-between items-center gap-4">
                                <div class="flex items-center gap-4">
                                    <p class="text-xs font-bold text-gray-900">{{ $order->created_at->format('d M Y - H:i') }} WIB</p>
                                    @php
                                        $statusLabels = [
                                            'pending'    => ['label' => 'Menunggu Pembayaran', 'class' => 'bg-amber-100 text-amber-700'],
                                            'paid'       => ['label' => 'Sudah Dibayar', 'class' => 'bg-emerald-100 text-emerald-700'],
                                            'processing' => ['label' => 'Sedang Diproses', 'class' => 'bg-blue-100 text-blue-700'],
                                            'delivering' => ['label' => 'Dalam Pengiriman', 'class' => 'bg-purple-100 text-purple-700'],
                                            'ready_for_pickup' => ['label' => 'Siap Diambil', 'class' => 'bg-emerald-100 text-emerald-700'],
                                            'delivered'  => ['label' => 'Selesai', 'class' => 'bg-gray-100 text-gray-700'],
                                            'cancelled'  => ['label' => 'Dibatalkan / Ditolak', 'class' => 'bg-red-100 text-red-700'],
                                        ];
                                        $currentStatus = $statusLabels[$order->status] ?? ['label' => $order->status, 'class' => 'bg-gray-100 text-gray-700'];
                                    @endphp
                                    <span class="px-3 py-1 {{ $currentStatus['class'] }} text-[9px] font-black uppercase tracking-widest rounded-full">
                                        {{ $currentStatus['label'] }}
                                    </span>
                                    @if($order->shipping_type === 'pickup')
                                        <span class="px-3 py-1 bg-blue-50 text-blue-600 border border-blue-100 text-[9px] font-black uppercase tracking-widest rounded-full flex items-center gap-1">
                                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                                            Ambil di Toko
                                        </span>
                                    @endif
                                </div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                                    Bayar Sebelum <span class="text-red-500">{{ $order->created_at->addDay()->format('d M Y, H:i') }} WIB</span>
                                </p>
                            </div>

                            {{-- Order Body --}}
                            <div class="p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-8">
                                <div class="flex items-center gap-6">
                                    <div class="w-14 h-14 bg-gray-50 rounded-2xl flex items-center justify-center p-2 border border-gray-100">
                                        @if($order->items->isNotEmpty())
                                            <img src="{{ asset($order->items->first()->product->image) }}" class="max-w-full max-h-full object-contain">
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="font-black text-gray-900 tracking-tight">{{ auth()->user()->name }}</h4>
                                        <p class="text-xs text-gray-400 font-bold mt-1">{{ $order->order_code }}</p>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Total Belanja {{ $order->items->count() }} Produk</p>
                                    <p class="text-xl font-black text-red-500 tracking-tighter">Rp {{ number_format($order->total) }}</p>
                                </div>
                            </div>

                            {{-- Order Footer (Actions) --}}
                            <div class="px-8 pb-8 pt-2 flex justify-end gap-3">
                                <a href="{{ route('customer.orders.show', $order->id) }}" class="px-8 py-3 bg-white border border-red-500 text-red-500 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-red-50 transition duration-300">
                                    Lihat Detail
                                </a>
                                @if($order->status === 'pending')
                                    <a href="{{ route('customer.checkout.payment', $order->id) }}" class="px-8 py-3 bg-red-500 text-white text-[10px] font-black uppercase tracking-widest rounded-xl shadow-lg shadow-red-100 hover:bg-red-600 transition duration-300">
                                        Panduan Pembayaran
                                    </a>
                                @endif
                            </div>

                        </div>
                    @empty
                        <div class="bg-white rounded-3xl p-20 text-center border border-gray-100 shadow-sm">
                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            </div>
                            <h3 class="text-gray-900 font-black text-xl mb-2">Belum ada pesanan</h3>
                            <p class="text-gray-400 text-sm mb-8">Anda belum memiliki riwayat pesanan untuk status ini.</p>
                            <a href="{{ route('shop.home') }}" class="inline-block px-10 py-4 bg-gray-900 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-gray-800 transition">
                                Belanja Sekarang
                            </a>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if($orders->hasPages())
                <div class="mt-8 flex justify-center">
                    {{ $orders->links() }}
                </div>
                @endif

            </main>

        </div>

    </div>
</div>

@endsection
