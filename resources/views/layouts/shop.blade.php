<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Almart')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/pusher-js@8.3.0/dist/web/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.min.js"></script>
    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 antialiased">

<!-- ================= NAVBAR ================= -->
<header class="bg-white/95 backdrop-blur sticky top-0 z-50 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between gap-10">

        <!-- LOGO -->
        <div class="flex items-center gap-6">
            <a href="/" class="flex items-center gap-3 group">
                <img src="{{ asset('images/logo.png') }}" class="h-10 w-auto">
                <div class="leading-tight">
                    <p class="font-bold text-lg text-gray-900 group-hover:text-rose-500 transition">
                        Almart
                    </p>
                    <p class="text-xs text-gray-500 font-medium">
                        {{-- Segar Setiap Hari untuk hidup anda --}}
                        Segar Setiap Hari
                    </p>
                </div>
            </a>
            
            {{-- Real-time Clock --}}
            <div class="hidden lg:flex items-center gap-2 px-3 py-1.5 bg-gray-50 rounded-xl border border-gray-100 text-gray-400">
                <div class="w-1.5 h-1.5 rounded-full bg-rose-400 animate-pulse"></div>
                <span id="realtime-clock" class="text-[10px] font-black tracking-widest tabular-nums uppercase">--:--:--</span>
            </div>
        </div>

        <!-- SEARCH -->
        <form action="/" method="GET" class="flex flex-1 max-w-2xl relative">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Cari buah, sayuran, minuman..."
                   class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl bg-gray-100 focus:bg-white focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none text-sm transition">

            <i data-lucide="search" class="w-5 h-5 absolute left-4 top-3.5 text-gray-400"></i>
        </form>

        <!-- RIGHT SIDE -->
        <div class="flex items-center gap-8 text-sm">

            <!-- Wishlist -->
            @auth
            @php
                $wishlistCount = \App\Models\Wishlist::where('user_id', auth()->id())->count();
            @endphp
            @endauth

            <a href="{{ route('customer.wishlist.index') }}" class="relative text-gray-600 hover:text-rose-500 transition duration-200">
                <i data-lucide="heart" class="w-6 h-6"></i>
                @auth
                    <span id="wishlist-counter" class="{{ $wishlistCount > 0 ? '' : 'hidden' }} absolute -top-2 -right-2 bg-rose-500 text-white text-[11px] w-5 h-5 rounded-full flex items-center justify-center shadow-sm">
                        {{ $wishlistCount }}
                    </span>
                @else
                    <span id="wishlist-counter" class="hidden absolute -top-2 -right-2 bg-rose-500 text-white text-[11px] w-5 h-5 rounded-full flex items-center justify-center shadow-sm">
                        0
                    </span>
                @endauth
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
   class="relative text-gray-600 hover:text-rose-600 transition duration-200">

    <i data-lucide="shopping-cart" class="w-6 h-6"></i>

    @auth
        @if($cartCount > 0)
            <span id="cart-counter" class="absolute -top-2 -right-2 bg-rose-500 text-white text-[11px] w-5 h-5 rounded-full flex items-center justify-center shadow-sm">
                {{ $cartCount }}
            </span>
        @else
            <span id="cart-counter" class="hidden absolute -top-2 -right-2 bg-rose-500 text-white text-[11px] w-5 h-5 rounded-full flex items-center justify-center shadow-sm">
                0
            </span>
        @endif
    @else
        <span id="cart-counter" class="hidden absolute -top-2 -right-2 bg-rose-500 text-white text-[11px] w-5 h-5 rounded-full flex items-center justify-center shadow-sm">
            0
        </span>
    @endauth

</a>

            @auth

            <!-- PROFILE -->
            <div class="relative">
                <button id="userProfileBtn" class="flex items-center gap-3 focus:outline-none group">
                    <!-- Avatar -->
                    <div class="w-10 h-10 bg-gradient-to-r from-rose-500 to-rose-600 text-white flex items-center justify-center rounded-full font-semibold shadow-md group-hover:scale-105 transition">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 group-hover:text-rose-600 transition"></i>
                </button>

                <!-- DROPDOWN -->
                <div id="userProfileMenu" 
                     class="absolute right-0 mt-4 w-72 bg-white rounded-2xl shadow-xl border border-gray-100
                            opacity-0 invisible pointer-events-none transition-all duration-200 z-50 transform scale-95 origin-top-right">

                    <!-- User Info -->
                    <div class="px-6 py-5 border-b border-gray-100">
                        <p class="font-bold text-gray-900 leading-none">
                            {{ auth()->user()->name }}
                        </p>
                        <p class="text-[11px] text-gray-400 mt-2 font-medium">
                            {{ auth()->user()->email }}
                        </p>
                        <span class="inline-block mt-3 px-3 py-1 text-[10px] bg-rose-50 text-rose-600 rounded-full font-black uppercase tracking-widest">
                            {{ ucfirst(auth()->user()->role) }}
                        </span>
                    </div>

                    <!-- Menu -->
                    <div class="py-2 text-sm text-gray-700">

                        <a href="{{ route('shop.home') }}"
                           class="flex items-center gap-3 px-6 py-3 hover:bg-gray-50 transition group">
                            <i data-lucide="home" class="w-4 h-4 text-gray-400 group-hover:text-rose-500 transition"></i>
                            <span class="font-bold">Beranda</span>
                        </a>

                        <a href="{{ route('profile.edit') }}"
                           class="flex items-center gap-3 px-6 py-3 hover:bg-gray-50 transition group">
                            <i data-lucide="user" class="w-4 h-4 text-gray-400 group-hover:text-rose-500 transition"></i>
                            <span class="font-bold">Profil Saya</span>
                        </a>

                        <a href="{{ route('customer.orders.index') }}"
                           class="flex items-center gap-3 px-6 py-3 hover:bg-gray-50 transition group">
                            <i data-lucide="shopping-bag" class="w-4 h-4 text-gray-400 group-hover:text-rose-500 transition"></i>
                            <span class="font-bold">Pesanan Saya</span>
                        </a>

                        <a href="{{ route('customer.orders.status') }}"
                           class="flex items-center gap-3 px-6 py-3 hover:bg-gray-50 transition group">
                            <i data-lucide="truck" class="w-4 h-4 text-gray-400 group-hover:text-rose-500 transition"></i>
                            <span class="font-bold">Status Pesanan</span>
                        </a>

                        <a href="{{ route('customer.wishlist.index') }}"
                           class="flex items-center gap-3 px-6 py-3 hover:bg-gray-50 transition group">
                            <i data-lucide="heart" class="w-4 h-4 text-gray-400 group-hover:text-rose-500 transition"></i>
                            <span class="font-bold">Daftar Keinginan</span>
                        </a>

                        <a href="{{ route('customer.returns.index') }}"
                           class="flex items-center gap-3 px-6 py-3 hover:bg-gray-50 transition group">
                            <i data-lucide="refresh-ccw" class="w-4 h-4 text-gray-400 group-hover:text-rose-500 transition"></i>
                            <span class="font-bold">Riwayat Retur</span>
                        </a>

                        <a href="{{ route('customer.complaints.index') }}"
                           class="flex items-center gap-3 px-6 py-3 hover:bg-gray-50 transition group">
                            <i data-lucide="message-square" class="w-4 h-4 text-gray-400 group-hover:text-rose-500 transition"></i>
                            <span class="font-bold">Riwayat Keluhan</span>
                        </a>

                    </div>

                    <!-- Logout -->
                    <div class="border-t border-gray-100">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="w-full text-left px-6 py-4 text-sm text-rose-500 hover:bg-rose-50 transition font-bold flex items-center gap-3">
                                <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
                            </button>
                        </form>
                    </div>

                </div>
            </div>

            @else

            <a href="/login"
               class="bg-rose-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-rose-700 hover:shadow-lg hover:shadow-rose-100 transition shadow-sm">
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
        // Initialize Icons
        if(typeof lucide !== 'undefined') lucide.createIcons();

        const cartButtons = document.querySelectorAll('.btn-add-to-cart');
        
        cartButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                const productId = this.dataset.productId;
                const form = this.closest('form');
                if(!form) return;
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
                        const counter = document.getElementById('cart-counter');
                        if (counter) {
                            counter.innerText = data.cart_count;
                            counter.classList.remove('hidden');
                        }

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
                            iconColor: '#f43f5e'
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
                        // Update UI Toggle
                        if (data.status === 'added') {
                            this.classList.remove('text-gray-300', 'border-gray-200', 'bg-white');
                            this.classList.add('text-rose-500', 'border-rose-500', 'bg-rose-50');
                        } else {
                            this.classList.remove('text-rose-500', 'border-rose-500', 'bg-rose-50');
                            this.classList.add('text-gray-300', 'border-gray-200', 'bg-white');
                        }

                        // Update Counter
                        const counter = document.getElementById('wishlist-counter');
                        if (counter) {
                            counter.innerText = data.wishlist_count;
                            if (data.wishlist_count > 0) {
                                counter.classList.remove('hidden');
                            } else {
                                counter.classList.add('hidden');
                            }
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

        // PROFILE DROPDOWN TOGGLE (Click-based)
        const userProfileBtn = document.getElementById('userProfileBtn');
        const userProfileMenu = document.getElementById('userProfileMenu');

        if (userProfileBtn && userProfileMenu) {
            userProfileBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                
                const isOpen = !userProfileMenu.classList.contains('invisible');
                
                if (isOpen) {
                    userProfileMenu.classList.add('opacity-0', 'invisible', 'pointer-events-none', 'scale-95');
                } else {
                    userProfileMenu.classList.remove('opacity-0', 'invisible', 'pointer-events-none', 'scale-95');
                }
            });

            userProfileMenu.addEventListener('click', (e) => e.stopPropagation());

            document.addEventListener('click', () => {
                userProfileMenu.classList.add('opacity-0', 'invisible', 'pointer-events-none', 'scale-95');
            });
        }

        // --- GLOBAL NEWSLETTER HANDLER ---
        const initNewsletter = (btnId, formId, inputId) => {
            const btn = document.getElementById(btnId);
            const form = document.getElementById(formId);
            const input = document.getElementById(inputId);

            if (btn && form && input) {
                btn.addEventListener('click', function() {
                    const email = input.value;
                    const url = form.dataset.url;
                    const token = form.dataset.token;

                    if (!email || !email.includes('@')) {
                        Swal.fire({ icon: 'error', title: 'Email Tidak Valid', text: 'Silakan masukkan alamat email yang benar!' });
                        return;
                    }

                    const originalContent = btn.innerHTML;
                    btn.disabled = true;
                    btn.innerHTML = '<span class="animate-spin text-[10px]">⌛</span>';

                    fetch(url, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
                        body: JSON.stringify({ email: email })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Terima Kasih!',
                                text: data.message,
                                confirmButtonColor: '#f43f5e'
                            });
                            input.value = '';
                        } else {
                            Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan. Coba lagi nanti.' });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal menghubungi server.' });
                    })
                    .finally(() => {
                        btn.disabled = false;
                        btn.innerHTML = originalContent;
                    });
                });
            }
        };

        // Initialize banner form only (Footer footer-subscribe-btn removed in footer.blade.php)
        initNewsletter('subscribe-btn', 'newsletter-form', 'newsletter-email');

        // --- REAL-TIME CUSTOMER NOTIFICATIONS ---
        if (typeof Echo !== 'undefined' && @auth true @else false @endauth) {
            window.Echo = new Echo({
                broadcaster: 'reverb',
                key: "{{ env('VITE_REVERB_APP_KEY') }}",
                wsHost: "{{ env('VITE_REVERB_HOST') }}",
                wsPort: "{{ env('VITE_REVERB_PORT') }}",
                wssPort: "{{ env('VITE_REVERB_PORT') }}",
                forceTLS: "{{ env('VITE_REVERB_SCHEME') }}" === 'https',
                enabledTransports: ['ws', 'wss'],
            });

            window.Echo.channel('order-status.{{ auth()->id() }}')
                .listen('.order-status-updated', (e) => {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: e.order.status === 'cancelled' ? 'error' : 'success',
                        title: e.message || `Pesanan ${e.order.order_code} diperbarui.`,
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true
                    });
                    
                    // Refresh if on status page
                    if (window.location.pathname.includes('status')) {
                         setTimeout(() => window.location.reload(), 1500);
                    }
                });
        }

        // --- REAL-TIME CLOCK SCRIPT ---
        (function() {
            // Init with server time (UTC+7)
            let serverTime = new Date("{{ now()->toIso8601String() }}");
            
            function updateClock() {
                serverTime.setSeconds(serverTime.getSeconds() + 1);
                const clockEl = document.getElementById('realtime-clock');
                if (clockEl) {
                    const hours = String(serverTime.getHours()).padStart(2, '0');
                    const minutes = String(serverTime.getMinutes()).padStart(2, '0');
                    const seconds = String(serverTime.getSeconds()).padStart(2, '0');
                    clockEl.innerText = `${hours}:${minutes}:${seconds}`;
                }
            }
            
            setInterval(updateClock, 1000);
            updateClock(); // Initial run
        })();
    });
</script>

@include('layouts.footer')

    @stack('scripts')
</body>
</html>