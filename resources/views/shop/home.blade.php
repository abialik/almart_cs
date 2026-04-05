@extends('layouts.shop')

@section('title', 'Almart')

@section('content')

<!-- ================= HERO ================= -->
<section class="bg-gradient-to-r from-green-100 to-emerald-50 py-28">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-16 items-center">

        <div>
            <h1 class="text-5xl font-bold text-gray-800 leading-tight">
                Fresh Daily Groceries
                <span class="text-green-600">Delivered Fast</span>
            </h1>

            <p class="mt-6 text-gray-600 text-lg">
                Carefully selected fruits, vegetables, snacks and refreshing drinks delivered directly to your door.
            </p>

            @guest
                <a href="/login"
                   class="mt-8 inline-block px-8 py-3 bg-red-500 text-white rounded-xl font-semibold hover:bg-red-600 shadow-md hover:shadow-lg transition">
                    Mulai Belanja
                </a>
            @endguest   
        </div>

        <div class="flex justify-center">
            <img src="{{ asset('images/banner.png') }}"
                 class="rounded-3xl shadow-2xl w-full max-w-xl">
        </div>

    </div>
</section>



<!-- ================= POPULAR PRODUCTS ================= -->
<section class="max-w-7xl mx-auto px-6 py-20">

    <div class="flex justify-between items-center mb-12">
        <h2 class="text-3xl font-bold text-gray-800">Produk popular</h2>

        <div class="hidden md:flex gap-8 text-sm font-medium">
            <a href="/" class="hover:text-green-600 transition">All</a>
            @foreach($categories as $category)
                <a href="/?category={{ $category->slug }}"
                   class="hover:text-green-600 transition">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-5 gap-8">

        @foreach($products as $product)
        <div class="group bg-white rounded-2xl border border-gray-100 p-5 hover:shadow-2xl hover:-translate-y-1 transition duration-300 relative">

            @if($product->discount > 0)
                <span class="absolute top-4 left-4 bg-red-500 text-white text-xs font-semibold px-3 py-1 rounded-full shadow">
                    -{{ $product->discount }}%
                </span>
            @endif

            @auth
                <button class="btn-wishlist-toggle absolute top-4 right-4 {{ App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists() ? 'text-red-500' : 'text-gray-300' }} hover:text-red-600 transition duration-300 transform hover:scale-125" 
                        data-product-id="{{ $product->id }}"
                        data-action-url="{{ route('customer.wishlist.toggle', $product->id) }}">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.657 0L10 6.343l1.171-1.171a4 4 0 115.657 5.657L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/></svg>
                </button>
            @endauth

            <!-- IMAGE -->
             <div class="h-44 flex items-center justify-center mb-4 overflow-hidden bg-gray-50 rounded-xl">
                <a href="{{ route('product.detail', $product->slug) }}">
                    <img src="{{ asset($product->image ?? 'images/no-image.png') }}"
                         class="max-h-40 object-contain group-hover:scale-110 transition duration-300"
                         alt="{{ $product->name }}">
                </a>
            </div>

            <p class="text-xs text-gray-400 uppercase tracking-wide">
                {{ $product->category->name ?? '-' }}
            </p>

            <h3 class="text-sm font-semibold text-gray-800 mt-1 line-clamp-2">
                {{ $product->name }}
            </h3>

            <div class="flex items-center gap-1 text-yellow-400 text-xs mt-2">
                @for($i = 1; $i <= 5; $i++)
                    @if($product->rating >= $i)
                        ★
                    @else
                        ☆
                    @endif
                @endfor
                <span class="text-gray-500 ml-1">{{ $product->rating }}</span>
            </div>

            <div class="mt-3">
                @if($product->discount > 0)
                    @php
                        $final = $product->price - ($product->price * $product->discount / 100);
                    @endphp
                    <p class="text-gray-400 line-through text-xs">
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
                <button class="btn-add-to-cart w-full mt-5 bg-red-500 text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-red-600 transition shadow-sm" data-product-id="{{ $product->id }}">
                    Tambah ke Keranjang
                </button>
                </form>
            @else
                <a href="/login"
                   class="block w-full mt-5 bg-red-500 text-white py-2.5 rounded-xl text-sm text-center font-semibold hover:bg-red-600 transition shadow-sm">
                    Tambah ke Keranjang
                </a>
            @endauth

        </div>
        @endforeach

    </div>

</section>



<!-- ================= DAILY BEST SELLS ================= -->
<section class="bg-gray-50 py-20">
    <div class="max-w-7xl mx-auto px-6">

        <div class="flex justify-between items-center mb-12">
            <h2 class="text-3xl font-bold">Daily Best Sells</h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-5 gap-8">

            @foreach($products->take(5) as $product)
            <div class="bg-white rounded-2xl border border-gray-100 p-5 hover:shadow-lg transition">

                  <div class="h-44 flex items-center justify-center mb-4 overflow-hidden bg-gray-50 rounded-xl">
                <a href="{{ route('product.detail', $product->slug) }}">
                    <img src="{{ asset($product->image ?? 'images/no-image.png') }}"
                         class="max-h-40 object-contain group-hover:scale-110 transition duration-300"
                         alt="{{ $product->name }}">
                </a>
            </div>


                <h3 class="text-sm font-semibold text-gray-800">
                    {{ $product->name }}
                </h3>

                <p class="text-green-600 font-bold text-base mt-2">
                    Rp {{ number_format($product->price) }}
                </p>

                <div class="mt-4 bg-gray-200 h-2 rounded-full">
                    <div class="bg-red-500 h-2 rounded-full transition-all"
                         style="width: {{ rand(30,90) }}%">
                    </div>
                </div>

                @auth
                   <form action="{{ route('customer.cart.add', $product->id) }}" method="POST">
                        @csrf
                    <button class="btn-add-to-cart w-full mt-4 bg-red-500 text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-red-600 transition shadow-sm" data-product-id="{{ $product->id }}">
                        Tambah ke Keranjang
                    </button>
                    </form>
                @else
                    <a href="/login"
                       class="block w-full mt-4 bg-red-500 text-white py-2.5 rounded-xl text-sm text-center font-semibold hover:bg-red-600 transition shadow-sm">
                        Tambah ke Keranjang
                    </a>
                @endauth

            </div>
            @endforeach

        </div>

    </div>
</section>



<!-- ================= CTA BANNER ================= -->
<section class="pb-24">
    <div class="max-w-7xl mx-auto px-6">

        <div class="bg-gradient-to-r from-green-100 to-emerald-50 rounded-3xl p-16 flex flex-col md:flex-row items-center justify-between shadow-lg">

            <div>
                <h2 class="text-3xl font-bold text-gray-800">
                    Stay home & get your daily needs
                </h2>

                <p class="mt-4 text-gray-600">
                    Start your daily shopping with Almart today.
                </p>

                <div class="mt-8 flex">
                    <input type="email"
                           placeholder="Your email address"
                           class="px-5 py-3 rounded-l-xl border border-gray-300 w-72 text-sm focus:outline-none">
                    <button class="bg-red-500 text-white px-8 rounded-r-xl text-sm hover:bg-red-600 transition">
                        Subscribe
                    </button>
                </div>
            </div>

            <img src="{{ asset('images/banner-9-min.png') }}"
                 class="h-64 mt-10 md:mt-0">

        </div>

    </div>
</section>
@endsection