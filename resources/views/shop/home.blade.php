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
<!-- ================= CATEGORY & PRODUCT SECTION ================= -->
<section class="max-w-7xl mx-auto px-6 py-20" id="products-section">
    
    <!-- STICKY HEADER FOR CATEGORIES -->
    <div class="sticky top-20 z-40 bg-gray-50/80 backdrop-blur-md pb-6 pt-2">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            
            <div class="border-l-4 border-green-600 pl-4">
                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Produk Terlengkap</h2>
                <p class="text-xs text-gray-500 mt-1 uppercase tracking-widest font-bold">Pilih kategori kesukaanmu</p>
            </div>

            <!-- CATEGORY PILLS -->
            <div class="flex gap-2 overflow-x-auto pb-2 scrollbar-hide">
                 <a href="/#products-section" 
                    class="px-5 py-2 rounded-2xl whitespace-nowrap text-sm font-bold transition-all border {{ !request('category') ? 'bg-green-600 text-white border-green-600 shadow-lg shadow-green-200' : 'bg-white text-gray-500 border-gray-100 hover:border-green-400 hover:text-green-600' }}">
                    Semua Produk
                 </a>
                @foreach($categories as $category)
                    <a href="/?category={{ $category->slug }}#products-section"
                       class="px-5 py-2 rounded-2xl whitespace-nowrap text-sm font-bold transition-all border {{ request('category') == $category->slug ? 'bg-green-600 text-white border-green-600 shadow-lg shadow-green-200' : 'bg-white text-gray-500 border-gray-100 hover:border-green-400 hover:text-green-600' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- GRID START -->
    <div class="mt-10">

    @if($products->count() > 0)
    <div class="grid grid-cols-2 md:grid-cols-5 gap-8">

        @foreach($products as $product)
        <div class="group bg-white rounded-2xl border border-gray-100 p-5 hover:shadow-2xl hover:-translate-y-1 transition duration-300 relative">

            @if($product->discount > 0)
                <span class="absolute top-4 left-4 bg-red-500 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full shadow z-10">
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
             <div class="h-44 flex items-center justify-center mb-4 overflow-hidden bg-gray-50 rounded-xl">
                <a href="{{ route('product.detail', $product->slug) }}">
                    <img src="{{ asset($product->image ?? 'images/no-image.png') }}"
                         class="max-h-40 object-contain group-hover:scale-110 transition duration-300"
                         alt="{{ $product->name }}">
                </a>
            </div>

            <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">
                {{ $product->category->name ?? '-' }}
            </p>

            <h3 class="text-sm font-semibold text-gray-800 mt-1 line-clamp-2 h-10">
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
                <button type="button" class="btn-add-to-cart w-full mt-5 bg-red-500 text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-red-600 transition shadow-sm" data-product-id="{{ $product->id }}">
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

    <!-- PAGINATION -->
    <div class="mt-16 flex justify-center">
        {{ $products->links() }}
    </div>

    @else
    <div class="text-center py-20 bg-white rounded-3xl border border-gray-100 shadow-sm">
        <div class="mb-6">
             <svg class="w-16 h-16 mx-auto text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
             </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-800">Oops! Produk tidak ditemukan</h3>
        <p class="text-gray-500 mt-2">Maaf, kami tidak menemukan produk yang Anda cari.</p>
        <a href="/" class="mt-6 inline-block px-8 py-2.5 bg-green-600 text-white rounded-xl font-semibold">Lihat Semua Produk</a>
    </div>
    @endif

</section>



<!-- ================= DAILY BEST SELLS ================= -->
<section class="bg-gray-50 py-24">
    <div class="max-w-7xl mx-auto px-6">

        <div class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Daily Best Sells</h2>
                <p class="text-[13px] text-gray-500 mt-1">Dapatkan penawaran terbaik setiap hari.</p>
            </div>
            
            <div class="hidden md:flex gap-2">
                <button class="bg-white p-3 rounded-xl border border-gray-100 hover:bg-rose-500 hover:text-white transition shadow-sm group" id="prev-btn" title="Sebelumnya">
                    <i data-lucide="chevron-left" class="w-5 h-5"></i>
                </button>
                <button class="bg-white p-3 rounded-xl border border-gray-100 hover:bg-rose-500 hover:text-white transition shadow-sm group" id="next-btn" title="Selanjutnya">
                    <i data-lucide="chevron-right" class="w-5 h-5"></i>
                </button>
            </div>
        </div>

        <div id="best-sells-container" class="flex gap-8 overflow-x-auto pb-8 snap-x snap-mandatory scrollbar-hide scroll-smooth">

            @foreach($bestSells as $product)
            <div class="group bg-white rounded-3xl border border-gray-100 p-6 w-72 flex-shrink-0 snap-start hover:shadow-2xl hover:-translate-y-2 transition duration-500 relative">

                @if($product->discount > 0)
                    <span class="absolute top-5 left-5 bg-black text-white text-[10px] font-bold px-3 py-1 rounded-full shadow-lg z-10">
                        BEST DEAL
                    </span>
                @endif

                <div class="h-48 flex items-center justify-center mb-6 overflow-hidden bg-gray-50 rounded-2xl relative">
                    <a href="{{ route('product.detail', $product->slug) }}" class="w-full h-full flex items-center justify-center p-6">
                        <img src="{{ asset($product->image ?? 'images/no-image.png') }}"
                             class="max-h-full object-contain group-hover:scale-110 transition duration-500"
                             alt="{{ $product->name }}">
                    </a>
                </div>

                <p class="text-[10px] text-green-600 uppercase tracking-widest font-bold">
                    {{ $product->category->name ?? '-' }}
                </p>

                <h3 class="text-base font-bold text-gray-800 mt-1 line-clamp-2 h-12">
                    {{ $product->name }}
                </h3>

                <div class="mt-4 flex items-center justify-between">
                    <div>
                         @if($product->discount > 0)
                            @php
                                $final = $product->price - ($product->price * $product->discount / 100);
                            @endphp
                            <p class="text-gray-400 line-through text-[10px] italic">
                                Rp {{ number_format($product->price) }}
                            </p>
                            <p class="text-green-600 font-extrabold text-xl">
                                Rp {{ number_format($final) }}
                            </p>
                        @else
                            <p class="text-green-600 font-extrabold text-xl">
                                Rp {{ number_format($product->price) }}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="mt-4">
                    @auth
                        <form action="{{ route('customer.cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="button" class="btn-add-to-cart w-full bg-red-500 text-white py-3 rounded-2xl text-[11px] font-bold hover:bg-red-600 transition shadow-sm flex items-center justify-center gap-2" data-product-id="{{ $product->id }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
                                <span>Tambah ke Keranjang</span>
                            </button>
                        </form>
                    @else
                        <a href="/login" class="w-full bg-red-500 text-white py-3 rounded-2xl text-[11px] font-bold hover:bg-red-600 transition shadow-sm flex items-center justify-center gap-2">
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
                             <span>Tambah ke Keranjang</span>
                        </a>
                    @endauth
                </div>

                <!-- STOCK PROGRESS BAR -->
                <div class="mt-6">
                    <div class="flex justify-between text-[10px] mb-2 font-bold text-gray-400 uppercase tracking-tighter">
                        <span>Terjual: {{ $product->sold_units ?? 0 }}</span>
                        <span>Stok: {{ $product->stock }}</span>
                    </div>
                    <div class="bg-gray-100 h-1.5 rounded-full overflow-hidden">
                        <div class="bg-gradient-to-r from-orange-400 to-red-500 h-full rounded-full transition-all duration-1000"
                             style="width: {{ $product->stock > 0 ? min(100, (($product->sold_units ?? 0) / ($product->stock + ($product->sold_units ?? 0))) * 100) : 0 }}%">
                        </div>
                    </div>
                </div>

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

                <div class="mt-8 flex" id="newsletter-form" data-url="{{ route('newsletter.subscribe') }}" data-token="{{ csrf_token() }}">
                    <input type="email" id="newsletter-email"
                           placeholder="Your email address"
                           class="px-5 py-3 rounded-l-xl border border-gray-300 w-72 text-sm focus:outline-none">
                    <button id="subscribe-btn" class="bg-red-500 text-white px-8 rounded-r-xl text-sm hover:bg-red-600 transition flex items-center justify-center min-w-[120px]">
                        Subscribe
                    </button>
                </div>
            </div>

            <img src="{{ asset('images/banner-9-min.png') }}"
                 class="h-64 mt-10 md:mt-0">

        </div>

    </div>
</section>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('best-sells-container');
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');

        if (container && prevBtn && nextBtn) {
            nextBtn.addEventListener('click', () => {
                const scrollAmount = container.offsetWidth - 100;
                container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            });

            prevBtn.addEventListener('click', () => {
                const scrollAmount = container.offsetWidth - 100;
                container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            });
        }
    });
</script>
@endpush
@endsection