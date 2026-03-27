@extends('layouts.shop')

@section('title', 'Wishlist Saya — Almart')

@section('content')

{{-- ===== PAGE HEADER ===== --}}
<div class="bg-gradient-to-r from-pink-500 to-rose-600 py-10 mb-10 shadow-sm">
    <div class="max-w-6xl mx-auto px-6 text-white text-center sm:text-left">
        <h2 class="text-3xl font-extrabold mb-2">Wishlist Saya</h2>
        <p class="text-pink-100 opacity-90">Simpan produk favorit Anda dan beli kapan saja.</p>
    </div>
</div>

<div class="max-w-6xl mx-auto px-6 pb-24">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
        @forelse($wishlists as $wish)
            @php $product = $wish->product; @endphp
            <div class="group bg-white rounded-3xl border border-gray-100 p-5 hover:shadow-2xl hover:-translate-y-2 transition duration-500 relative overflow-hidden">
                
                {{-- Remove Button --}}
                <form action="{{ route('customer.wishlist.remove', $wish->id) }}" method="POST" class="absolute top-4 right-4 z-10">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-8 h-8 bg-white/80 backdrop-blur rounded-full flex items-center justify-center text-gray-300 hover:text-red-500 shadow-sm transition">
                         <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                    </button>
                </form>

                <a href="{{ route('product.detail', $product->slug) }}">
                    <div class="h-48 flex items-center justify-center mb-5 bg-gray-50 rounded-2xl overflow-hidden p-4 group-hover:bg-pink-50/50 transition duration-500">
                        <img src="{{ asset($product->image ?? 'images/no-image.png') }}"
                             class="max-h-40 object-contain transition duration-700 group-hover:scale-110"
                             alt="{{ $product->name }}">
                    </div>

                    <p class="text-[10px] text-pink-500 font-black uppercase tracking-widest mb-1">{{ $product->category->name ?? '-' }}</p>
                    <h3 class="text-sm font-bold text-gray-800 line-clamp-2 min-h-[2.5rem] group-hover:text-pink-600 transition">
                        {{ $product->name }}
                    </h3>

                    <div class="mt-4 flex items-end justify-between">
                        <div>
                            @if($product->discount > 0)
                                @php $final = $product->price - ($product->price * $product->discount / 100); @endphp
                                <p class="text-[10px] text-gray-400 line-through">Rp {{ number_format($product->price) }}</p>
                                <p class="text-lg font-black text-red-500 tracking-tighter">Rp {{ number_format($final) }}</p>
                            @else
                                <p class="text-lg font-black text-gray-900 tracking-tighter">Rp {{ number_format($product->price) }}</p>
                            @endif
                        </div>
                    </div>
                </a>

                @auth
                    <form action="{{ route('customer.cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button class="btn-add-to-cart w-full mt-5 bg-gray-900 text-white py-3 rounded-2xl text-xs font-black uppercase tracking-[0.2em] border-b-4 border-black active:translate-y-1 active:border-b-0 hover:bg-gray-800 transition-all shadow-lg shadow-gray-200" data-product-id="{{ $product->id }}">
                            Beli Sekarang
                        </button>
                    </form>
                @endauth

            </div>
        @empty
            <div class="col-span-full py-20 text-center">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Wishlist Anda Kosong</h3>
                <p class="text-gray-400 mb-8 max-w-sm mx-auto">Anda belum menambahkan produk favorit apapun. Mulai cari barang yang Anda suka!</p>
                <a href="{{ route('shop.home') }}" class="inline-block px-10 py-4 bg-pink-500 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-pink-100 hover:bg-pink-600 transition">
                    Jelajahi Produk
                </a>
            </div>
        @endforelse
    </div>
</div>

@endsection
