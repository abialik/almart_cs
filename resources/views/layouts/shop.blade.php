<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Almart')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800 antialiased">

<!-- ================= NAVBAR ================= -->
<header class="bg-white/95 backdrop-blur sticky top-0 z-50 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between gap-10">

        <!-- LOGO -->
        <a href="/" class="flex items-center gap-3 group">
            <img src="{{ asset('images/logo.png') }}" class="h-10 w-auto">
            <div class="leading-tight">
                <p class="font-bold text-lg text-gray-900 group-hover:text-green-600 transition">
                    Almart
                </p>
                <p class="text-xs text-gray-500">
                    Segar Setiap Hari
                </p>
            </div>
        </a>

        <!-- SEARCH -->
        <form action="/" method="GET" class="flex flex-1 max-w-2xl relative">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Cari buah, sayuran, minuman..."
                   class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl bg-gray-100 focus:bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none text-sm transition">

            <svg class="w-5 h-5 absolute left-4 top-3.5 text-gray-400"
                 fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/>
                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
        </form>

        <!-- RIGHT SIDE -->
        <div class="flex items-center gap-8 text-sm">

            <!-- Wishlist -->
            <a href="{{ route('customer.wishlist.index') }}" class="relative text-gray-600 hover:text-red-500 transition duration-200">
                <svg class="w-6 h-6"
                     fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path d="M20.8 4.6a5.5 5.5 0 00-7.8 0L12 5.6l-1-1a5.5 5.5 0 10-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 000-7.8z"/>
                </svg>
            </a>

           {{-- Cart --}}
@auth
@php
    $cartCount = \App\Models\CartItem::whereHas('cart', function ($q) {
        $q->where('user_id', auth()->id());
    })->sum('qty');
@endphp
@endauth

<a href="{{ route('customer.cart.index') }}" 
   class="relative text-gray-600 hover:text-green-600 transition duration-200">

    <svg class="w-6 h-6"
         fill="none" stroke="currentColor" stroke-width="2"
         viewBox="0 0 24 24">
        <circle cx="9" cy="21" r="1"/>
        <circle cx="20" cy="21" r="1"/>
        <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>
    </svg>

    @auth
        @if($cartCount > 0)
            <span id="cart-counter" class="absolute -top-2 -right-2 bg-red-500 text-white text-[11px] w-5 h-5 rounded-full flex items-center justify-center shadow-sm">
                {{ $cartCount }}
            </span>
        @else
            <span id="cart-counter" class="hidden absolute -top-2 -right-2 bg-red-500 text-white text-[11px] w-5 h-5 rounded-full flex items-center justify-center shadow-sm">
                0
            </span>
        @endif
    @else
        <span id="cart-counter" class="hidden absolute -top-2 -right-2 bg-red-500 text-white text-[11px] w-5 h-5 rounded-full flex items-center justify-center shadow-sm">
            0
        </span>
    @endauth

</a>

            @auth

            <!-- PROFILE -->
            <div class="relative group">

                <button class="flex items-center gap-3 focus:outline-none">

                    <!-- Avatar -->
                    <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 text-white flex items-center justify-center rounded-full font-semibold shadow-md">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>

                    <svg class="w-4 h-4 text-gray-400 group-hover:rotate-180 transition duration-200"
                         fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path d="M6 9l6 6 6-6"/>
                    </svg>
                </button>

                <!-- DROPDOWN -->
                <div class="absolute right-0 mt-4 w-72 bg-white rounded-2xl shadow-xl border border-gray-100
                            opacity-0 invisible group-hover:opacity-100 group-hover:visible 
                            transition duration-200 z-50">

                    <!-- User Info -->
                    <div class="px-6 py-5 border-b border-gray-100">
                        <p class="font-semibold text-gray-900">
                            {{ auth()->user()->name }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ auth()->user()->email }}
                        </p>
                        <span class="inline-block mt-3 px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full">
                            {{ ucfirst(auth()->user()->role) }}
                        </span>
                    </div>

                    <!-- Menu -->
                    <div class="py-2 text-sm text-gray-700">

                        <a href="{{ route('shop.home') }}"
                           class="block px-6 py-3 hover:bg-gray-50 transition">
                            Beranda
                        </a>

                        <a href="{{ route('profile.edit') }}"
                           class="block px-6 py-3 hover:bg-gray-50 transition">
                            Profile Saya
                        </a>

                        <a href="{{ route('customer.orders.index') }}"
                           class="block px-6 py-3 hover:bg-gray-50 transition">
                            Pesanan Saya
                        </a>

                        <a href="{{ route('customer.orders.status') }}"
                           class="block px-6 py-3 hover:bg-gray-50 transition">
                            Status Pesanan
                        </a>

                        <a href="{{ route('customer.wishlist.index') }}"
                           class="block px-6 py-3 hover:bg-gray-50 transition">
                            Daftar Keinginan
                        </a>

                        <a href="{{ route('customer.returns.index') }}"
                           class="block px-6 py-3 hover:bg-gray-50 transition">
                            Riwayat Retur
                        </a>

                        <a href="{{ route('customer.complaints.index') }}"
                           class="block px-6 py-3 hover:bg-gray-50 transition">
                            Riwayat Keluhan
                        </a>

                    </div>

                    <!-- Logout -->
                    <div class="border-t border-gray-100">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="w-full text-left px-6 py-3 text-sm text-red-500 hover:bg-red-50 transition">
                                Keluar
                            </button>
                        </form>
                    </div>

                </div>
            </div>

            @else

            <a href="/login"
               class="bg-green-600 text-white px-6 py-2.5 rounded-xl font-semibold hover:bg-green-700 transition shadow-sm">
                Masuk
            </a>

            @endauth

        </div>
    </div>
</header>

<!-- ================= CONTENT ================= -->
<main class="min-h-screen">
    @yield('content')
</main>

{{-- SCRIPTS --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cartButtons = document.querySelectorAll('.btn-add-to-cart');
        
        cartButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                const productId = this.dataset.productId;
                const form = this.closest('form');
                const url = form.action;
                const token = form.querySelector('input[name="_token"]').value;

                // Simple loading state
                const originalContent = this.innerHTML;
                this.disabled = true;
                this.innerHTML = `<svg class="animate-spin h-5 w-5 mx-auto text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>`;

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update counter
                        const counter = document.getElementById('cart-counter');
                        if (counter) {
                            counter.innerText = data.cart_count;
                            counter.classList.remove('hidden');
                        }

                        // Success Toast
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            background: '#fff',
                            color: '#1f2937',
                            iconColor: '#ef4444'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    window.location.href = "{{ route('customer.cart.index') }}";
                })
                .finally(() => {
                    this.disabled = false;
                    this.innerHTML = originalContent;
                });
            });
        });

        const wishlistButtons = document.querySelectorAll('.btn-wishlist-toggle');
        wishlistButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.dataset.actionUrl;
                
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (data.status === 'added') {
                            this.classList.remove('text-gray-300', 'border-gray-200', 'bg-white');
                            this.classList.add('text-red-500', 'border-red-500', 'bg-red-50');
                        } else {
                            this.classList.remove('text-red-500', 'border-red-500', 'bg-red-50');
                            this.classList.add('text-gray-300', 'border-gray-200', 'bg-white');
                        }

                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });
                    }
                });
            });
        });
    });
</script>

@include('layouts.footer')

    @stack('scripts')
</body>
</html>