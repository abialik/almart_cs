@extends('layouts.shop')

@section('title', 'Detail Pesanan ' . $order->order_code . ' — Almart')

@section('content')

@php
    $statusClasses = [
        'pending'    => 'from-amber-500 to-orange-600',
        'paid'       => 'from-emerald-500 to-green-600',
        'processing' => 'from-blue-500 to-indigo-600',
        'delivered'  => 'from-purple-500 to-violet-600',
        'cancelled'  => 'from-rose-500 to-pink-600',
    ];
    $bannerClass = $statusClasses[$order->status] ?? 'from-gray-500 to-gray-600';
@endphp

{{-- ===== PAGE HEADER ===== --}}
<div class="bg-gradient-to-r {{ $bannerClass }} py-8 shadow-sm">
    <div class="max-w-6xl mx-auto px-6 flex flex-col sm:flex-row justify-between items-center text-white gap-4">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <a href="{{ route('customer.orders.index') }}" class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center hover:bg-white/30 transition">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <h2 class="text-2xl font-bold">Detail Pesanan</h2>
            </div>
            <p class="text-white/80 text-sm font-medium tracking-wide">{{ $order->order_code }} • Dipesan pada {{ $order->created_at->format('d M Y, H:i') }}</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="px-5 py-2 bg-white/20 backdrop-blur-md rounded-full text-xs font-black uppercase tracking-widest">
                {{ $order->status }}
            </span>
            @if(in_array($order->status, ['paid', 'processing', 'delivering', 'ready_for_pickup', 'delivered']))
                <a href="{{ route('customer.orders.receipt', $order->id) }}" target="_blank" 
                    class="px-5 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-md text-white text-xs font-black rounded-full border border-white/20 transition tracking-widest uppercase flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    STRUK DIGITAL
                </a>
            @endif
            @if($order->status === 'pending')
                <div class="flex items-center gap-3">
                    <form id="cancel-order-form" action="{{ route('customer.orders.cancel', $order->id) }}" method="POST" class="hidden">
                        @csrf
                    </form>
                    <button type="button" 
                            id="btn-cancel-order"
                            onclick="confirmCancelOrder()" 
                            class="px-5 py-2 bg-rose-500/10 text-rose-100 border border-rose-400/30 text-xs font-black rounded-full hover:bg-rose-500/20 transition tracking-widest uppercase cursor-pointer">
                        BATALKAN
                    </button>
                    <a href="{{ route('customer.checkout.payment', $order->id) }}" 
                        class="px-5 py-2 bg-white text-gray-900 text-xs font-black rounded-full shadow-lg hover:bg-gray-100 transition tracking-widest uppercase">
                        BAYAR SEKARANG
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- ===== PAYMENT DEADLINE WARNING ===== --}}
@if($order->status === 'pending' && $order->payment_deadline)
<div class="bg-amber-50 border-y border-amber-100 py-3">
    <div class="max-w-6xl mx-auto px-6 flex items-center justify-between">
        <div class="flex items-center gap-3 text-amber-800">
            <svg class="w-5 h-5 text-amber-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <p class="text-sm font-bold">Segera lunasi pembayaran sebelum: <span class="text-amber-600 tracking-tight">{{ $order->payment_deadline->format('d M Y, H:i') }}</span></p>
        </div>
        <div id="countdown" class="text-sm font-black text-amber-600 tabular-nums"></div>
    </div>
</div>
@endif

<div class="bg-gray-50 min-h-screen py-10">
    <div class="max-w-6xl mx-auto px-6">
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- LEFT COLUMN: ITEMS & STATUS --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- LIST ITEMS --}}
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-8 py-5 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="font-bold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            Barang yang Dibeli
                        </h3>
                        <span class="px-3 py-1 bg-gray-100 rounded-full text-[10px] font-bold text-gray-500 uppercase tracking-tighter">
                            {{ $order->items->count() }} Produk
                        </span>
                    </div>

                    <div class="divide-y divide-gray-50">
                        @foreach($order->items as $item)
                            <div class="px-8 py-6 flex items-center justify-between group hover:bg-gray-50/50 transition duration-200">
                                <div class="flex items-center gap-5">
                                    <div class="w-16 h-16 bg-gray-50 rounded-2xl border border-gray-100 flex items-center justify-center p-2 shrink-0 group-hover:scale-105 transition duration-300">
                                        <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}" class="max-w-full max-h-full object-contain">
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900">{{ $item->product->name }}</p>
                                        <p class="text-sm text-gray-400 mt-0.5">{{ $item->qty }} × Rp {{ number_format($item->price) }}</p>
                                        
                                        {{-- REVIEW FORM TRIGGER --}}
                                        @if($order->status === 'delivered')
                                            @php
                                                $hasReviewed = \App\Models\Review::where('user_id', auth()->id())
                                                    ->where('product_id', $item->product_id)
                                                    ->where('order_id', $order->id)
                                                    ->exists();
                                            @endphp
                                            
                                            <div class="mt-4">
                                                @if(!$hasReviewed)
                                                    <button onclick="openReviewModal('{{ $item->product_id }}', '{{ $item->product->name }}')" 
                                                            class="text-[10px] font-black text-rose-500 uppercase tracking-widest bg-rose-50 px-4 py-2 rounded-xl hover:bg-rose-100 transition">
                                                        Beri Ulasan
                                                    </button>
                                                @else
                                                    <span class="text-[10px] font-black text-emerald-500 uppercase tracking-widest bg-emerald-50 px-4 py-2 rounded-xl flex items-center gap-1.5 w-fit">
                                                        <i data-lucide="check-circle" class="w-3.5 h-3.5"></i> Sudah Diulas
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <p class="font-black text-gray-900">Rp {{ number_format($item->subtotal) }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-100 space-y-3">
                        <div class="flex justify-between text-sm text-gray-500">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($order->subtotal) }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-500">
                            <span>Biaya Pengiriman</span>
                            <span class="text-green-600 font-bold tracking-tight">
                                {{ $order->shipping_fee == 0 ? 'GRATIS' : 'Rp ' . number_format($order->shipping_fee) }}
                            </span>
                        </div>
                        <div class="flex justify-between items-end pt-3 border-t border-gray-200">
                            <span class="text-sm font-bold text-gray-900">Total Akhir</span>
                            <span class="text-2xl font-black text-green-600 tracking-tight">Rp {{ number_format($order->total) }}</span>
                        </div>
                    </div>
                </div>

                {{-- STATUS TRACKING (Simplified for Customer) --}}
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                     <h3 class="font-bold text-gray-900 mb-8 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Status Pesanan
                    </h3>

                    {{-- SAPA / PETUGAS INFO --}}
                    @if(in_array($order->status, ['processing', 'delivering', 'ready_for_pickup', 'delivered']))
                    <div class="mb-10 p-5 rounded-3xl bg-gray-900 shadow-xl relative overflow-hidden group">
                        <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-pink-500/10 rounded-full blur-2xl group-hover:bg-pink-500/20 transition-all duration-700"></div>
                        <div class="relative z-10 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center border border-white/10">
                                    <i data-lucide="user-check" class="w-6 h-6 text-pink-400"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Petugas SAPA</p>
                                    <h4 class="text-sm font-black text-white tracking-tight uppercase">{{ $order->petugas->name ?? 'Tim Almart' }}</h4>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="px-3 py-1 rounded-full bg-pink-500/20 text-pink-400 text-[9px] font-black uppercase tracking-widest border border-pink-500/30">
                                    Siap Melayani
                                </span>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="relative pl-8 space-y-10 before:content-[''] before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-[2px] before:bg-gray-100">
                        
                        {{-- Step: Placed --}}
                        <div class="relative">
                            <div class="absolute -left-[30px] top-1 w-6 h-6 rounded-full bg-green-500 border-4 border-green-50 shadow-sm z-10"></div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">Pesanan Dibuat</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        {{-- Step: Paid --}}
                        <div class="relative">
                            @if(in_array($order->status, ['paid', 'processing', 'delivered']))
                                <div class="absolute -left-[30px] top-1 w-6 h-6 rounded-full bg-green-500 border-4 border-green-50 shadow-sm z-10"></div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900">Pembayaran Terkonfirmasi</p>
                                    <p class="text-xs text-gray-400 mt-0.5">Sudah diverifikasi oleh sistem</p>
                                </div>
                            @else
                                <div class="absolute -left-[30px] top-1 w-6 h-6 rounded-full bg-gray-200 border-4 border-white z-10"></div>
                                <div class="opacity-50">
                                    <p class="text-sm font-bold text-gray-400">Menunggu Pembayaran</p>
                                    <p class="text-xs text-gray-400 mt-0.5">Silakan upload bukti pembayaran</p>
                                </div>
                            @endif
                        </div>

                        {{-- Step: Processing --}}
                        <div class="relative">
                            @if(in_array($order->status, ['processing', 'delivering', 'ready_for_pickup', 'delivered']))
                                <div class="absolute -left-[30px] top-1 w-6 h-6 rounded-full bg-green-500 border-4 border-green-50 shadow-sm z-10"></div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900">Sedang Diproses</p>
                                    <p class="text-xs text-gray-400 mt-0.5">Tim kami sedang menyiapkan barang Anda</p>
                                </div>
                            @else
                                <div class="absolute -left-[30px] top-1 w-6 h-6 rounded-full bg-gray-100 border-4 border-white z-10"></div>
                                <div class="opacity-50">
                                    <p class="text-sm font-bold text-gray-400">Diproses</p>
                                </div>
                            @endif
                        </div>

                        {{-- Step: Delivering / Ready for Pickup --}}
                        <div class="relative">
                            @if(in_array($order->status, ['delivering', 'ready_for_pickup', 'delivered']))
                                <div class="absolute -left-[30px] top-1 w-6 h-6 rounded-full bg-green-500 border-4 border-green-50 shadow-sm z-10"></div>
                                <div>
                                    @if($order->shipping_type === 'pickup')
                                        <p class="text-sm font-bold text-gray-900">Siap Diambil</p>
                                        <p class="text-xs text-gray-400 mt-0.5">Barang sudah ready di toko Almart</p>
                                    @else
                                        <p class="text-sm font-bold text-gray-900">Sedang Dikirim</p>
                                        <p class="text-xs text-gray-400 mt-0.5">Pesanan dalam perjalanan ke lokasi Anda</p>
                                        @if($order->shipped_at)
                                            <p class="text-[10px] text-green-600 font-bold mt-1 uppercase tracking-wider">Mulai dikirim: {{ $order->shipped_at->format('H:i') }} WIB</p>
                                            @if($order->status === 'delivering')
                                                <p class="text-[10px] text-blue-600 font-bold mt-0.5 uppercase tracking-wider flex items-center gap-1.5">
                                                    <span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-pulse"></span>
                                                    Durasi: <span id="delivery-timer" data-start="{{ $order->shipped_at->toIso8601String() }}">...</span>
                                                </p>
                                            @endif
                                        @endif
                                    @endif
                                </div>
                            @else
                                <div class="absolute -left-[30px] top-1 w-6 h-6 rounded-full bg-gray-100 border-4 border-white z-10"></div>
                                <div class="opacity-50">
                                    <p class="text-sm font-bold text-gray-400">{{ $order->shipping_type === 'pickup' ? 'Siap Diambil' : 'Dikirim' }}</p>
                                </div>
                            @endif
                        </div>

                        {{-- Step: Delivered --}}
                        <div class="relative">
                            @if($order->status === 'delivered')
                                <div class="absolute -left-[30px] top-1 w-6 h-6 rounded-full bg-green-500 border-4 border-green-50 shadow-sm z-10"></div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900">Selesai / Terkirim</p>
                                    <p class="text-xs {{ $order->completed_at ? 'text-green-600 font-medium' : 'text-gray-400' }} mt-0.5">
                                        {{ $order->completed_at ? 'Berhasil diterima pada ' . $order->completed_at->format('d M Y, H:i') . ' WIB' : 'Pesanan sudah sampai di tujuan' }}
                                    </p>
                                </div>
                            @elseif($order->status === 'cancelled')
                                <div class="absolute -left-[30px] top-1 w-6 h-6 rounded-full bg-gray-100 border-4 border-white z-10"></div>
                                <div class="opacity-50">
                                    <p class="text-sm font-bold text-gray-400">Diterima</p>
                                </div>
                            @else
                                <div class="absolute -left-[30px] top-1 w-6 h-6 rounded-full bg-gray-100 border-4 border-white z-10"></div>
                                <div class="opacity-50">
                                    <p class="text-sm font-bold text-gray-400">Diterima</p>
                                </div>
                            @endif
                        </div>

                        {{-- Step: Cancelled (Special Case) --}}
                        @if($order->status === 'cancelled')
                        <div class="relative">
                            <div class="absolute -left-[30px] top-1 w-6 h-6 rounded-full bg-rose-500 border-4 border-rose-50 shadow-sm z-10"></div>
                            <div>
                                <p class="text-sm font-bold text-rose-600 uppercase tracking-tight">Pesanan Dibatalkan / Ditolak</p>
                                <p class="text-xs text-gray-400 mt-0.5">Mohon maaf, pesanan Anda tidak dapat dilanjutkan oleh pihak Almart.</p>
                                <div class="mt-4 p-4 bg-rose-50 rounded-2xl border border-rose-100 flex items-start gap-3">
                                     <svg class="w-5 h-5 text-rose-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                     <p class="text-xs text-rose-700 font-medium leading-relaxed">Dana yang sudah dibayarkan (jika ada) akan dikembalikan melalui saldo akun atau metode pembayaran asal. Silakan hubungi Customer Service kami untuk bantuan lebih lanjut.</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        {{-- Step: Return (If Exists) --}}
                        @if($order->returns->isNotEmpty())
                            @foreach($order->returns as $return)
                            <div class="relative">
                                @php
                                    $returnColor = [
                                        'pending' => 'bg-amber-500 border-amber-50',
                                        'approved' => 'bg-blue-500 border-blue-50',
                                        'rejected' => 'bg-rose-500 border-rose-50',
                                        'completed' => 'bg-green-500 border-green-50'
                                    ][$return->status] ?? 'bg-gray-500 border-gray-50';
                                @endphp
                                <div class="absolute -left-[30px] top-1 w-6 h-6 rounded-full {{ $returnColor }} border-4 shadow-sm z-10"></div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900 uppercase">Pengajuan Pengembalian ({{ $return->status }})</p>
                                    <p class="text-xs text-gray-400 mt-0.5">Diajukan pada {{ $return->created_at->format('d M Y, H:i') }}</p>
                                    @if($return->admin_note)
                                        <p class="text-xs text-gray-600 mt-2 bg-gray-50 p-2 rounded-lg italic">Note: {{ $return->admin_note }}</p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        @endif

                    </div>
                </div>

            </div>

            {{-- RIGHT COLUMN: ADDRESS & PAYMENT --}}
            <div class="space-y-6">
                
                {{-- SHIPPING / PICKUP INFO --}}
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                     @if($order->shipping_type === 'pickup')
                        <h3 class="font-bold text-gray-900 mb-5 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                            </svg>
                            Informasi Ambil di Toko
                        </h3>
                        <div class="bg-blue-50 rounded-2xl p-6 border border-blue-100 mb-4 text-center">
                            <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-1">Kode Pickup Anda</p>
                            <p class="text-3xl font-black text-blue-700 tracking-[0.2em] font-mono leading-none">{{ $order->pickup_code }}</p>
                            <p class="text-[11px] font-bold text-blue-500 mt-4 leading-relaxed">Tunjukkan kode unik ini kepada petugas kasir Almart untuk mengambil barang belanjaan Anda.</p>
                        </div>
                        <div class="text-sm text-gray-600 leading-relaxed border-t border-gray-50 pt-4">
                            <p class="font-black text-gray-900 text-base mb-1 uppercase tracking-tight">{{ $order->full_name }}</p>
                            <p class="text-xs text-gray-400 flex items-center gap-2">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                {{ $order->phone }}
                            </p>
                            <div class="mt-4 p-3 bg-gray-50 rounded-xl border border-gray-100 flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-gray-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <p class="text-[11px] text-gray-500 italic">Pesanan dapat diambil di gerai Almart terdekat setelah status berubah menjadi "Siap Diambil".</p>
                            </div>
                        </div>
                     @else
                        <h3 class="font-bold text-gray-900 mb-5 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                            Alamat Pengiriman
                        </h3>
                        <div class="text-sm text-gray-600 leading-relaxed">
                            <p class="font-black text-gray-900 text-base mb-2 uppercase tracking-tight">{{ $order->full_name }}</p>
                            <p>{{ $order->address }}</p>
                            <p>{{ $order->city }}, {{ $order->post_code }}</p>
                            <p>{{ $order->province }}</p>
                            <div class="mt-4 pt-4 border-t border-gray-50 flex items-center gap-2 text-gray-400 italic">
                                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1.01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                {{ $order->phone }}
                            </div>
                        </div>
                     @endif
                </div>

                {{-- PAYMENT INFO --}}
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <h3 class="font-bold text-gray-900 mb-5 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        Metode Pembayaran
                    </h3>
                    <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 mb-6">
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mb-1">Terpilih</p>
                        <p class="font-bold text-gray-800 text-sm tracking-wide">
                            {{ $order->payment ? ucwords($order->payment->method === 'transfer' ? 'Transfer Bank' : ($order->payment->method === 'ewallet' ? 'E-Wallet' : $order->payment->method)) : '-' }}
                        </p>
                        <div class="mt-2 flex items-center gap-2">
                             <span class="w-2 h-2 rounded-full {{ ($order->payment && $order->payment->status === 'paid') ? 'bg-green-500' : 'bg-amber-400' }}"></span>
                             <span class="text-xs font-bold uppercase {{ ($order->payment && $order->payment->status === 'paid') ? 'text-green-600' : 'text-amber-600' }}">
                                {{ $order->payment ? $order->payment->status : 'unpaid' }}
                             </span>
                        </div>
                    </div>

                    @if($order->payment && $order->payment->proof_of_payment)
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mb-3">Bukti Pembayaran</p>
                        <div class="rounded-2xl overflow-hidden border border-gray-100 shadow-sm">
                            <img src="{{ Storage::url($order->payment->proof_of_payment) }}" class="w-full h-auto" alt="Bukti">
                        </div>
                    @endif
                </div>

                {{-- NEED HELP? --}}
                <div class="bg-blue-600 rounded-3xl p-8 text-white relative overflow-hidden shadow-xl shadow-blue-100">
                    <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/10 rounded-full"></div>
                    <div class="relative z-10">
                        <p class="font-black text-lg mb-2">Butuh Bantuan?</p>
                        <p class="text-blue-100 text-sm leading-relaxed mb-6">Hubungi Customer Service atau ajukan pengembalian jika barang bermasalah.</p>
                        <div class="flex flex-col gap-3">
                            <a href="https://wa.me/62895347920306?text={{ urlencode('Halo Admin Almart, saya butuh bantuan untuk pesanan dengan kode: ' . $order->order_code) }}" 
                               target="_blank"
                               class="inline-flex items-center justify-center gap-2 text-xs font-black bg-white text-blue-600 px-6 py-3 rounded-xl hover:bg-blue-50 transition uppercase tracking-widest shadow-sm">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 448 512"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.7 17.9 69.4 27.3 107.1 27.3 122.3 0 222-99.6 222-222 0-59.3-23.1-115.1-65.1-157.1zM223.9 445.5c-33.1 0-65.7-8.9-94.1-25.7l-6.7-4-69.8 18.3 18.7-68.1-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.5-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-5.6-2.8-23.5-8.7-44.8-27.7-16.6-14.8-27.8-33-31.1-38.6-3.3-5.6-.4-8.6 2.5-11.4 2.5-2.5 5.6-6.5 8.3-9.8 2.8-3.3 3.7-5.6 5.6-9.3 1.8-3.7.9-7-.5-9.8-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 13.2 5.8 23.5 9.2 31.6 11.8 13.3 4.2 25.4 3.6 35 2.2 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>
                                Chat Admin via WA
                            </a>
                            @if(in_array($order->status, ['paid', 'processing', 'delivered']) && $order->returns->isEmpty())
                                <a href="{{ route('customer.returns.create', $order->id) }}" class="inline-flex items-center justify-center gap-2 text-xs font-black bg-rose-500 text-white border border-rose-400 px-6 py-3 rounded-xl hover:bg-rose-600 transition uppercase tracking-widest shadow-lg shadow-rose-100">
                                    Ajukan Pengembalian
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

@endsection

@push('scripts')
{{-- REVIEW MODAL --}}
<div id="reviewModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"></div>
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative w-full max-w-xl bg-white rounded-[2.5rem] shadow-2xl overflow-hidden transform transition-all">
            
            <form action="{{ route('customer.reviews.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <input type="hidden" name="product_id" id="review_product_id">

                <div class="px-8 py-8">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-2xl font-black text-gray-900 tracking-tighter">Beri Ulasan Produk</h3>
                            <p class="text-sm text-gray-500 font-medium" id="review_product_name">Nama Produk</p>
                        </div>
                        <button type="button" onclick="closeReviewModal()" class="w-10 h-10 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 hover:text-gray-900 transition">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>

                    {{-- Rating --}}
                    <div class="mb-10 text-center">
                        <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Bagaimana kualitas produk ini?</p>
                        <div class="flex items-center justify-center gap-3">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" name="rating" id="star-{{ $i }}" value="{{ $i }}" class="hidden peer">
                                <label for="star-{{ $i }}" onclick="setRating({{ $i }})" class="star-label cursor-pointer transition duration-200">
                                    <i data-lucide="star" class="w-10 h-10 text-gray-200 hover:scale-110 transition"></i>
                                </label>
                            @endfor
                        </div>
                        <p id="rating-text" class="text-sm font-bold text-rose-500 mt-4 h-5"></p>
                    </div>

                    {{-- Comment --}}
                    <div class="mb-8">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 block">Bagikan pengalaman Anda</label>
                        <textarea name="comment" rows="4" 
                                  placeholder="Contoh: Buahnya sangat segar, pengiriman cepat sekali!..."
                                  class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:bg-white focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition outline-none text-sm"></textarea>
                    </div>

                    {{-- Photo --}}
                    <div class="mb-10">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 block">Unggah Foto Produk (Opsional)</label>
                        <div class="relative group">
                            <input type="file" name="photo" id="review_photo" accept="image/*" class="hidden" onchange="previewImage(this)">
                            <label for="review_photo" class="w-full flex flex-col items-center justify-center gap-2 py-8 bg-gray-50 border-2 border-dashed border-gray-200 rounded-2xl cursor-pointer group-hover:border-rose-300 group-hover:bg-rose-50 transition border-spacing-4">
                                <div id="photo_preview_container" class="hidden mb-2">
                                    <img id="photo_preview" src="#" class="w-24 h-24 rounded-xl object-cover border-2 border-white shadow-md">
                                </div>
                                <div id="upload_placeholder" class="flex flex-col items-center">
                                    <i data-lucide="camera" class="w-10 h-10 text-gray-400 mb-2 group-hover:text-rose-500"></i>
                                    <span class="text-xs font-bold text-gray-400 group-hover:text-rose-600">Tekan untuk unggah foto</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4 bg-rose-500 text-white rounded-2xl font-black uppercase tracking-widest shadow-xl shadow-rose-100 hover:bg-rose-600 transition duration-300">
                        Kirim Ulasan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<style>
    .star-label.active i {
        fill: #f43f5e;
        color: #f43f5e;
    }
</style>

<script>
    function openReviewModal(productId, productName) {
        document.getElementById('review_product_id').value = productId;
        document.getElementById('review_product_name').innerText = productName;
        document.getElementById('reviewModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeReviewModal() {
        document.getElementById('reviewModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function setRating(rating) {
        const labels = document.querySelectorAll('.star-label');
        const text = document.getElementById('rating-text');
        const ratingsArr = ['', 'Sangat Buruk', 'Buruk', 'Lumayan', 'Bagus!', 'Sangat Puas!'];
        
        labels.forEach((label, index) => {
            if (index < rating) {
                label.classList.add('active');
            } else {
                label.classList.remove('active');
            }
        });
        
        text.innerText = ratingsArr[rating];
        document.getElementById('star-' + rating).checked = true;
    }

    function previewImage(input) {
        const container = document.getElementById('photo_preview_container');
        const placeholder = document.getElementById('upload_placeholder');
        const preview = document.getElementById('photo_preview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Previous Scripts
    function confirmCancelOrder() {
        Swal.fire({
            title: 'Batalkan Pesanan?',
            text: "Tindakan ini tidak dapat dibatalkan dan stok produk akan dikembalikan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f43f5e',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Batalkan!',
            cancelButtonText: 'Kembali',
            customClass: {
                popup: 'rounded-[2rem] p-8 border-none font-plus-jakarta',
                confirmButton: 'rounded-xl font-bold px-8 py-3',
                cancelButton: 'rounded-xl font-bold px-8 py-3'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('cancel-order-form').submit();
            }
        })
    }

    @if($order->status === 'pending' && $order->payment_deadline)
    // Countdown Timer
    function startCountdown() {
        const deadline = new Date("{{ $order->payment_deadline->toIso8601String() }}").getTime();
        const countdownElement = document.getElementById('countdown');

        const x = setInterval(function() {
            const now = new Date().getTime();
            const distance = deadline - now;

            if (distance < 0) {
                clearInterval(x);
                countdownElement.innerHTML = "WAKTU HABIS";
                countdownElement.classList.add('text-rose-600');
                return;
            }

            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            countdownElement.innerHTML = hours + "j " + minutes + "m " + seconds + "d";
        }, 1000);
    }
    startCountdown();
    @endif
    
    @if($order->status === 'delivering' && $order->shipped_at)
    // Delivery Duration Timer
    function startDeliveryTimer() {
        const startTime = new Date("{{ $order->shipped_at->toIso8601String() }}").getTime();
        const timerElement = document.getElementById('delivery-timer');

        if (!timerElement) return;

        function updateTimer() {
            const now = new Date().getTime();
            const diff = now - startTime;

            if (diff < 0) {
                timerElement.innerText = "00:00:00";
                return;
            }

            const h = Math.floor(diff / (1000 * 60 * 60));
            const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const s = Math.floor((diff % (1000 * 60)) / 1000);

            const hh = h.toString().padStart(2, '0');
            const mm = m.toString().padStart(2, '0');
            const ss = s.toString().padStart(2, '0');

            timerElement.innerText = `${hh}:${mm}:${ss}`;
        }

        updateTimer();
        setInterval(updateTimer, 1000);
    }
    startDeliveryTimer();
    @endif
</script>
@endpush
