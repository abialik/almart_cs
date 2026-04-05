@extends('layouts.app')

@section('title', 'Almart Dashboard - Staff Management System')

@section('content')
@auth
<div class="min-h-screen bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-pink-50 via-gray-50/50 to-white font-plus-jakarta pb-20 relative selection:bg-pink-200">

    {{-- HEADER (GLASSMORPHISM) --}}
    <div class="backdrop-blur-xl bg-white/70 px-8 py-5 shadow-[0_4px_30px_rgb(0,0,0,0.03)] flex justify-between items-center sticky top-0 z-40 border-b border-white/50">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white rounded-xl shadow-sm border border-gray-100 flex items-center justify-center p-1.5">
                <img src="{{ asset('images/logo.png') }}" alt="Almart Logo" class="w-full h-full object-contain">
            </div>
            <div>
                <h1 class="font-bold text-gray-900 text-lg leading-tight"><span class="text-pink-500">Almart</span> Dashboard</h1>
                <p class="text-[10px] text-gray-400 font-semibold tracking-wide uppercase">Staff Management System</p>
            </div>
        </div>

        <div class="flex items-center gap-6">
            {{-- Notification --}}
            <button class="relative text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                @if($countBaru > 0)
                <span class="absolute -top-1 -right-1 w-4 h-4 bg-pink-500 rounded-full border-2 border-white text-[9px] font-bold text-white flex items-center justify-center shadow-sm">
                    {{ $countBaru }}
                </span>
                @endif
            </button>

            {{-- User Profile & Dropdown --}}
            <div class="relative group">
                <div class="flex items-center gap-3 bg-gray-50/50 pl-3 pr-2 py-1.5 rounded-full border border-gray-100 hover:bg-gray-100 transition duration-300 cursor-pointer">
                    <div class="text-right">
                        <p class="text-xs font-bold text-gray-800 leading-tight">{{ auth()->user()->name }}</p>
                        <p class="text-[9px] font-semibold text-gray-400 uppercase tracking-wider">Shift 1</p>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-pink-500 to-rose-400 text-white flex items-center justify-center font-bold text-sm shadow-md shadow-pink-200">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>

                {{-- Dropdown Menu --}}
                <div class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform origin-top-right scale-95 group-hover:scale-100 z-50">
                    <div class="p-2">
                        <div class="px-3 py-2 border-b border-gray-50 mb-1">
                            <p class="text-xs text-gray-500">Masuk sebagai</p>
                            <p class="text-sm font-bold text-gray-900 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-3 py-2.5 rounded-xl text-sm font-bold text-rose-600 hover:bg-rose-50 hover:text-rose-700 transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Keluar Sistem
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-6 mt-8">

        {{-- TOP NAVIGATION TABS (Pills) --}}
        <div class="flex justify-center gap-4 mb-8">
            <a href="?tab=pesanan" class="px-8 py-3.5 rounded-full text-sm font-bold shadow-sm flex items-center gap-2 hover:-translate-y-0.5 transition-all duration-300 {{ $tab === 'pesanan' ? 'bg-gradient-to-r from-pink-500 to-rose-500 text-white shadow-pink-200' : 'bg-white text-gray-600 hover:bg-pink-50 border border-gray-100' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                Pesanan
            </a>
            <a href="?tab=picking" class="px-8 py-3.5 rounded-full text-sm font-bold shadow-sm flex items-center gap-2 hover:-translate-y-0.5 transition-all duration-300 {{ $tab === 'picking' ? 'bg-gradient-to-r from-pink-500 to-rose-500 text-white shadow-pink-200' : 'bg-white text-gray-600 hover:bg-pink-50 border border-gray-100' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                Picking
            </a>
            <a href="?tab=delivery" class="px-8 py-3.5 rounded-full text-sm font-bold shadow-sm flex items-center gap-2 hover:-translate-y-0.5 transition-all duration-300 {{ $tab === 'delivery' ? 'bg-gradient-to-r from-pink-500 to-rose-500 text-white shadow-pink-200' : 'bg-white text-gray-600 hover:bg-pink-50 border border-gray-100' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Delivery
            </a>
            <a href="?tab=self_service" class="px-8 py-3.5 rounded-full text-sm font-bold shadow-sm flex items-center gap-2 hover:-translate-y-0.5 transition-all duration-300 {{ $tab === 'self_service' ? 'bg-gradient-to-r from-pink-500 to-rose-500 text-white shadow-pink-200' : 'bg-white text-gray-600 hover:bg-pink-50 border border-gray-100' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Self Service
            </a>
        </div>

        {{-- MAIN CONTAINER --}}
        @if($tab === 'pesanan')
        <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-[0_8px_40px_rgb(0,0,0,0.04)] border border-white p-8 mb-20">

            {{-- Title --}}
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Manajemen Pesanan Masuk</h2>
                <p class="text-sm text-gray-500 mt-1">Kelola pesanan dari pelanggan Almart</p>
            </div>

            {{-- KPI CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                
                {{-- Card 1: Pesanan Baru --}}
                <div class="group bg-gradient-to-br from-white to-blue-50/80 rounded-[2rem] p-6 border border-white shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 w-32 h-32 bg-blue-100/50 rounded-full blur-3xl group-hover:bg-blue-200/60 transition duration-500"></div>
                    <div>
                        <div class="flex items-center gap-3 mb-4 relative z-10">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-blue-500 to-cyan-400 text-white flex items-center justify-center shadow-lg shadow-blue-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Pesanan Baru</p>
                        </div>
                        <h3 class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500 relative z-10">{{ $countBaru }}</h3>
                    </div>
                </div>

                {{-- Card 2: Sedang Diproses --}}
                <div class="group bg-gradient-to-br from-white to-amber-50/80 rounded-[2rem] p-6 border border-white shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 w-32 h-32 bg-amber-100/50 rounded-full blur-3xl group-hover:bg-amber-200/60 transition duration-500"></div>
                    <div>
                        <div class="flex items-center gap-3 mb-4 relative z-10">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-amber-500 to-orange-400 text-white flex items-center justify-center shadow-lg shadow-amber-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                            </div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Diproses</p>
                        </div>
                        <h3 class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-amber-500 to-orange-500 relative z-10">{{ $countDiproses }}</h3>
                    </div>
                </div>

                {{-- Card 3: Selesai Hari Ini --}}
                <div class="group bg-gradient-to-br from-white to-emerald-50/80 rounded-[2rem] p-6 border border-white shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 w-32 h-32 bg-emerald-100/50 rounded-full blur-3xl group-hover:bg-emerald-200/60 transition duration-500"></div>
                    <div>
                        <div class="flex items-center gap-3 mb-4 relative z-10">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-500 to-green-400 text-white flex items-center justify-center shadow-lg shadow-emerald-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Selesai (Hari Ini)</p>
                        </div>
                        <h3 class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-green-500 relative z-10">{{ $countSelesai }}</h3>
                    </div>
                </div>
            </div>

            {{-- FILTERS --}}
            <div class="flex gap-3 mb-8">
                <a href="?tab={{ $tab }}&filter=semua" class="px-6 py-2.5 rounded-full text-xs font-bold transition-all duration-300 {{ $filter === 'semua' ? 'bg-gray-900 text-white shadow-lg shadow-gray-200' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                    Semua ({{ $countSemua }})
                </a>
                <a href="?tab={{ $tab }}&filter=baru" class="px-6 py-2.5 rounded-full text-xs font-bold transition-all duration-300 {{ $filter === 'baru' ? 'bg-gray-900 text-white shadow-lg shadow-gray-200' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                    Baru ({{ $countBaru }})
                </a>
                <a href="?tab={{ $tab }}&filter=diproses" class="px-6 py-2.5 rounded-full text-xs font-bold transition-all duration-300 {{ $filter === 'diproses' ? 'bg-gray-900 text-white shadow-lg shadow-gray-200' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                    Diproses ({{ $countDiproses }})
                </a>
            </div>

            {{-- ORDER LIST --}}
            <div class="space-y-5">
                @forelse($orders as $order)
                <div class="border border-gray-100/80 rounded-[2rem] p-6 hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:border-pink-100 hover:-translate-y-0.5 transition-all duration-300 bg-white flex flex-col md:flex-row md:items-center justify-between gap-5 relative group overflow-hidden">
                    
                    {{-- Status indicator glow line --}}
                    <div class="absolute left-0 top-0 bottom-0 w-2 opacity-80 group-hover:opacity-100 transition-opacity {{ $order->status === 'paid' ? 'bg-gradient-to-b from-blue-400 to-blue-600 shadow-[0_0_15px_rgba(59,130,246,0.5)]' : ($order->status === 'processing' ? 'bg-gradient-to-b from-amber-400 to-amber-600 shadow-[0_0_15px_rgba(251,191,36,0.5)]' : 'bg-gradient-to-b from-emerald-400 to-emerald-600 shadow-[0_0_15px_rgba(16,185,129,0.5)]') }}"></div>

                    <div class="pl-4">
                        <div class="flex items-center gap-3 mb-2.5">
                            <span class="font-bold text-gray-900 text-base tracking-wide">{{ $order->order_code }}</span>
                            
                            @if($order->status === 'paid')
                                <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-blue-50 text-blue-600 border border-blue-100 uppercase tracking-widest whitespace-nowrap">Baru Masuk</span>
                            @elseif($order->status === 'processing')
                                <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-100 uppercase tracking-widest whitespace-nowrap">Diproses</span>
                            @elseif($order->status === 'delivered')
                                <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100 uppercase tracking-widest whitespace-nowrap">Selesai</span>
                            @endif

                            <span class="px-2.5 py-1 rounded-md text-[10px] font-bold border border-gray-100 text-gray-500 bg-gray-50 uppercase tracking-widest">Delivery</span>
                        </div>
                        
                        <p class="text-sm text-gray-500 mb-1.5">Pelanggan: <span class="font-bold text-gray-900">{{ $order->customer->name ?? $order->full_name }}</span></p>
                        
                        <div class="flex items-center gap-3 text-[13px] text-gray-500 font-semibold">
                            <span class="bg-gray-50 px-2 py-0.5 rounded border border-gray-100">{{ $order->items->count() }} Item</span>
                            <span class="text-gray-300">•</span>
                            <span class="text-pink-500 font-bold">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                            <span class="text-gray-300">•</span>
                            <span class="flex items-center gap-1 text-gray-400 hover:text-gray-600 transition"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> {{ $order->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2.5 pl-4 md:pl-0">
                        <button onclick="openDetailModal({{ $order->id }})" class="px-5 py-2.5 bg-white hover:bg-gray-50 text-gray-600 hover:text-gray-900 text-xs font-bold rounded-xl border border-gray-200 hover:border-gray-300 transition-all shadow-sm flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            Detail
                        </button>
                        
                        <button class="px-5 py-2.5 bg-white hover:bg-gray-50 text-gray-600 hover:text-gray-900 text-xs font-bold rounded-xl border border-gray-200 hover:border-gray-300 transition-all shadow-sm flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                            Print
                        </button>

                        {{-- Action Buttons Based on Status --}}
                        @if($order->status === 'paid')
                            <form action="{{ route('petugas.orders.update-status', $order->id) }}" method="POST" class="inline" id="form-tolak-{{ $order->id }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="button" onclick="confirmTolak({{ $order->id }})" class="px-5 py-2.5 bg-white text-rose-500 hover:bg-rose-50 border border-rose-200 hover:border-rose-300 text-xs font-bold rounded-xl transition-all shadow-sm flex items-center gap-2 shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                    Tolak
                                </button>
                            </form>

                            <form action="{{ route('petugas.orders.update-status', $order->id) }}" method="POST" class="inline" id="form-terima-{{ $order->id }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="processing">
                                <button type="button" onclick="confirmTerima({{ $order->id }})" class="px-6 py-2.5 hover:-translate-y-0.5 bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white text-xs font-bold rounded-xl shadow-lg shadow-pink-200/80 transition-all duration-300 flex items-center gap-2 shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    Terima
                                </button>
                            </form>
                        @elseif($order->status === 'processing')
                            <form action="{{ route('petugas.orders.update-status', $order->id) }}" method="POST" class="inline" id="form-selesai-{{ $order->id }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="delivered">
                                <button type="button" onclick="confirmSelesai({{ $order->id }})" class="px-6 py-2.5 hover:-translate-y-0.5 bg-gradient-to-r from-emerald-500 to-green-500 hover:from-emerald-600 hover:to-green-600 text-white text-xs font-bold rounded-xl shadow-lg shadow-emerald-200/80 transition-all duration-300 flex items-center gap-2 shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    Selesaikan
                                </button>
                            </form>
                        @endif

                    </div>
                </div>
                @empty
                <div class="text-center py-24 bg-white border border-dashed border-gray-200 rounded-[2rem]">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-5 border border-gray-100 shadow-inner">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Antrean</h3>
                    <p class="text-sm text-gray-400 max-w-sm mx-auto leading-relaxed">Tidak ada pesanan masuk untuk status ini saat ini. Sistem akan otomatis memberitahu jika ada yang baru.</p>
                </div>
                @endforelse

                @if($orders->hasPages())
                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
                @endif
            </div>

        </div>
        @elseif($tab === 'picking')
        
        {{-- PICKING UI: 2 Columns Grid --}}
        <div class="flex flex-col lg:flex-row gap-6 mb-20 items-stretch">
            
            {{-- Left Column: Daftar Picking --}}
            <div class="w-full lg:w-1/3 bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-[0_8px_40px_rgb(0,0,0,0.04)] border border-white p-6">
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Daftar Picking</h2>
                    <p class="text-xs text-gray-500 mt-1">Pilih pesanan untuk mulai picking</p>
                </div>

                <div class="space-y-4">
                    @forelse($orders->where('status', 'processing') as $order)
                        <div onclick="openPickingDetail({{ $order->id }})" id="picking-card-{{ $order->id }}" class="picking-card cursor-pointer border-2 border-transparent border-gray-100 rounded-2xl p-5 hover:border-pink-300 transition-all duration-300 bg-white relative overflow-hidden group shadow-sm hover:shadow-md">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="font-bold text-gray-900 text-sm group-hover:text-pink-600 transition-colors">{{ $order->order_code }}</h3>
                                @if($order->total > 500000)
                                    <span class="bg-rose-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">Prioritas Tinggi</span>
                                @else
                                    <span class="bg-blue-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">Normal</span>
                                @endif
                            </div>
                            <p class="text-xs font-semibold text-gray-600 mb-4 truncate">{{ $order->customer->name ?? $order->full_name }}</p>
                            
                            {{-- Info Bawah --}}
                            <div class="flex justify-between items-center text-[10px] text-gray-400 font-bold mb-1.5">
                                <span class="flex items-center gap-1.5"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2"/></svg> {{ $order->updated_at->format('H:i') }}</span>
                                <span class="tracking-wide">Menunggu</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 opacity-60">
                            <p class="text-sm font-bold text-gray-500">Belum ada pesanan yang diproses.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Right Column: Kanvas Detail --}}
            <div id="pickingContentTarget" class="w-full lg:w-2/3 bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-[0_8px_40px_rgb(0,0,0,0.04)] border border-white p-8 lg:min-h-[500px] flex items-center justify-center relative transition-all duration-300">
                {{-- State Default / Kosong --}}
                <div class="text-center opacity-40">
                    <svg class="w-20 h-20 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    <p class="text-lg font-bold text-gray-500">Pilih Pesanan di Samping</p>
                    <p class="text-sm text-gray-400 mt-1 max-w-sm mx-auto">Daftar item untuk di-picking akan muncul di sini</p>
                </div>
            </div>

        </div>
        @else
            {{-- Tab Delivery / Self Service dll --}}
            <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-[0_8px_40px_rgb(0,0,0,0.04)] border border-white p-20 text-center mb-20 text-gray-400">
                <span class="font-bold text-xl">Fitur {{ ucfirst($tab) }} Sedang Dikembangkan</span>
            </div>
        @endif
    </div>
</div>

{{-- MODAL OVERLAY DETAIL --}}
<div id="detailModalPanel" class="fixed inset-0 z-50 bg-gray-900/40 backdrop-blur-sm hidden flex items-center justify-center p-4 transition-opacity opacity-0" onclick="closeDetailModal(event)">
    {{-- MODAL CONTENT CARRIER (AJAX Injected) --}}
    <div id="detailContentTarget" class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-6 transform scale-95 transition-transform" onclick="event.stopPropagation()">
        <!-- Content injected here via AJAX -->
        <div class="flex items-center justify-center h-48">
            <svg class="animate-spin text-pink-500 w-8 h-8" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmTerima(id) {
        Swal.fire({
            html: `
                <div class="text-left font-plus-jakarta pb-2">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Terima Pesanan?</h3>
                    <p class="text-sm text-gray-500">Pesanan akan dipindahkan ke status <span class="font-bold text-amber-500">"Sedang Diproses"</span> dan siap untuk dipicking.</p>
                </div>
            `,
            showCancelButton: true,
            confirmButtonColor: '#ec4899', // pink-500
            cancelButtonColor: '#f3f4f6', // gray-100
            cancelButtonText: '<span class="text-gray-600 font-bold">Batal</span>',
            confirmButtonText: '<span class="font-bold text-white flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> Ya, Terima</span>',
            customClass: {
                popup: 'rounded-[2rem] p-4 shadow-2xl border border-gray-100',
                confirmButton: 'rounded-xl px-6 py-3',
                cancelButton: 'rounded-xl px-6 py-3 border border-gray-200'
            },
            buttonsStyling: true,
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-terima-' + id).submit();
            }
        });
    }

    function confirmTolak(id) {
        Swal.fire({
            title: 'Tolak & Batalkan Pesanan?',
            text: "Pelanggan akan mendapat notifikasi bahwa pesanannya ditolak.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f43f5e', // rose-500
            cancelButtonColor: '#f3f4f6',
            cancelButtonText: '<span class="text-gray-600 font-bold">Kembali</span>',
            confirmButtonText: '<span class="font-bold text-white">Ya, Tolak</span>',
            customClass: {
                popup: 'rounded-[2rem] shadow-2xl border border-gray-100 font-plus-jakarta',
                confirmButton: 'rounded-xl px-6 py-3',
                cancelButton: 'rounded-xl px-6 py-3 border border-gray-200'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-tolak-' + id).submit();
            }
        });
    }
    
    function confirmSelesai(id) {
        Swal.fire({
            title: 'Pesanan Selesai?',
            text: "Pesanan ini akan ditandai sukses terkirim.",
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#10b981', // emerald-500
            cancelButtonColor: '#f3f4f6',
            cancelButtonText: '<span class="text-gray-600 font-bold">Kembali</span>',
            confirmButtonText: '<span class="font-bold text-white">Selesaikan</span>',
            customClass: {
                popup: 'rounded-[2rem] shadow-2xl border border-gray-100 font-plus-jakarta',
                confirmButton: 'rounded-xl px-6 py-3',
                cancelButton: 'rounded-xl px-6 py-3 border border-gray-200'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-selesai-' + id).submit();
            }
        });
    }

    // Modal Logic
    const detailModalPanel = document.getElementById('detailModalPanel');
    const detailContentTarget = document.getElementById('detailContentTarget');

    function openDetailModal(orderId) {
        // Show Background
        detailModalPanel.classList.remove('hidden');
        // Animate fading in
        setTimeout(() => {
            detailModalPanel.classList.remove('opacity-0');
            detailContentTarget.classList.remove('scale-95');
        }, 10);
        
        // Show Loader
        detailContentTarget.innerHTML = `
            <div class="flex items-center justify-center h-64">
                <svg class="animate-spin text-pink-500 w-10 h-10" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        `;

        // Fetch HTML Fragment
        fetch(`/petugas/orders/${orderId}/detail`)
            .then(res => res.json())
            .then(data => {
                detailContentTarget.innerHTML = data.html;
            })
            .catch(err => {
                detailContentTarget.innerHTML = `<div class="text-center text-red-500 py-10 font-bold">Gagal memuat data!</div>`;
            });
    }

    function closeDetailModal(e) {
        if(e) e.preventDefault();
        
        detailModalPanel.classList.add('opacity-0');
        detailContentTarget.classList.add('scale-95');
        
        // Wait for transition before hiding completely
        setTimeout(() => {
            detailModalPanel.classList.add('hidden');
        }, 300); // 300ms matches Tailwind default transition timing
    }

    // FUNGSI PICKING (TAB PICKING)
    function openPickingDetail(orderId) {
        const targetTarget = document.getElementById('pickingContentTarget');
        
        // Update Card Styling di Kiri
        document.querySelectorAll('.picking-card').forEach(card => {
            card.classList.remove('border-pink-500', 'ring-2', 'ring-pink-200');
            card.classList.add('border-gray-100');
        });
        const activeCard = document.getElementById('picking-card-' + orderId);
        if(activeCard) {
            activeCard.classList.remove('border-gray-100');
            activeCard.classList.add('border-pink-500', 'ring-2', 'ring-pink-200');
        }

        // Tampilkan Loader di Kanan
        targetTarget.innerHTML = `
            <div class="flex items-center justify-center w-full h-full min-h-[400px]">
                <svg class="animate-spin text-pink-500 w-10 h-10" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        `;

        fetch(`/petugas/orders/${orderId}/picking-detail`)
            .then(res => res.json())
            .then(data => {
                targetTarget.innerHTML = data.html;
            })
            .catch(err => {
                targetTarget.innerHTML = '<div class="p-6 text-center text-red-500 font-bold">Gagal memuat data picking.</div>';
            });
    }

    window.updatePickingProgress = function(orderId, totalItems) {
        const checkboxes = document.querySelectorAll('.picking-checkbox-' + orderId);
        const checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
        
        const progressText = document.getElementById('progress-text-' + orderId);
        if(progressText) progressText.innerText = `${checkedCount}/${totalItems} item`;

        const progressBarTarget = document.getElementById('progress-bar-' + orderId);
        if(progressBarTarget) progressBarTarget.style.width = ((checkedCount / totalItems) * 100) + '%';
        
        const progressBarLeft = document.querySelector(`.progress-bar-${orderId}`);
        if(progressBarLeft) progressBarLeft.style.width = ((checkedCount / totalItems) * 100) + '%';
        
        const progressSummaryLeft = document.getElementById(`picking-summary-${orderId}`);
        if(progressSummaryLeft) progressSummaryLeft.innerText = `${checkedCount}/${totalItems} item`;

        const btnSelesai = document.getElementById('btn-selesai-' + orderId);
        if(btnSelesai) {
            if(checkedCount === totalItems) {
                btnSelesai.disabled = false;
                btnSelesai.classList.remove('cursor-not-allowed', 'bg-pink-100', 'text-pink-400');
                btnSelesai.classList.add('bg-gradient-to-r', 'from-pink-500', 'to-rose-500', 'text-white', 'hover:shadow-lg', 'hover:shadow-pink-200');
            } else {
                btnSelesai.disabled = true;
                btnSelesai.classList.add('cursor-not-allowed', 'bg-pink-100', 'text-pink-400');
                btnSelesai.classList.remove('bg-gradient-to-r', 'from-pink-500', 'to-rose-500', 'text-white', 'hover:shadow-lg', 'hover:shadow-pink-200');
            }
        }
    }

    function confirmSelesaiPicking(id) {
        Swal.fire({
            title: 'Selesai Picking?',
            text: "Pesanan akan dipindahkan ke tahap pengiriman",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#f43f5e',
            cancelButtonColor: '#f3f4f6',
            cancelButtonText: '<span class="text-gray-600 font-bold">Batal</span>',
            confirmButtonText: '<span class="font-bold text-white flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> Ya, Selesai</span>',
            customClass: {
                popup: 'rounded-[2rem] p-4 shadow-2xl border border-gray-100 font-plus-jakarta',
                confirmButton: 'rounded-xl px-6 py-3',
                cancelButton: 'rounded-xl px-6 py-3 border border-gray-200'
            },
            buttonsStyling: true,
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-selesai-picking-' + id).submit();
            }
        });
    }
</script>
@endauth
@endsection