@extends('layouts.admin')

@section('title', 'Transaksi ' . $order->order_code)

@section('content')
<div class="mb-10 animate-fade-in">
    <nav class="flex text-gray-400 text-[10px] font-black uppercase tracking-[0.2em] mb-3" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-2">
            <li><a href="{{ route('admin.dashboard') }}" class="hover:text-rose-600 transition-colors">Dashboard</a></li>
            <li><div class="flex items-center"><i data-lucide="chevron-right" class="w-3 h-3 mx-1"></i> <a href="{{ route('admin.orders.index') }}" class="hover:text-rose-600 transition-colors">Transaksi</a></div></li>
            <li><div class="flex items-center"><i data-lucide="chevron-right" class="w-3 h-3 mx-1"></i> <span class="text-gray-500">Detail #{{ $order->order_code }}</span></div></li>
        </ol>
    </nav>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-4xl font-black text-gray-900 tracking-tight">Detail Transaksi</h1>
            <p class="text-sm text-gray-500 mt-2 font-medium">Informasi lengkap pesanan <span class="text-rose-600 font-bold">#{{ $order->order_code }}</span></p>
        </div>
        <div class="flex items-center gap-3">
             <div class="flex flex-col text-right mr-4 hidden md:block">
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Waktu Pesanan</span>
                <span class="text-xs font-bold text-gray-900">{{ $order->created_at->translatedFormat('d F Y, H:i') }}</span>
             </div>
             @php
                $statusClasses = [
                    'pending'    => 'bg-rose-50 text-rose-500 border-rose-100',
                    'paid'       => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                    'processing' => 'bg-orange-50 text-orange-600 border-orange-100',
                    'delivering' => 'bg-blue-50 text-blue-600 border-blue-100',
                    'delivered'  => 'bg-emerald-500 text-white border-emerald-500 shadow-lg shadow-emerald-200',
                    'cancelled'  => 'bg-gray-100 text-gray-400 border-gray-200',
                ];
                $class = $statusClasses[$order->status] ?? 'bg-gray-50 text-gray-500 border-gray-100';
            @endphp
            <div class="px-6 py-2.5 rounded-2xl border-2 text-[10px] font-black uppercase tracking-[0.2em] {{ $class }}">
                {{ str_replace('_', ' ', $order->status) }}
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 pb-20 animate-slide-up">
    
    {{-- LEFT: ORDER ITEMS & PAYMENT (8 COLUMNS) --}}
    <div class="lg:col-span-8 space-y-8">
        
        {{-- ITEM LIST --}}
        <div class="bg-white rounded-[3rem] shadow-[0_32px_64px_-16px_rgba(0,0,0,0.05)] border border-gray-100 overflow-hidden">
            <div class="p-10 border-b border-gray-50 bg-gray-50/30 flex justify-between items-center">
                <h3 class="text-xl font-black text-gray-900 tracking-tight">Daftar Belanja</h3>
                <span class="px-4 py-1.5 bg-white border border-gray-200 rounded-xl text-[10px] font-black uppercase tracking-widest text-gray-400 shadow-sm">{{ $order->items->count() }} Item</span>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach($order->items as $item)
                <div class="p-8 flex flex-col sm:flex-row items-center justify-between gap-6 group hover:bg-gray-50/50 transition-colors">
                    <div class="flex items-center gap-6 w-full sm:w-auto">
                        <div class="w-20 h-20 bg-white shadow-xl shadow-gray-100 border border-gray-50 rounded-3xl flex items-center justify-center p-3 shrink-0 group-hover:scale-105 transition-transform duration-500">
                            @if($item->product && $item->product->image)
                                <img src="{{ asset($item->product->image) }}" class="max-w-full max-h-full object-contain">
                            @else
                                <i data-lucide="image" class="w-8 h-8 text-gray-200"></i>
                            @endif
                        </div>
                        <div>
                            <p class="text-lg font-black text-gray-900 leading-tight group-hover:text-rose-600 transition-colors">{{ $item->product->name ?? 'Produk Tidak Tersedia' }}</p>
                            <p class="text-xs font-bold text-gray-400 mt-2 uppercase tracking-widest">{{ $item->qty }} Unit <span class="mx-2 opacity-30">|</span> Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="text-right w-full sm:w-auto">
                        <p class="text-xl font-black text-gray-900 tracking-tight">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            
            {{-- SUMMARY FOOTER --}}
            <div class="p-10 bg-gray-900 text-white flex flex-col sm:flex-row justify-between items-center gap-6">
                <div>
                    <p class="text-[10px] font-black text-gray-500 uppercase tracking-[0.3em] mb-1">Total Tagihan</p>
                    <p class="text-xs text-rose-400 font-bold">Harga sudah termasuk pajak & biaya layanan</p>
                </div>
                <div class="text-right">
                    <h2 class="text-4xl font-black tracking-tighter">Rp {{ number_format($order->total, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>

        {{-- PROOF OF PAYMENT --}}
        <div class="bg-white rounded-[3rem] shadow-[0_32px_64px_-16px_rgba(0,0,0,0.05)] border border-gray-100 p-10 group overflow-hidden relative">
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-rose-50 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>
            
            <div class="flex items-center gap-4 mb-10 relative z-10">
                <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center shadow-inner">
                    <i data-lucide="receipt" class="w-6 h-6"></i>
                </div>
                <h3 class="text-xl font-black text-gray-900 tracking-tight">Validasi Pembayaran</h3>
            </div>

            @if($order->payment && $order->payment->proof_of_payment)
                <div class="bg-gray-50 rounded-[2.5rem] p-6 border-2 border-dashed border-gray-200 text-center relative z-10 group/img">
                    <img src="{{ Storage::url($order->payment->proof_of_payment) }}" class="mx-auto max-h-[600px] rounded-3xl shadow-2xl transition-transform duration-700 group-hover/img:scale-[1.02]" alt="Bukti">
                    <div class="mt-8 flex justify-center">
                        <a href="{{ Storage::url($order->payment->proof_of_payment) }}" target="_blank" class="px-10 py-4 bg-white border border-gray-200 rounded-[1.5rem] text-xs font-black text-gray-600 hover:bg-rose-500 hover:text-white hover:border-rose-500 transition-all shadow-xl shadow-gray-100 flex items-center gap-3">
                            <i data-lucide="maximize" class="w-4 h-4"></i>
                            LIHAT UKURAN PENUH
                        </a>
                    </div>
                </div>
            @else
                <div class="bg-rose-50 border-2 border-dashed border-rose-100 rounded-[2.5rem] p-16 text-center relative z-10">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl shadow-rose-100 border border-rose-100">
                        <i data-lucide="help-circle" class="w-10 h-10 text-rose-500 animate-pulse"></i>
                    </div>
                    <h4 class="text-xl font-black text-rose-900 mb-2">Bukti Belum Diunggah</h4>
                    <p class="text-xs text-rose-600 font-bold uppercase tracking-widest opacity-70">METODE: {{ $order->payment ? $order->payment->method : 'BELUM DIPILIH' }}</p>
                </div>
            @endif
        </div>

    </div>

    {{-- RIGHT: STATUS & CUSTOMER (4 COLUMNS) --}}
    <div class="lg:col-span-4 space-y-8">
        
        {{-- ACTION: UPDATE STATUS --}}
        <div class="bg-white rounded-[3rem] shadow-[0_32px_64px_-16px_rgba(0,0,0,0.08)] border border-gray-100 p-10 relative overflow-hidden group">
            <div class="absolute inset-x-0 top-0 h-2 bg-gradient-to-r from-rose-500 to-indigo-600"></div>
            
            <h3 class="text-xl font-black text-gray-900 tracking-tight mb-8">Ubah Status</h3>
            
            <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')
                
                <div class="space-y-3">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-2">Progress Alur SAPA</label>
                    <select name="status" class="w-full bg-gray-50 border-none px-6 py-5 rounded-2xl text-sm font-black outline-none focus:bg-white focus:ring-8 focus:ring-rose-50 transition-all appearance-none cursor-pointer">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>PENDING (Menunggu)</option>
                        <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>PAID (Terverifikasi)</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>PROCESSING (Dikemas)</option>
                        <option value="delivering" {{ $order->status === 'delivering' ? 'selected' : '' }}>DELIVERING (Kurir OTW)</option>
                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>DELIVERED (Sampai)</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>CANCELLED (Dibatalkan)</option>
                    </select>
                </div>

                <button type="submit" class="w-full py-6 bg-rose-500 text-white rounded-[2rem] text-xs font-black uppercase tracking-[0.2em] shadow-2xl shadow-rose-200 hover:bg-rose-600 hover:-translate-y-1 active:scale-95 transition-all outline-none">
                    Update Pesanan
                </button>
            </form>

            <div class="mt-8 pt-8 border-t border-gray-50 flex items-start gap-3">
                <i data-lucide="info" class="w-4 h-4 text-gray-300 mt-0.5"></i>
                <p class="text-[10px] text-gray-400 leading-relaxed font-bold">
                    Perubahan status akan langsung muncul di halaman aktivitas pelanggan secara real-time.
                </p>
            </div>
        </div>

        {{-- CUSTOMER INFO --}}
        <div class="bg-white rounded-[3rem] shadow-[0_32px_64px_-16px_rgba(0,0,0,0.04)] border border-gray-100 p-10">
            <h3 class="text-xl font-black text-gray-900 tracking-tight mb-8">Informasi Penerima</h3>
            
            <div class="flex items-center gap-5 mb-10">
                <div class="w-16 h-16 bg-gray-900 text-white rounded-[1.8rem] flex items-center justify-center font-black text-2xl shadow-2xl shadow-gray-200">
                    {{ strtoupper(substr($order->user->name ?? 'G', 0, 1)) }}
                </div>
                <div>
                    <h4 class="text-xl font-black text-gray-900 leading-none">{{ $order->user->name ?? 'Guest User' }}</h4>
                    <p class="text-xs font-bold text-gray-400 mt-2 uppercase tracking-widest">{{ $order->user->email ?? 'no-email@almart.shop' }}</p>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-gray-50/80 p-6 rounded-[2rem] border border-gray-100">
                    <div class="flex items-center gap-3 mb-4 text-rose-500">
                         <i data-lucide="map-pin" class="w-4 h-4"></i>
                         <span class="text-[10px] font-black uppercase tracking-widest">Alamat Pengiriman</span>
                    </div>
                    <div class="text-xs font-bold text-gray-600 space-y-2 leading-relaxed tracking-tight">
                        <p class="text-gray-900 text-sm font-black">{{ $order->full_name }}</p>
                        <p>{{ $order->address }}</p>
                        <p>{{ $order->city }}, {{ $order->province }} {{ $order->post_code }}</p>
                        <div class="pt-3 border-t border-white mt-1">
                            <a href="tel:{{ $order->phone }}" class="flex items-center gap-2 text-rose-600">
                                <i data-lucide="phone" class="w-3 h-3"></i>
                                <span>{{ $order->phone }}</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50/80 p-6 rounded-[2rem] border border-gray-100">
                    <div class="flex items-center gap-3 mb-4 text-gray-400">
                         <i data-lucide="database" class="w-4 h-4"></i>
                         <span class="text-[10px] font-black uppercase tracking-widest">Metode Bayar</span>
                    </div>
                    <p class="text-sm font-black text-gray-900 uppercase tracking-widest">{{ $order->payment ? $order->payment->method : 'MANUAL/TUNAI' }}</p>
                    <p class="text-[10px] font-bold text-gray-400 mt-1 italic">Status: {{ strtoupper($order->payment ? $order->payment->status : 'UNPAID') }}</p>
                </div>
            </div>
        </div>

    </div>

</div>

<style>
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes slideUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { animation: fadeIn 0.7s ease-out; }
    .animate-slide-up { animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
</script>
@endsection
