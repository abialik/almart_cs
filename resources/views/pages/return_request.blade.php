@extends('layouts.shop')

@section('title', 'Cari Pesanan Untuk Diretur — Almart')

@section('content')
<div class="bg-gray-50 min-h-[80vh] py-20 relative overflow-hidden flex items-center">
    {{-- Decorative backgrounds --}}
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 rounded-full bg-orange-100 opacity-50 blur-3xl mix-blend-multiply"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 rounded-full bg-amber-100 opacity-50 blur-3xl mix-blend-multiply"></div>

    <div class="max-w-2xl mx-auto px-6 relative z-10 w-full">
        
        @if(session('error'))
        <div class="mb-8 p-6 bg-red-50 rounded-2xl border-l-4 border-red-500 shadow-sm transition-all duration-300">
            <div class="flex items-center gap-4">
                <div class="bg-red-100 p-2 rounded-full text-red-600">
                    <i data-lucide="alert-circle" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="font-bold text-red-900">Pencarian Gagal</h3>
                    <p class="text-sm text-red-700 mt-1">{{ session('error') }}</p>
                </div>
            </div>
        </div>
        @endif

        <div class="bg-white/80 backdrop-blur-xl border border-white/40 shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-3xl p-8 sm:p-12 transition-all">
            <div class="mb-10 text-center">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-bold tracking-wider uppercase mb-4">
                    <i data-lucide="refresh-ccw" class="w-4 h-4"></i> Layanan Purna Jual
                </span>
                <h1 class="text-3xl sm:text-4xl font-black text-gray-900 mb-4 tracking-tight">Pengajuan Retur Barang</h1>
                <p class="text-gray-500 max-w-sm mx-auto leading-relaxed">Silakan masukkan <span class="font-bold text-gray-700">Nomor Pesanan</span> Anda untuk melanjutkan proses pengembalian produk.</p>
            </div>

            <form action="{{ route('pages.return_request.process') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label for="order_code" class="block text-sm font-semibold text-gray-700 mb-2">ID Pesanan (Order Code)</label>
                    <div class="relative">
                        <i data-lucide="search" class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" id="order_code" name="order_code" required class="w-full pl-12 pr-4 py-4 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 focus:bg-white transition-all text-sm font-bold tracking-wide uppercase placeholder-normal @error('order_code') border-red-500 focus:ring-red-500/10 focus:border-red-500 @enderror" placeholder="Contoh: ORD-XXXXXX" value="{{ old('order_code') }}">
                    </div>
                    @error('order_code') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-4 flex items-center justify-between gap-4">
                    <p class="text-xs text-gray-400 hidden sm:block max-w-[200px]">Pesanan yang dapat diretur hanya yang berstatus Dikirim atau Selesai (maks 7 hari).</p>
                    <button type="submit" class="w-full sm:w-auto px-8 py-4 bg-gray-900 text-white font-bold rounded-xl shadow-[0_8px_20px_rgb(0,0,0,0.12)] hover:bg-orange-500 hover:shadow-orange-500/30 hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2 group">
                        Cari Pesanan
                        <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </div>
            </form>
        </div>
        
    </div>
</div>
@endsection
