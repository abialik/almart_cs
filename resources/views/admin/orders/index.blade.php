@extends('layouts.admin')

@section('title', 'Pemantauan Transaksi')

@section('content')
<div class="space-y-8 pb-10">

    <!-- TITLE SECTION -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 font-plus-jakarta">Pemantauan Transaksi</h1>
            <p class="text-sm text-gray-500 mt-1">
                Pantau seluruh transaksi online dan offline
            </p>
        </div>
        <div>
            <a href="{{ route('admin.orders.export', request()->query()) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-5 rounded-xl text-xs flex items-center gap-2 shadow-sm shadow-blue-200 transition tracking-wider">
                <i data-lucide="download" class="w-4 h-4"></i> Export Data
            </a>
        </div>
    </div>

    <!-- STATS CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card: Total Transaksi -->
        <div class="bg-purple-50/50 p-6 rounded-3xl border border-purple-100 flex flex-col justify-center">
            <p class="text-[11px] font-bold text-purple-600 mb-2 uppercase tracking-widest">Total Transaksi</p>
            <h2 class="text-3xl font-black text-purple-600">{{ $totalOrders ?? count($orders) }}</h2>
        </div>
        <!-- Card: Total Pendapatan -->
        <div class="bg-emerald-50/50 p-6 rounded-3xl border border-emerald-100 flex flex-col justify-center">
            <p class="text-[11px] font-bold text-emerald-600 mb-2 uppercase tracking-widest">Total Pendapatan</p>
            <h2 class="text-2xl font-black text-emerald-600">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</h2>
        </div>
        <!-- Card: Transaksi Online -->
        <div class="bg-blue-50/50 p-6 rounded-3xl border border-blue-100 flex flex-col justify-center">
            <p class="text-[11px] font-bold text-blue-600 mb-2 uppercase tracking-widest">Transaksi Online</p>
            <h2 class="text-3xl font-black text-blue-600">{{ $onlineOrders ?? 0 }}</h2>
        </div>
        <!-- Card: Transaksi Offline -->
        <div class="bg-gray-50 p-6 rounded-3xl border border-gray-100 flex flex-col justify-center">
            <p class="text-[11px] font-bold text-gray-500 mb-2 uppercase tracking-widest">Transaksi Offline</p>
            <h2 class="text-3xl font-black text-gray-900">{{ $offlineOrders ?? 0 }}</h2>
        </div>
    </div>

    <!-- MAIN TABLE AREA -->
    <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-50 flex flex-col">
        
        <!-- Filters -->
        <div class="p-6 border-b border-gray-50">
            <form action="{{ url()->current() }}" method="GET" class="flex flex-col md:flex-row gap-4 items-center">
                <div class="relative flex-1 w-full">
                    <i data-lucide="search" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari ID transaksi atau nama customer..." class="w-full pl-11 pr-24 py-3 bg-white border border-gray-100 rounded-2xl text-sm font-semibold text-gray-700 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-shadow">
                    <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 bg-blue-500 text-white hover:bg-blue-600 font-bold text-xs py-2 px-4 rounded-xl shadow-sm transition-colors">Cari</button>
                </div>
                <div class="flex gap-4 w-full md:w-auto">
                    <div class="relative w-full md:w-40">
                        <select name="type" onchange="this.form.submit()" class="w-full px-4 py-3 bg-white border border-gray-100 rounded-2xl text-sm font-bold text-gray-700 outline-none focus:border-blue-500 transition-shadow appearance-none cursor-pointer">
                            <option value="">Semua Tipe</option>
                            <option value="online" {{ request('type') == 'online' ? 'selected' : '' }}>Online</option>
                            <option value="offline" {{ request('type') == 'offline' ? 'selected' : '' }}>Offline</option>
                        </select>
                        <i data-lucide="chevron-down" class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                    </div>
                    <div class="relative w-full md:w-40">
                        <select name="status" onchange="this.form.submit()" class="w-full px-4 py-3 bg-white border border-gray-100 rounded-2xl text-sm font-bold text-gray-700 outline-none focus:border-blue-500 transition-shadow appearance-none cursor-pointer">
                            <option value="">Semua Status</option>
                            <option value="berhasil" {{ request('status') == 'berhasil' ? 'selected' : '' }}>Berhasil</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        <i data-lucide="chevron-down" class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                    </div>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto p-4">
            <table class="w-full text-left" style="border-spacing: 0;">
                <thead>
                    <tr>
                        <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">ID Transaksi</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Tanggal & Waktu</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Customer</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Items</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Total</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Pembayaran</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap text-center">Tipe</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap text-center">Status</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($orders as $order)
                    @php
                        $isTunai = strtolower(optional($order->payment)->method) === 'tunai' || strtolower(optional($order->payment)->method) === 'cod';
                        $tipe = $isTunai ? 'Offline' : 'Online';
                        $tipeClass = $isTunai ? 'bg-gray-100 text-gray-500' : 'bg-blue-50 text-blue-600';
                        
                        $statusClass = 'bg-gray-100 text-gray-600';
                        $statusLabel = $order->status;
                        
                        // Map status to match the design (Berhasil, Pending, Dibatalkan)
                        if(in_array($order->status, ['paid', 'processing', 'delivered'])) {
                             $statusLabel = 'Berhasil';
                             $statusClass = 'bg-emerald-100 text-emerald-600';
                        } elseif ($order->status === 'pending') {
                             $statusLabel = 'Pending';
                             $statusClass = 'bg-amber-100 text-amber-600';
                        } elseif ($order->status === 'cancelled') {
                             $statusLabel = 'Dibatalkan';
                             $statusClass = 'bg-rose-100 text-rose-600';
                        }
                    @endphp
                    <tr class="hover:bg-gray-50/80 transition-colors group border-b border-gray-50/50 last:border-0">
                        <td class="px-6 py-5 whitespace-nowrap">
                            <span class="font-black text-blue-600 text-xs">{{ $order->order_code }}</span>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap">
                            <div class="font-bold text-gray-900 text-xs">{{ $order->created_at->format('d M Y') }}</div>
                            <div class="text-[10px] text-gray-400 font-bold mt-1">{{ $order->created_at->format('H:i') }}</div>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap">
                            <span class="font-semibold text-gray-600 text-xs">{{ $order->customer->name ?? $order->user->name ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap">
                            <span class="text-gray-500 text-xs font-semibold">{{ $order->items ? $order->items->count() : 1 }} items</span>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap">
                            <span class="font-black text-gray-900 text-xs">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap">
                            <span class="text-gray-600 text-xs font-medium capitalize">{{ $order->payment ? $order->payment->method : '-' }}</span>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap text-center">
                            <span class="inline-flex px-3 py-1 rounded-full text-[10px] font-black tracking-widest {{ $tipeClass }}">{{ $tipe }}</span>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap text-center">
                            <span class="inline-flex px-3 py-1 rounded-full text-[10px] font-black tracking-widest {{ $statusClass }}">{{ $statusLabel }}</span>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center gap-2">
                                {{-- Quick Actions for Pending --}}
                                @if($order->status === 'pending')
                                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="paid">
                                        <button type="submit" title="Terima Pembayaran" class="flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-500 text-white hover:bg-emerald-600 transition shadow-sm">
                                            <i data-lucide="check" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                {{-- Quick Actions for Paid --}}
                                @elseif($order->status === 'paid')
                                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="processing">
                                        <button type="submit" title="Teruskan ke SAPA" class="flex items-center justify-center w-8 h-8 rounded-lg bg-rose-500 text-white hover:bg-rose-600 transition shadow-sm">
                                            <i data-lucide="package" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                @endif

                                <a href="{{ route((auth()->user() ? auth()->user()->role : 'admin') . '.orders.show', $order->id) }}" title="Lihat Detail" class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-gray-200 text-gray-400 bg-white hover:bg-gray-50 hover:text-blue-500 hover:border-blue-200 transition shadow-sm">
                                    <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-12 text-center text-gray-400 font-medium">Belum ada transaksi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
        <div class="p-6 border-t border-gray-50 flex justify-between items-center bg-white rounded-b-3xl">
            <span class="text-xs font-bold text-gray-400">Menampilkan {{ $orders->count() }} dari {{ $orders->total() }} transaksi</span>
            <div>
                 {{ $orders->links('pagination::tailwind') }}
            </div>
        </div>
        @else
        <div class="p-6 border-t border-gray-50 flex justify-between items-center bg-white rounded-b-3xl">
            <span class="text-xs font-bold text-gray-400">Menampilkan {{ $orders->count() }} dari {{ $orders->total() }} transaksi</span>
            <div class="flex gap-1">
                <button class="w-8 h-8 rounded-lg flex items-center justify-center border border-gray-100 text-gray-400 cursor-not-allowed">
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </button>
                <button class="w-8 h-8 rounded-lg flex items-center justify-center bg-blue-500 text-white font-bold text-xs shadow-sm shadow-blue-200 cursor-default">
                    1
                </button>
                <button class="w-8 h-8 rounded-lg flex items-center justify-center border border-gray-100 text-gray-400 cursor-not-allowed">
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
