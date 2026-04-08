@extends('layouts.shop')

@section('title', $product->name)

@section('content')

{{-- BREADCRUMB --}}
<div class="bg-gradient-to-r from-pink-500 to-red-400 py-6">
    <div class="max-w-7xl mx-auto px-6 text-white">
        <p class="text-sm opacity-90">
            <a href="{{ route('shop.home') }}" class="hover:underline">Home</a>
            <span class="mx-2">/</span>
            {{ $product->name }}
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-6 py-16">

    <div class="grid md:grid-cols-2 gap-16 items-start">

        {{-- IMAGE SECTION --}}
        <div class="bg-white rounded-3xl shadow-lg p-10 relative">

            @if($product->discount > 0)
                <span class="absolute top-6 left-6 bg-red-500 text-white text-xs font-bold px-4 py-1 rounded-full shadow">
                    -{{ $product->discount }}%
                </span>
            @endif

            <div class="bg-gray-50 rounded-2xl p-10 flex items-center justify-center">
                <img src="{{ asset($product->image ?? 'images/no-image.png') }}"
                     class="max-h-96 object-contain transition duration-300 hover:scale-105">
            </div>
        </div>

        {{-- PRODUCT INFO --}}
        <div>

            <h1 class="text-4xl font-bold text-gray-800 leading-tight">
                {{ $product->name }}
            </h1>

            {{-- RATING --}}
            <div class="flex items-center gap-2 mt-4">
                <div class="flex items-center gap-0.5 text-yellow-400 text-lg">
                    @for($i = 1; $i <= 5; $i++)
                        @if($product->averageRating >= $i)
                            ★
                        @elseif($product->averageRating > ($i - 1))
                            {{-- Optional: Handle half star if needed, but keeping it simple like Alfagift --}}
                            ★
                        @else
                            ☆
                        @endif
                    @endfor
                </div>
                <span class="text-gray-500 text-sm font-bold">
                    {{ number_format($product->averageRating, 1) }} / 5.0
                </span>
                <span class="text-gray-400 text-sm ml-2">
                    ({{ $product->reviews->count() }} Ulasan)
                </span>
            </div>

            {{-- PRICE --}}
            <div class="mt-6">
                @if($product->discount > 0)
                    @php
                        $final = $product->price - ($product->price * $product->discount / 100);
                    @endphp

                    <div class="flex items-center gap-4">
                        <p class="text-gray-400 line-through text-lg">
                            Rp {{ number_format($product->price) }}
                        </p>
                        <p class="text-3xl font-bold text-red-500">
                            Rp {{ number_format($final) }}
                        </p>
                    </div>
                @else
                    <p class="text-3xl font-bold text-red-500">
                        Rp {{ number_format($product->price) }}
                    </p>
                @endif
            </div>

            {{-- STOCK --}}
            <div class="mt-4">
                @if($product->stock > 0)
                    <span class="text-green-600 font-medium text-sm">
                        ✔ In Stock ({{ $product->stock }} tersedia)
                    </span>
                @else
                    <span class="text-red-500 font-medium text-sm">
                        ✖ Out of Stock
                    </span>
                @endif
            </div>

            {{-- DESCRIPTION --}}
            <p class="mt-6 text-gray-600 leading-relaxed text-base">
                {{ $product->description ?? 'No description available.' }}
            </p>

            {{-- WARRANTY SECTION --}}
            <div class="mt-8 bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-xl">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-100 p-2 rounded-lg text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-blue-900 uppercase tracking-wider">Garansi Kepuasan</h4>
                        <p class="text-blue-700 text-sm mt-0.5">
                            Jika barang diterima dalam keadaan rusak atau tidak sesuai, Anda dapat mengajukan pengembalian dana 100%.
                        </p>
                    </div>
                </div>
            </div>

            {{-- ACTION SECTION --}}
            <div class="mt-8 flex flex-col sm:flex-row sm:items-center gap-6">
                
                {{-- Add To Cart --}}
                @auth
                <div class="flex items-center gap-4">
                    <form action="{{ route('customer.cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button class="btn-add-to-cart px-10 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl shadow-md transition font-semibold" data-product-id="{{ $product->id }}">
                            Add To Cart
                        </button>
                    </form>
                    
                    <button class="btn-wishlist-toggle w-12 h-12 flex items-center justify-center rounded-xl border-2 {{ App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists() ? 'border-red-500 text-red-500 bg-red-50' : 'border-gray-200 text-gray-300 bg-white' }} hover:bg-red-50 hover:border-red-300 hover:text-red-400 transition transform hover:scale-105"
                            data-product-id="{{ $product->id }}"
                            data-action-url="{{ route('customer.wishlist.toggle', $product->id) }}">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.657 0L10 6.343l1.171-1.171a4 4 0 115.657 5.657L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/></svg>
                    </button>
                </div>
                @else
                <a href="/login"
                   class="px-10 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl shadow-md transition font-semibold">
                    Login To Buy
                </a>
                @endauth

            </div>

        </div>

    </div>

    {{-- CUSTOMER REVIEWS SECTION --}}
    <div class="mt-20 border-t border-gray-100 pt-20">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-6">
            <div>
                <h2 class="text-3xl font-black text-gray-900 tracking-tighter">Ulasan Pelanggan</h2>
                <p class="text-gray-500 mt-1 font-medium">Apa kata mereka yang sudah membeli produk ini?</p>
            </div>
            <div class="bg-gray-50 px-6 py-4 rounded-3xl flex items-center gap-6 border border-gray-100">
                <div class="text-center border-r border-gray-200 pr-6">
                    <p class="text-4xl font-black text-gray-900 leading-none">{{ number_format($product->averageRating, 1) }}</p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-2">DARI 5.0</p>
                </div>
                <div>
                    <div class="flex items-center gap-0.5 text-yellow-500 mb-1">
                        @for($i = 1; $i <= 5; $i++)
                            <i data-lucide="star" class="w-4 h-4 {{ $i <= round($product->averageRating) ? 'fill-current' : 'text-gray-200' }}"></i>
                        @endfor
                    </div>
                    <p class="text-xs font-bold text-gray-500 italic">{{ $product->reviews->count() }} Reputasi Produk</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @forelse($product->reviews as $review)
                <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm hover:shadow-md transition duration-300">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-rose-50 rounded-full flex items-center justify-center text-rose-600 font-bold">
                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 leading-none">{{ $review->user->name }}</h4>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1.5">{{ $review->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-0.5 text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                                <i data-lucide="star" class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-200' }}"></i>
                            @endfor
                        </div>
                    </div>
                    
                    <p class="text-gray-600 leading-relaxed text-sm mb-6">"{{ $review->comment }}"</p>
                    
                    @if($review->photo_path)
                        <div class="relative group w-24 h-24">
                            <img src="{{ Storage::url($review->photo_path) }}" 
                                 class="w-full h-full object-cover rounded-2xl border border-gray-100 shadow-sm">
                            <a href="{{ Storage::url($review->photo_path) }}" target="_blank" class="absolute inset-0 bg-black/40 rounded-2xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                <i data-lucide="zoom-in" class="w-5 h-5 text-white"></i>
                            </a>
                        </div>
                    @endif
                </div>
            @empty
                <div class="md:col-span-2 bg-gray-50 rounded-[2.5rem] py-20 text-center border-2 border-dashed border-gray-200">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                        <i data-lucide="message-square" class="w-8 h-8 text-gray-300"></i>
                    </div>
                    <h3 class="text-gray-900 font-bold">Belum ada ulasan</h3>
                    <p class="text-gray-400 text-sm mt-1">Jadilah yang pertama memberikan ulasan untuk produk ini!</p>
                </div>
            @endforelse
        </div>
    </div>
</div>


{{-- RELATED PRODUCTS --}}
<section class="bg-gray-50 py-20 mt-16">
    <div class="max-w-7xl mx-auto px-6">

        <h2 class="text-2xl font-bold mb-12 text-center">
            You May Also Like
        </h2>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">

            @foreach($relatedProducts as $item)
                <div class="bg-white rounded-2xl border border-gray-100 p-5 hover:shadow-xl hover:-translate-y-1 transition duration-300">

                    <a href="{{ route('product.detail', $item->slug) }}">
                        <div class="h-44 flex items-center justify-center mb-4 bg-gray-50 rounded-xl overflow-hidden">
                            <img src="{{ asset($item->image ?? 'images/no-image.png') }}"
                                 class="max-h-40 object-contain transition duration-300 hover:scale-110">
                        </div>

                        <h3 class="text-sm font-semibold text-gray-800 hover:text-green-600 transition">
                            {{ $item->name }}
                        </h3>
                    </a>

                    <p class="text-red-500 font-bold mt-2">
                        Rp {{ number_format($item->price) }}
                    </p>

                </div>
            @endforeach

        </div>

    </div>
</section>

@endsection