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
            @if($order->status === 'pending')
                 <a href="{{ route('customer.checkout.payment', $order->id) }}" 
                    class="px-5 py-2 bg-white text-gray-900 text-xs font-black rounded-full shadow-lg hover:bg-gray-100 transition tracking-widest">
                    BAYAR SEKARANG
                </a>
            @endif
        </div>
    </div>
</div>

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
                            @if(in_array($order->status, ['processing', 'delivered']))
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

                        {{-- Step: Delivered --}}
                        <div class="relative">
                            @if($order->status === 'delivered')
                                <div class="absolute -left-[30px] top-1 w-6 h-6 rounded-full bg-green-500 border-4 border-green-50 shadow-sm z-10"></div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900">Selesai / Terkirim</p>
                                    <p class="text-xs text-gray-400 mt-0.5">Pesanan sudah sampai di tujuan</p>
                                </div>
                            @else
                                <div class="absolute -left-[30px] top-1 w-6 h-6 rounded-full bg-gray-100 border-4 border-white z-10"></div>
                                <div class="opacity-50">
                                    <p class="text-sm font-bold text-gray-400">Diterima</p>
                                </div>
                            @endif
                        </div>

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
                
                {{-- SHIPPING --}}
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
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
                            <a href="#" class="inline-flex items-center justify-center gap-2 text-xs font-black bg-white text-blue-600 px-6 py-3 rounded-xl hover:bg-blue-50 transition uppercase tracking-widest">
                                Chat Admin
                            </a>
                            @if(in_array($order->status, ['paid', 'processing', 'delivered']) && $order->returns->isEmpty())
                                <a href="{{ route('customer.returns.create', $order->id) }}" class="inline-flex items-center justify-center gap-2 text-xs font-black bg-blue-500 text-white border border-blue-400 px-6 py-3 rounded-xl hover:bg-blue-400 transition uppercase tracking-widest">
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
