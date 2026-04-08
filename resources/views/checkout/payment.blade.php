@extends('layouts.shop')

@section('title', 'Konfirmasi Pembayaran — Almart')

@section('content')

{{-- ===== PAGE HEADER ===== --}}
<div class="bg-gradient-to-r from-pink-500 to-rose-500 py-6 shadow-sm">
    <div class="max-w-6xl mx-auto px-6 flex justify-between items-center text-white">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
            </div>
            <h2 class="text-xl font-bold">Konfirmasi Pembayaran</h2>
        </div>
        <div class="flex items-center gap-2 text-sm text-white/80">
            <a href="{{ route('shop.home') }}" class="hover:text-white transition">Home</a>
            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
            <span>Checkout</span>
            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
            <span class="text-white font-medium">Pembayaran</span>
        </div>
    </div>
</div>

{{-- ===== PROGRESS STEPS ===== --}}
<div class="bg-white border-b border-gray-100 shadow-sm">
    <div class="max-w-6xl mx-auto px-6 py-4">
        <div class="flex items-center justify-center gap-0 max-w-lg mx-auto">
            {{-- Step 1: Order Placed --}}
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-pink-500 flex items-center justify-center shadow-md shadow-pink-200">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-pink-600">Order Dibuat</span>
            </div>
            <div class="w-16 h-0.5 {{ $order->status === 'paid' ? 'bg-pink-400' : 'bg-gray-200' }} mx-2"></div>
            {{-- Step 2: Upload Proof --}}
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full {{ ($order->status === 'paid' || ($order->payment && $order->payment->method === 'cod')) ? 'bg-pink-500 shadow-md shadow-pink-200' : 'bg-pink-100 border-2 border-pink-400' }} flex items-center justify-center">
                    @if($order->status === 'paid' || ($order->payment && $order->payment->method === 'cod'))
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    @else
                        <span class="text-xs font-bold text-pink-500">2</span>
                    @endif
                </div>
                <span class="text-xs font-semibold {{ ($order->status === 'paid' || ($order->payment && $order->payment->method === 'cod')) ? 'text-pink-600' : 'text-gray-500' }}">
                    {{ ($order->payment && $order->payment->method === 'cod') ? 'Pesanan Diterima' : 'Upload Bukti' }}
                </span>
            </div>
            <div class="w-16 h-0.5 bg-gray-200 mx-2"></div>
            {{-- Step 3: Processing --}}
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-gray-100 border-2 border-gray-200 flex items-center justify-center">
                    <span class="text-xs font-bold text-gray-400">3</span>
                </div>
                <span class="text-xs font-semibold text-gray-400">Diproses</span>
            </div>
        </div>
    </div>
</div>

<div class="bg-gray-50 min-h-screen py-10">
<div class="max-w-6xl mx-auto px-6">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl text-sm shadow-sm">
            <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center shrink-0">
                <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
            </div>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

        {{-- ====================== LEFT: ORDER DETAIL (2/3) ====================== --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Order Code Banner --}}
            <div class="bg-gradient-to-r from-pink-500 via-rose-500 to-pink-600 rounded-2xl p-5 text-white shadow-lg shadow-pink-200 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-32 h-32 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="absolute right-6 bottom-0 w-16 h-16 bg-white/5 rounded-full translate-y-1/2"></div>
                <div class="relative z-10">
                    <p class="text-pink-100 text-xs font-semibold uppercase tracking-widest mb-1">Kode Pesanan</p>
                    <p class="text-2xl font-bold tracking-widest mb-3">{{ $order->order_code }}</p>
                    <div class="flex items-center gap-4 text-sm">
                        <div class="flex items-center gap-1.5 text-pink-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $order->created_at->format('d F Y') }}
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="px-2.5 py-1 bg-white/20 backdrop-blur rounded-full text-xs font-semibold capitalize">
                                {{ $order->status }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pickup Code Information (If Pickup) --}}
            @if($order->shipping_type === 'pickup')
            <div class="bg-blue-600 rounded-2xl p-6 text-white shadow-xl shadow-blue-100 relative overflow-hidden group">
                <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:scale-110 transition duration-500"></div>
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                             <div class="w-7 h-7 bg-white/20 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                             </div>
                             <h4 class="text-xs font-black uppercase tracking-widest text-blue-100">Informasi Ambil di Toko</h4>
                        </div>
                        <p class="text-sm text-blue-50 leading-relaxed max-w-sm">Tunjukkan kode ini kepada petugas saat mengambil pesanan setelah status berubah menjadi <span class="font-bold text-white">"Siap Diambil"</span>.</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20 flex flex-col items-center min-w-[160px] cursor-copy active:scale-95 transition-transform" onclick="copyText('{{ $order->pickup_code }}', this)">
                        <p class="text-[10px] font-black text-blue-200 uppercase tracking-widest mb-1">Kode Pickup Anda</p>
                        <p class="text-3xl font-black text-white tracking-[0.2em] font-mono leading-none">{{ $order->pickup_code }}</p>
                        <p class="text-[9px] font-bold text-blue-100 mt-2 flex items-center gap-1 opacity-70">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                            Klik untuk salin
                        </p>
                    </div>
                </div>
            </div>
            @endif

            {{-- Order Items --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        Detail Produk
                    </h3>
                    <span class="text-xs text-gray-400">{{ $order->items->count() }} item</span>
                </div>

                <div class="divide-y divide-gray-50">
                    @foreach($order->items as $item)
                        <div class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50 transition">
                            <div class="w-14 h-14 bg-gray-50 rounded-xl border border-gray-100 flex items-center justify-center shrink-0">
                                <img src="{{ asset($item->product->image) }}"
                                     class="max-h-11 max-w-11 object-contain"
                                     alt="{{ $item->product->name }}">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ $item->product->name }}</p>
                                <div class="flex items-center gap-3 mt-1">
                                    <span class="text-xs text-gray-400">{{ $item->qty }}× Rp {{ number_format($item->price) }}</span>
                                    @if(($item->product->rating ?? 0) > 0)
                                        <div class="flex items-center gap-0.5">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-2.5 h-2.5 {{ $i <= round($item->product->rating) ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <p class="font-bold text-gray-900 text-sm shrink-0">Rp {{ number_format($item->subtotal) }}</p>
                        </div>
                    @endforeach
                </div>

                {{-- Totals --}}
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 space-y-2">
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($order->subtotal) }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>Ongkir</span>
                        <span class="{{ $order->shipping_fee == 0 ? 'text-emerald-600 font-medium' : '' }}">
                            {{ $order->shipping_fee == 0 ? '🚚 Gratis' : 'Rp ' . number_format($order->shipping_fee) }}
                        </span>
                    </div>
                    <div class="flex justify-between text-base font-bold text-gray-900 pt-2 border-t border-gray-200">
                        <span>Total Pembayaran</span>
                        <span class="text-pink-600 text-lg">Rp {{ number_format($order->total) }}</span>
                    </div>
                </div>
            </div>

            {{-- Payment Method + Status --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    Info Pembayaran
                </h3>
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-gray-50 rounded-xl p-3.5">
                        <p class="text-xs text-gray-400 mb-0.5">Metode</p>
                        <p class="font-semibold text-gray-800 capitalize text-sm">
                        {{ $order->payment ? ucwords($order->payment->method === 'transfer' ? 'Transfer Bank' : ($order->payment->method === 'ewallet' ? 'E-Wallet' : ($order->payment->method === 'cod' ? 'Cash On Delivery (COD)' : $order->payment->method))) : '-' }}
                        </p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-3.5">
                        <p class="text-xs text-gray-400 mb-0.5">Status</p>
                        <span class="inline-flex items-center gap-1.5 text-sm font-semibold capitalize
                            {{ ($order->payment && $order->payment->status === 'paid') ? 'text-emerald-600' : 'text-amber-600' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ ($order->payment && $order->payment->status === 'paid') ? 'bg-emerald-500' : 'bg-amber-400' }} animate-pulse"></span>
                            {{ $order->payment ? $order->payment->status : 'unpaid' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Shipping Address --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Alamat Pengiriman
                </h3>
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-pink-50 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div class="text-sm text-gray-600 space-y-0.5">
                        <p class="font-bold text-gray-900">{{ $order->full_name }}</p>
                        <p>{{ $order->address }}</p>
                        <p>{{ $order->city }}, {{ $order->post_code }}</p>
                        <p>{{ $order->province }}</p>
                        <p class="text-gray-500 flex items-center gap-1.5 mt-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            {{ $order->phone }}
                        </p>
                    </div>
                </div>
            </div>

        </div>

        {{-- ====================== RIGHT: PAYMENT SECTION (1/3) ====================== --}}
        <div class="space-y-5">

            @if($order->payment && $order->payment->status === 'paid')

            {{-- ===== ALREADY PAID ===== --}}
            <div class="bg-white rounded-2xl shadow-sm border border-emerald-100 p-6 text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-emerald-400 to-green-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-emerald-200">
                    <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h4 class="font-bold text-emerald-800 text-lg mb-1">Pembayaran Diterima!</h4>
                <p class="text-sm text-gray-500 mb-4 leading-relaxed">Bukti pembayaran kamu sudah kami terima. Pesanan sedang diproses.</p>

                @if($order->payment->proof_of_payment)
                    <div class="mt-4 mb-4">
                        <p class="text-xs text-gray-400 mb-2 uppercase tracking-wide font-semibold">Bukti yang diupload</p>
                        <div class="bg-gray-50 rounded-xl p-2 border border-gray-200">
                            <img src="{{ Storage::url($order->payment->proof_of_payment) }}"
                                 class="mx-auto max-h-48 rounded-lg object-contain"
                                 alt="Bukti Pembayaran">
                        </div>
                    </div>
                @endif

                <a href="{{ route('shop.home') }}"
                   class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-pink-500 to-rose-500 text-white text-sm font-bold rounded-xl hover:from-pink-600 hover:to-rose-600 transition shadow-md shadow-pink-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Belanja Lagi
                </a>
            </div>

            @elseif($order->payment && $order->payment->method === 'cod')

            {{-- ===== COD INFO ===== --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-blue-200">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 0M13 16l2 0m0 0l.5-4.5M15 16h4l1-5H13.5M3 6l1-2h8l1 2"/>
                    </svg>
                </div>
                <h4 class="font-bold text-gray-900 text-lg mb-1">Metode COD Terpilih</h4>
                <p class="text-sm text-gray-500 mb-6 leading-relaxed">
                    Pesanan Anda telah kami terima dengan metode <strong>Bayar di Tempat (COD)</strong>. 
                    Silakan siapkan uang tunai sebesar pas untuk pembayaran saat kurir mengantarkan barang.
                </p>

                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-6">
                    <p class="text-xs text-blue-400 font-semibold uppercase tracking-wide mb-1 text-left">Total yang harus dibayar</p>
                    <p class="text-2xl font-bold text-blue-700 text-left">Rp {{ number_format($order->total) }}</p>
                </div>

                <a href="{{ route('shop.home') }}"
                   class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-pink-500 to-rose-500 text-white text-sm font-bold rounded-xl hover:from-pink-600 hover:to-rose-600 transition shadow-md shadow-pink-200">
                    Belanja Lagi
                </a>
            </div>

            @else

            {{-- ===== BANK / QRIS / EWALLET INFO ===== --}}
            @php
                $isExpired = $order->payment_deadline && now()->gt($order->payment_deadline);
            @endphp

            <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden p-8 sm:p-12 mb-6 relative">
                
                @if($isExpired)
                    {{-- ===== EXPIRED OVERLAY ===== --}}
                    <div class="absolute inset-0 bg-white/90 backdrop-blur-[2px] z-20 flex flex-col items-center justify-center p-8 text-center animate-pulse-slow">
                        <div class="w-20 h-20 bg-rose-100 text-rose-500 rounded-full flex items-center justify-center mb-4">
                            <i data-lucide="clock-alert" class="w-10 h-10"></i>
                        </div>
                        <h3 class="text-2xl font-black text-gray-900 mb-2">Waktu Pembayaran Habis</h3>
                        <p class="text-gray-500 text-sm max-w-xs mb-8">Maaf, pesanan ini telah kedaluwarsa karena melewati batas waktu pembayaran 24 jam.</p>
                        <a href="{{ route('shop.home') }}" class="px-8 py-3 bg-gray-900 text-white rounded-xl font-bold text-sm hover:bg-black transition shadow-lg shadow-gray-200">
                            Kembali ke Toko
                        </a>
                    </div>
                @endif

                @if($order->payment && in_array($order->payment->method, ['qris', 'ewallet']))
                    {{-- ===== QRIS / E-WALLET DESIGN ===== --}}
                    <div class="max-w-md mx-auto space-y-8">
                        
                        <div class="text-center sm:text-left">
                            <h3 class="text-3xl font-black text-gray-900 tracking-tighter mb-2">
                                Pembayaran {{ $order->payment->method === 'qris' ? 'QRIS' : 'GoPay' }}
                            </h3>
                            <p class="text-gray-500 text-sm">Selesaikan pembayaran Anda menggunakan {{ $order->payment->method === 'qris' ? 'QRIS' : 'GoPay' }}.</p>
                        </div>

                        {{-- Countdown Banner --}}
                        <div class="bg-[#FFF4CE] border border-[#FBE8A6] rounded-2xl p-5 flex items-center justify-between shadow-sm">
                            <div class="flex items-center gap-2.5 text-gray-800">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-sm font-bold">Selesaikan pembayaran dalam:</span>
                            </div>
                            <span id="payment-timer" 
                                  data-deadline="{{ $order->payment_deadline ? $order->payment_deadline->isoFormat('Y-MM-DD HH:mm:ss') : '' }}"
                                  class="text-lg font-black text-gray-900 tracking-wider">--:--</span>
                        </div>


                        {{-- Total Amount Box --}}
                        <div class="bg-[#FFE5E1] border border-[#FFD0C8] rounded-3xl p-8 shadow-sm">
                            <p class="text-gray-500 text-sm font-semibold mb-2">Total Pembayaran</p>
                            <p class="text-4xl font-black text-gray-900 tracking-tighter">Rp {{ number_format($order->total) }}</p>
                        </div>

                        {{-- Refined QR CODE Section --}}
                        <div class="relative p-1 bg-gradient-to-br from-emerald-800 via-teal-700 to-emerald-900 rounded-[3rem] shadow-2xl overflow-hidden group">
                            <div class="bg-white rounded-[2.8rem] px-5 py-10 text-center relative z-10">
                                {{-- QR wrapper --}}
                                <div class="relative mx-auto w-full max-w-[18rem] sm:max-w-xs aspect-square flex items-center justify-center mb-8">
                                    {{-- The Actual QR --}}
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=500x500&data={{ $order->order_code }}" 
                                         alt="QR Code" 
                                         class="w-full h-full object-contain transform scale-110">
                                    
                                    {{-- Center Logo Overlay --}}
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="w-16 h-16 bg-white rounded-2xl p-0.5 shadow-lg border border-gray-100 flex items-center justify-center overflow-hidden">
                                            <div class="w-full h-full bg-[#00AADE] rounded-xl flex items-center justify-center">
                                                <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M21 18H3V6h18v12zm-2-10H5v8h14V8zM7 9h10v6H7V9zm2 2v2h6v-2H9z"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-y-1 mt-4">
                                    <p class="text-[13px] text-gray-400 font-medium">Nomor Pesanan</p>
                                    <p class="text-xl font-black text-gray-900 tracking-tight">{{ $order->order_code }}</p>
                                </div>
                            </div>

                            {{-- Decorative light blobs --}}
                            <div class="absolute -top-20 -right-20 w-40 h-40 bg-teal-400/20 blur-[80px] rounded-full"></div>
                            <div class="absolute -bottom-20 -left-20 w-40 h-40 bg-emerald-400/20 blur-[80px] rounded-full"></div>
                        </div>

                    </div>

                @else
                    {{-- ===== TRADITIONAL BANK TRANSFER DESIGN ===== --}}
                    <div class="px-5 pt-5 pb-3">
                        <h3 class="font-bold text-gray-900 text-sm mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M3 10h18M3 7l9-4 9 4M4 10h1v11H4V10zm6 0h1v11h-1V10zm5 0h1v11h-1V10zm5 0h1v11h-1V10z"/>
                            </svg>
                            Rekening Tujuan
                        </h3>

                        {{-- BCA --}}
                        <div class="rounded-xl border border-blue-100 bg-gradient-to-r from-blue-50 to-indigo-50 p-4 mb-3 relative">
                            <div class="flex items-center justify-between mb-1">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 bg-blue-500 rounded flex items-center justify-center">
                                        <span class="text-white text-[9px] font-bold">BCA</span>
                                    </div>
                                    <span class="text-xs font-bold text-blue-700 uppercase tracking-wide">Bank BCA</span>
                                </div>
                                <button onclick="copyText('1234567890', this)"
                                        class="text-xs text-blue-500 hover:text-blue-700 flex items-center gap-1 transition">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                    Salin
                                </button>
                            </div>
                            <p id="bca-number" class="text-xl font-bold text-blue-900 tracking-[0.2em]">1234 5678 90</p>
                            <p class="text-xs text-blue-500 mt-0.5">a.n. Almart Indonesia</p>
                        </div>

                        {{-- Mandiri --}}
                        <div class="rounded-xl border border-yellow-100 bg-gradient-to-r from-yellow-50 to-amber-50 p-4 relative">
                            <div class="flex items-center justify-between mb-1">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 bg-yellow-500 rounded flex items-center justify-center">
                                        <span class="text-white text-[7px] font-bold">MDR</span>
                                    </div>
                                    <span class="text-xs font-bold text-yellow-700 uppercase tracking-wide">Bank Mandiri</span>
                                </div>
                                <button onclick="copyText('9876543210', this)"
                                        class="text-xs text-yellow-600 hover:text-yellow-800 flex items-center gap-1 transition">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                    Salin
                                </button>
                            </div>
                            <p class="text-xl font-bold text-yellow-900 tracking-[0.2em]">9876 5432 10</p>
                            <p class="text-xs text-yellow-600 mt-0.5">a.n. Almart Indonesia</p>
                        </div>
                    </div>

                    {{-- Total to Transfer --}}
                    <div class="mx-5 mb-5 mt-3 bg-pink-50 border border-pink-100 rounded-xl p-3.5 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-pink-400 font-semibold uppercase tracking-wide">Transfer sebesar</p>
                            <p class="text-lg font-bold text-pink-700">Rp {{ number_format($order->total) }}</p>
                        </div>
                        <div class="w-10 h-10 bg-pink-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                @endif
            </div>

            {{-- ===== UPLOAD FORM ===== --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h3 class="font-bold text-gray-900 text-sm mb-1 flex items-center gap-2">
                    <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    Upload Bukti Pembayaran
                </h3>
                <p class="text-xs text-gray-400 mb-4">Format JPG, PNG, atau PDF. Maksimal 5 MB.</p>

                <form action="{{ route('customer.checkout.upload-proof', $order->id) }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf

                    {{-- Drop Zone --}}
                    <div id="dropZone"
                         onclick="document.getElementById('proofInput').click()"
                         class="relative border-2 border-dashed border-gray-200 rounded-xl p-8 text-center cursor-pointer
                                hover:border-pink-400 hover:bg-pink-50/30 transition-all duration-200 mb-4 group">

                        <div id="uploadPlaceholder">
                            <div class="w-14 h-14 bg-gray-100 group-hover:bg-pink-100 rounded-2xl flex items-center justify-center mx-auto mb-3 transition-all">
                                <svg class="w-7 h-7 text-gray-400 group-hover:text-pink-500 transition-colors"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-500 group-hover:text-pink-600 transition-colors">
                                Klik untuk pilih file
                            </p>
                            <p class="text-xs text-gray-300 mt-1">atau drag & drop ke sini</p>
                        </div>

                        {{-- Preview --}}
                        <div id="previewContainer" class="hidden">
                            <img id="imagePreview"
                                 class="mx-auto max-h-40 rounded-xl object-contain border border-gray-200 shadow-sm"
                                 src="" alt="Preview">
                            <p id="fileName" class="text-xs text-gray-500 mt-2 font-medium truncate"></p>
                        </div>

                        <input type="file" id="proofInput" name="proof_of_payment"
                               accept=".jpg,.jpeg,.png,.pdf"
                               class="hidden"
                               onchange="previewFile(this)">
                    </div>

                    @error('proof_of_payment')
                        <p class="text-red-500 text-xs mb-3 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror

                    <button type="submit"
                            class="w-full py-3.5 bg-gradient-to-r from-pink-500 to-rose-500
                                   hover:from-pink-600 hover:to-rose-600 active:scale-[0.98]
                                   text-white font-bold text-sm rounded-xl shadow-md shadow-pink-200 transition-all duration-200
                                   flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                        </svg>
                        Konfirmasi Pembayaran
                    </button>

                    <a href="{{ route('shop.home') }}" 
                       class="w-full mt-3 py-3.5 bg-white border border-gray-200 text-gray-500 font-bold text-xs rounded-xl hover:bg-gray-50 transition-all duration-200 flex items-center justify-center gap-2">
                        Bayar Nanti
                    </a>

                </form>
            </div>

            {{-- Help note --}}
            <div class="flex items-start gap-2.5 px-4 py-3 bg-amber-50 border border-amber-100 rounded-xl text-xs text-amber-700">
                <svg class="w-4 h-4 shrink-0 mt-0.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Pesanan akan diproses setelah bukti pembayaran dikonfirmasi oleh tim kami (maks. 1×24 jam).</span>
            </div>

            @endif

        </div>
    </div>

</div>
</div>

<script>
function previewFile(input) {
    const file = input.files[0];
    if (!file) return;

    document.getElementById('uploadPlaceholder').classList.add('hidden');
    document.getElementById('previewContainer').classList.remove('hidden');
    document.getElementById('fileName').textContent = file.name;

    if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('imagePreview').src = e.target.result;
            document.getElementById('imagePreview').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    } else {
        document.getElementById('imagePreview').classList.add('hidden');
    }
}

// Drag & Drop
const dropZone = document.getElementById('dropZone');
if (dropZone) {
    ['dragenter', 'dragover'].forEach(e => {
        dropZone.addEventListener(e, ev => {
            ev.preventDefault();
            dropZone.classList.add('border-pink-500', 'bg-pink-50/50');
            dropZone.classList.remove('border-gray-200');
        });
    });
    ['dragleave', 'drop'].forEach(e => {
        dropZone.addEventListener(e, ev => {
            ev.preventDefault();
            dropZone.classList.remove('border-pink-500', 'bg-pink-50/50');
            dropZone.classList.add('border-gray-200');
        });
    });
    dropZone.addEventListener('drop', ev => {
        ev.preventDefault();
        const files = ev.dataTransfer.files;
        if (files.length) {
            document.getElementById('proofInput').files = files;
            previewFile(document.getElementById('proofInput'));
        }
    });
}

// Copy to clipboard
function copyText(text, btn) {
    navigator.clipboard.writeText(text).then(() => {
        const original = btn.innerHTML;
        btn.innerHTML = `<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg> Tersalin!`;
        setTimeout(() => btn.innerHTML = original, 2000);
    });
}

// Payment Timer Functionality
function startPaymentTimer() {
    const timerDisplay = document.getElementById('payment-timer');
    if (!timerDisplay) return;

    const deadlineStr = timerDisplay.getAttribute('data-deadline');
    if (!deadlineStr) return;

    const deadline = new Date(deadlineStr).getTime();

    const interval = setInterval(function () {
        const now = new Date().getTime();
        const distance = deadline - now;

        if (distance < 0) {
            timerDisplay.textContent = "EXPIRED";
            clearInterval(interval);
            // Optionally reload to show the expired overlay
            setTimeout(() => window.location.reload(), 1000);
            return;
        }

        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        let display = "";
        if (hours > 0) display += (hours < 10 ? "0" + hours : hours) + ":";
        display += (minutes < 10 ? "0" + minutes : minutes) + ":";
        display += (seconds < 10 ? "0" + seconds : seconds);

        timerDisplay.textContent = display;
    }, 1000);
}

// Initializing Timer if elements exist
document.addEventListener('DOMContentLoaded', function() {
    startPaymentTimer();
});
</script>
<style>
    @keyframes pulse-slow {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.8; }
    }
    .animate-pulse-slow {
        animation: pulse-slow 3s ease-in-out infinite;
    }
</style>

@endsection
