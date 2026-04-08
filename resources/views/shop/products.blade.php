@extends('layouts.shop')

@section('title', 'Almart - Semua Produk')

@section('content')

<!-- ================= SHOP HEADER ================= -->
<section class="bg-gradient-to-r from-green-50 to-emerald-50 py-16 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-6">
        <h1 class="text-4xl font-bold text-gray-800">
            {{ request('category') ? 'Kategori: ' . ucwords(str_replace('-', ' ', request('category'))) : 'Semua Produk' }}
        </h1>
        <p class="text-gray-600 mt-2">Temukan berbagai produk segar dan berkualitas untuk kebutuhan harian Anda.</p>
    </div>
</section>

<!-- ================= PRODUCT LISTING ================= -->
<section class="py-16 bg-gray-50 min-h-[60vh]">
    <div class="max-w-7xl mx-auto px-6">
        
        <!-- Filter Bar (Optional if you want to add later) -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-6">
            <p class="text-gray-500 text-sm">Menampilkan {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} dari {{ $products->total() }} produk</p>
            
            <div class="flex gap-4 overflow-x-auto pb-2 w-full md:w-auto">
                 <a href="{{ route('products.all') }}" 
                    class="px-4 py-2 rounded-full whitespace-nowrap text-sm font-medium {{ !request('category') ? 'bg-green-600 text-white shadow-md' : 'bg-white border text-gray-600 hover:border-green-500' }} transition">
                    Semua
                 </a>
                 @foreach($categories as $category)
                    <a href="{{ route('products.all', ['category' => $category->slug]) }}" 
                       class="px-4 py-2 rounded-full whitespace-nowrap text-sm font-medium {{ request('category') == $category->slug ? 'bg-green-600 text-white shadow-md' : 'bg-white border text-gray-600 hover:border-green-500' }} transition">
                       {{ $category->name }}
                    </a>
                 @endforeach
            </div>
        </div>

        @if($products->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8">
                @foreach($products as $product)
                <div class="group bg-white rounded-2xl border border-gray-100 p-5 hover:shadow-2xl hover:-translate-y-1 transition duration-300 relative">

                    @if($product->discount > 0)
                        <span class="absolute top-4 left-4 bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow z-10">
                            -{{ $product->discount }}%
                        </span>
                    @endif

                    @auth
                        <button class="btn-wishlist-toggle absolute top-4 right-4 {{ App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists() ? 'text-red-500' : 'text-gray-300' }} hover:text-red-600 transition duration-300 transform hover:scale-125 z-10" 
                                data-product-id="{{ $product->id }}"
                                data-action-url="{{ route('customer.wishlist.toggle', $product->id) }}">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.657 0L10 6.343l1.171-1.171a4 4 0 115.657 5.657L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/></svg>
                        </button>
                    @endauth

                    <!-- IMAGE -->
                     <div class="h-40 flex items-center justify-center mb-4 overflow-hidden bg-gray-50 rounded-xl">
                        <a href="{{ route('product.detail', $product->slug) }}" class="w-full h-full flex items-center justify-center">
                            <img src="{{ asset($product->image ?? 'images/no-image.png') }}"
                                 class="max-h-36 object-contain group-hover:scale-110 transition duration-300"
                                 alt="{{ $product->name }}">
                        </a>
                    </div>

                    <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">
                        {{ $product->category->name ?? '-' }}
                    </p>

                    <h3 class="text-sm font-semibold text-gray-800 mt-1 line-clamp-2 h-10">
                        {{ $product->name }}
                    </h3>

                    <div class="flex items-center gap-1 text-yellow-400 text-[10px] mt-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($product->averageRating >= $i)
                                ★
                            @else
                                ☆
                            @endif
                        @endfor
                        <span class="text-gray-400 ml-1 font-bold">({{ count($product->reviews) }})</span>
                    </div>

                    <div class="mt-3">
                        @if($product->discount > 0)
                            @php
                                $final = $product->price - ($product->price * $product->discount / 100);
                            @endphp
                            <p class="text-gray-400 line-through text-[11px]">
                                Rp {{ number_format($product->price) }}
                            </p>
                            <p class="text-green-600 font-bold text-base">
                                Rp {{ number_format($final) }}
                            </p>
                        @else
                            <p class="text-green-600 font-bold text-base">
                                Rp {{ number_format($product->price) }}
                            </p>
                        @endif
                    </div>

                    @auth
                       <form action="{{ route('customer.cart.add', $product->id) }}" method="POST">
                            @csrf
                        <button type="button" class="btn-add-to-cart w-full mt-5 bg-red-500 text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-red-600 transition shadow-sm" data-product-id="{{ $product->id }}">
                            Tambah
                        </button>
                        </form>
                    @else
                        <a href="/login"
                           class="block w-full mt-5 bg-red-500 text-white py-2.5 rounded-xl text-sm text-center font-semibold hover:bg-red-600 transition shadow-sm">
                            Tambah
                        </a>
                    @endauth

                </div>
                @endforeach
            </div>

            <!-- PAGINATION -->
            <div class="mt-16 flex justify-center">
                {{ $products->onEachSide(1)->links() }}
            </div>

        @else
            <div class="text-center py-20 bg-white rounded-3xl border shadow-sm">
                <img src="{{ asset('images/empty-search.png') }}" class="h-48 mx-auto opacity-20 grayscale">
                <h3 class="text-xl font-bold text-gray-800 mt-6">Produk tidak ditemukan</h3>
                <p class="text-gray-500 mt-2">Maaf, kami tidak menemukan produk yang Anda cari.</p>
                <a href="{{ route('products.all') }}" class="mt-8 inline-block px-8 py-3 bg-green-600 text-white rounded-xl font-semibold">Lihat Semua Produk</a>
            </div>
        @endif

    </div>
</section>

@endsection
