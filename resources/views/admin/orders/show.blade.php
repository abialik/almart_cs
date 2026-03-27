@extends('layouts.shop')

@section('title', 'Verifikasi Pesanan ' . $order->order_code . ' — Almart')

@section('content')

{{-- ===== PAGE HEADER ===== --}}
<div class="bg-gray-100 py-6 border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
        <div class="flex items-center gap-4">
            <a href="{{ route(auth()->user()->role . '.orders.index') }}" class="w-10 h-10 bg-white border border-gray-300 rounded-xl flex items-center justify-center hover:bg-gray-50 transition shadow-sm">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="text-xl font-black text-gray-900 tracking-tight">VERIFIKASI PESANAN</h2>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-widest">{{ $order->order_code }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
             <span class="text-xs font-bold text-gray-400">Status Saat Ini:</span>
             @php
                $statusClasses = [
                    'pending'    => 'bg-amber-100 text-amber-700',
                    'paid'       => 'bg-emerald-100 text-emerald-700',
                    'processing' => 'bg-blue-100 text-blue-700',
                    'delivered'  => 'bg-purple-100 text-purple-700',
                    'cancelled'  => 'bg-rose-100 text-rose-700',
                ];
                $class = $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-700';
            @endphp
            <span class="px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest {{ $class }}">
                {{ $order->status }}
            </span>
        </div>
    </div>
</div>

<div class="bg-gray-50/50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-6">

        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl text-sm font-bold shadow-sm flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            {{-- LEFT: ORDER & ITEMS (2/3) --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- SECTION: ITEMS --}}
                <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-8 py-5 border-b border-gray-100">
                        <h3 class="font-bold text-gray-900 text-sm uppercase tracking-widest">Detail Produk</h3>
                    </div>
                    <div class="divide-y divide-gray-50">
                        @foreach($order->items as $item)
                            <div class="px-8 py-5 flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-14 h-14 bg-gray-50 rounded-xl border border-gray-100 flex items-center justify-center shrink-0">
                                        <img src="{{ asset($item->product->image) }}" class="max-w-[70%] max-h-[70%] object-contain">
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900 text-sm">{{ $item->product->name }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $item->qty }} × Rp {{ number_format($item->price) }}</p>
                                    </div>
                                </div>
                                <p class="font-bold text-gray-900 tracking-tight">Rp {{ number_format($item->subtotal) }}</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="px-8 py-5 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
                        <span class="text-xs font-bold text-gray-500 uppercase">Total Pesanan</span>
                        <span class="text-xl font-black text-gray-900">Rp {{ number_format($order->total) }}</span>
                    </div>
                </div>

                {{-- SECTION: PROOF OF PAYMENT --}}
                <div class="bg-white rounded-3xl shadow-sm border border-gray-200 p-8">
                    <h3 class="font-bold text-gray-900 text-sm uppercase tracking-widest mb-6">Bukti Pembayaran</h3>
                    
                    @if($order->payment && $order->payment->proof_of_payment)
                        <div class="bg-gray-50 rounded-2xl p-4 border border-gray-200 text-center">
                            <img src="{{ Storage::url($order->payment->proof_of_payment) }}" class="mx-auto max-h-[500px] rounded-xl shadow-lg" alt="Bukti">
                            <div class="mt-4 flex flex-col sm:flex-row justify-center gap-3">
                                <a href="{{ Storage::url($order->payment->proof_of_payment) }}" target="_blank" class="px-6 py-2 bg-white border border-gray-300 rounded-xl text-xs font-bold text-gray-700 hover:bg-gray-50 transition shadow-sm">
                                    Lihat Ukuran Penuh
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="bg-amber-50 border border-amber-100 rounded-2xl p-10 text-center">
                            <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <h4 class="font-bold text-amber-800 mb-1">Bukti Belum Diupload</h4>
                            <p class="text-xs text-amber-600">Customer belum mengunggah bukti pembayaran untuk pesanan ini.</p>
                        </div>
                    @endif
                </div>

            </div>

            {{-- RIGHT: STATUS & CUSTOMER (1/3) --}}
            <div class="space-y-6">
                
                {{-- UPDATE STATUS CARD --}}
                <div class="bg-white rounded-3xl shadow-lg shadow-gray-200/50 border border-gray-200 p-8">
                    <h3 class="font-bold text-gray-900 text-sm uppercase tracking-widest mb-6">Update Status</h3>
                    
                    <form action="{{ route(auth()->user()->role . '.orders.update-status', $order->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-6">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Pilih Status Baru</label>
                            <select name="status" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm font-bold text-gray-800 transition">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>PENDING (Menunggu)</option>
                                <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>PAID (Sudah Bayar)</option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>PROCESSING (Diproses)</option>
                                <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>DELIVERED (Terkirim)</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>CANCELLED (Batal)</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full py-4 bg-gray-900 border-b-4 border-black text-white font-black text-xs rounded-2xl hover:bg-gray-800 active:translate-y-1 active:border-b-0 transition-all uppercase tracking-[0.2em] shadow-lg shadow-gray-200">
                            Simpan Perubahan
                        </button>
                    </form>

                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <p class="text-[10px] text-gray-400 leading-relaxed italic">
                            * Pastikan bukti pembayaran sudah valid sebelum mengubah status menjadi <strong>PAID</strong> atau <strong>PROCESSING</strong>.
                        </p>
                    </div>
                </div>

                {{-- CUSTOMER INFO --}}
                <div class="bg-white rounded-3xl shadow-sm border border-gray-200 p-8">
                    <h3 class="font-bold text-gray-900 text-sm uppercase tracking-widest mb-6">Informasi Customer</h3>
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold text-lg">
                            {{ strtoupper(substr($order->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">{{ $order->user->name }}</p>
                            <p class="text-xs text-gray-400">{{ $order->user->email }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100">
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Alamat Kirim</p>
                            <div class="text-xs text-gray-600 leading-relaxed font-medium">
                                <p class="font-bold text-gray-900 mb-1">{{ $order->full_name }}</p>
                                <p>{{ $order->address }}</p>
                                <p>{{ $order->city }}, {{ $order->province }} {{ $order->post_code }}</p>
                                <p class="mt-2 text-blue-600 font-bold tracking-widest">{{ $order->phone }}</p>
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100">
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Informasi Akun</p>
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-bold text-gray-500">ID Member</span>
                                <span class="text-xs font-black text-gray-900 tracking-wider">#{{ $order->user->id }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

@endsection
