@extends('layouts.admin')

@section('title', 'Manajemen Stok (Inventory)')

@section('content')
<div class="space-y-8 pb-10">

    <!-- TITLE SECTION -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 font-plus-jakarta">Manajemen Stok (Inventory)</h1>
            <p class="text-sm text-gray-500 mt-1">
                Pantau ketersediaan stok barang secara real-time
            </p>
        </div>
        <div>
            <!-- Add Product Button -->
            <a href="{{ route('admin.products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-5 rounded-xl text-xs flex items-center gap-2 shadow-sm shadow-blue-200 transition tracking-wider">
                <i data-lucide="plus" class="w-4 h-4"></i> Tambah Produk
            </a>
        </div>
    </div>

    <!-- STATS CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card: Total Produk -->
        <div class="bg-blue-50/80 p-5 rounded-3xl border border-blue-100 flex items-center gap-5">
            <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg shadow-blue-200 shrink-0">
                <i data-lucide="package" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-blue-700 mb-1 uppercase tracking-widest leading-none">Total Produk</p>
                <h2 class="text-2xl font-black text-blue-700 leading-none">{{ $totalProducts }}</h2>
            </div>
        </div>

        <!-- Card: Stok Tersedia -->
        <div class="bg-emerald-50/80 p-5 rounded-3xl border border-emerald-100 flex items-center gap-5">
            <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center shadow-lg shadow-emerald-200 shrink-0">
                <i data-lucide="bar-chart-2" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-emerald-700 mb-1 uppercase tracking-widest leading-none">Stok Tersedia</p>
                <h2 class="text-2xl font-black text-emerald-700 leading-none">{{ $stokTersedia }}</h2>
            </div>
        </div>

        <!-- Card: Stok Rendah -->
        <div class="bg-amber-50 p-5 rounded-3xl border border-amber-100 flex items-center gap-5">
            <div class="w-12 h-12 rounded-2xl bg-amber-500 text-white flex items-center justify-center shadow-lg shadow-amber-200 shrink-0">
                <i data-lucide="trending-down" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-amber-700 mb-1 uppercase tracking-widest leading-none">Stok Rendah</p>
                <h2 class="text-2xl font-black text-amber-700 leading-none">{{ $stokRendah }}</h2>
            </div>
        </div>

        <!-- Card: Stok Habis -->
        <div class="bg-rose-50 p-5 rounded-3xl border border-rose-100 flex items-center gap-5">
            <div class="w-12 h-12 rounded-2xl bg-rose-500 text-white flex items-center justify-center shadow-lg shadow-rose-200 shrink-0">
                <i data-lucide="alert-triangle" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-rose-700 mb-1 uppercase tracking-widest leading-none">Stok Habis</p>
                <h2 class="text-2xl font-black text-rose-700 leading-none">{{ $stokHabis }}</h2>
            </div>
        </div>
    </div>

    <!-- ALERT WARNING -->
    @if($lowStockProductsCount > 0 || $outOfStockProductsCount > 0)
    <div class="bg-orange-50 border-l-4 border-orange-500 p-4 rounded-xl flex gap-4 items-start shadow-sm">
        <div class="text-orange-500 shrink-0 mt-0.5">
            <i data-lucide="alert-triangle" class="w-5 h-5"></i>
        </div>
        <div>
            <h3 class="text-sm font-bold text-orange-800">Perhatian Stok!</h3>
            <p class="text-xs text-orange-700 mt-1 font-medium">
                @if($lowStockProductsCount > 0) Ada {{ $lowStockProductsCount }} produk dengan stok rendah @endif
                @if($lowStockProductsCount > 0 && $outOfStockProductsCount > 0) dan @endif
                @if($outOfStockProductsCount > 0) {{ $outOfStockProductsCount }} produk yang habis @endif. 
                Segera lakukan restocking.
            </p>
        </div>
    </div>
    @endif

    <!-- FILTERS -->
    <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-50 flex flex-col md:flex-row gap-4 items-center p-3">
        <form action="{{ url()->current() }}" method="GET" class="relative flex-1 w-full">
            <i data-lucide="search" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk, SKU, atau kategori..." class="w-full pl-11 pr-20 py-2.5 bg-white border border-gray-100 rounded-xl text-sm font-semibold text-gray-700 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-shadow">
            <button type="submit" class="absolute right-1.5 top-1/2 -translate-y-1/2 bg-blue-500 text-white hover:bg-blue-600 font-bold text-[10px] py-1.5 px-3 rounded-lg shadow-sm transition-colors">Cari</button>
        </form>
        <div class="relative w-full md:w-48">
            <select class="w-full px-4 py-2.5 bg-white border border-gray-100 rounded-xl text-sm font-bold text-gray-700 outline-none focus:border-blue-500 transition-shadow appearance-none cursor-pointer">
                <option>Semua Status</option>
                <option>Tersedia</option>
                <option>Stok Rendah</option>
                <option>Habis</option>
            </select>
            <i data-lucide="chevron-down" class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
        </div>
    </div>

    <!-- PRODUCT GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($products as $product)
        @php
            $warningThreshold = 50;
            $maxCapacity = max($product->stock * 1.5, 100); 
            $percentage = min(100, ($product->stock / $maxCapacity) * 100);

            if($product->stock == 0) {
                $statusClass = 'bg-rose-100 text-rose-600';
                $statusLabel = 'Habis';
                $barColor = 'bg-gray-200';
            } elseif ($product->stock <= $warningThreshold) {
                $statusClass = 'bg-amber-100 text-amber-600';
                $statusLabel = 'Stok Rendah';
                $barColor = 'bg-amber-500';
            } else {
                $statusClass = 'bg-emerald-100 text-emerald-600';
                $statusLabel = 'Tersedia';
                $barColor = 'bg-emerald-500';
            }
        @endphp
        <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-50 flex flex-col hover:shadow-lg transition-shadow duration-300">
            <!-- Top Section -->
            <div class="p-6 pb-0">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-black text-gray-900 leading-tight tracking-tight">{{ $product->name }}</h3>
                        <p class="text-xs font-semibold text-gray-400 mt-1 uppercase tracking-wider">{{ $product->category->name ?? 'Uncategorized' }} • SKU{{ str_pad($product->id, 3, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div class="flex gap-1 shrink-0">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-500 hover:text-blue-700 hover:bg-blue-50 p-2 rounded-xl transition" title="Edit Produk">
                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                        </a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rose-400 hover:text-rose-600 hover:bg-rose-50 p-2 rounded-xl transition" title="Hapus Produk">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Stock Bar -->
                <div class="mt-6 mb-2">
                    <div class="flex justify-between items-end mb-2">
                        <span class="text-xs font-bold text-gray-600">Stok Tersedia</span>
                        <span class="text-xs font-bold {{ $product->stock == 0 ? 'text-rose-600' : 'text-gray-900' }} tracking-widest">{{ $product->stock }} / <span class="text-gray-400 font-semibold">{{ floor($maxCapacity) }} unit</span></span>
                    </div>
                    <div class="w-full bg-gray-100 h-2.5 rounded-full overflow-hidden flex">
                        <div class="h-full {{ $barColor }} rounded-full transition-all duration-1000" style="width: {{ $percentage }}%"></div>
                    </div>
                    <p class="text-[10px] font-semibold text-gray-400 mt-2 tracking-wider">Minimal stok: {{ $warningThreshold }} unit</p>
                </div>
            </div>

            <div class="h-px bg-gray-50 mx-6 mt-4 mb-4"></div>

            <!-- Bottom Section -->
            <div class="p-6 pt-0 flex justify-between items-end">
                <div>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-1">Harga</span>
                    <p class="text-base font-black text-gray-900 leading-none mb-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    <p class="text-[9px] font-semibold text-gray-400 mt-2 uppercase tracking-wider">Update terakhir: {{ $product->updated_at->diffForHumans() }}</p>
                </div>
                
                <div class="flex flex-col items-end gap-2 text-right">
                    <span class="inline-flex px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $statusClass }} shadow-sm">
                        {{ $statusLabel }}
                    </span>
                    @if($product->stock <= $warningThreshold)
                        <a href="#" class="text-[10px] font-black text-blue-600 hover:text-blue-800 uppercase tracking-widest flex items-center gap-1 mt-1">
                            Restocking <i data-lucide="arrow-right" class="w-3 h-3"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-1 md:col-span-2 text-center py-16 bg-white rounded-3xl border border-gray-50 shadow-sm">
            <div class="w-16 h-16 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="package-search" class="w-8 h-8"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900">Produk Tidak Ditemukan</h3>
            <p class="text-sm text-gray-500 mt-1">Coba gunakan kata kunci pencarian yang lain.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
    <div class="mt-8 flex justify-center">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection
