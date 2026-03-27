@extends('layouts.shop')

@section('title', 'All Products')

@section('content')

<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6">

        <h1 class="text-3xl font-bold mb-10">
            All Products
        </h1>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

            @foreach($products as $product)
                <div class="bg-white rounded-2xl p-4 border hover:shadow-xl transition">

                    <div class="h-44 bg-gray-100 rounded-xl mb-4 overflow-hidden">
                        <img src="{{ $product->image }}"
                             class="h-full w-full object-cover">
                    </div>

                    <h3 class="text-sm font-semibold">
                        {{ $product->name }}
                    </h3>

                    <p class="text-green-600 font-bold mt-2 text-sm">
                        Rp {{ number_format($product->price) }}
                    </p>

                </div>
            @endforeach

        </div>

        <div class="mt-10">
            {{ $products->links() }}
        </div>

    </div>
</section>

@endsection
