<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Almart')</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Scripts & Styles --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Global Assets --}}
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/pusher-js@8.3.0/dist/web/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-800">

<div class="min-h-screen flex flex-col">

    @auth
    @if(auth()->user()->role !== 'petugas')
    <nav class="bg-white border-b border-gray-100 px-8 py-5 flex justify-between items-center sticky top-0 z-50 backdrop-blur-md bg-white/90">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" class="h-9 w-auto" alt="Almart">
            <span class="font-black text-xl tracking-tight">Almart</span>
        </div>

        <div class="flex items-center gap-8 text-sm">
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="font-bold text-gray-500 hover:text-rose-500 transition">Dashboard Admin</a>
            @elseif(auth()->user()->role === 'customer')
                <a href="{{ route('shop.home') }}" class="font-bold text-gray-500 hover:text-emerald-500 transition">Beranda</a>
            @endif

            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button class="font-bold text-rose-500 hover:text-rose-700 flex items-center gap-2">
                    <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
                </button>
            </form>
        </div>
    </nav>
    @endif
    @endauth

    <main class="flex-1 {{ auth()->check() && auth()->user()->role === 'petugas' ? '' : 'p-8' }}">
        @yield('content')
        {{ $slot ?? '' }}
    </main>

    @include('layouts.footer')
</div>

<script>
    lucide.createIcons();
    
    // Global SweetAlert Toast Configuration
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    @if(session('success'))
        Toast.fire({ icon: 'success', title: "{{ session('success') }}" });
    @endif
    @if(session('error'))
        Toast.fire({ icon: 'error', title: "{{ session('error') }}" });
    @endif
</script>

</body>
</html>