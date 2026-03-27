<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Almart')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">

<div class="min-h-screen">

    @auth
    <nav class="bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">

        <div class="font-bold text-lg">
            Almart
        </div>

        <div class="flex items-center gap-6 text-sm">

            {{-- ADMIN --}}
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">
                    Dashboard
                </a>

            {{-- PETUGAS --}}
            @elseif(auth()->user()->role === 'petugas')
                <a href="{{ route('petugas.dashboard') }}" class="hover:text-pink-600">
                    Dashboard
                </a>

            {{-- CUSTOMER --}}
            @elseif(auth()->user()->role === 'customer')
                <a href="{{ route('shop.home') }}" class="hover:text-green-600">
                    Dashboard
                </a>
            @endif

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-red-500 hover:underline">
                    Logout
                </button>
            </form>

        </div>
    </nav>
    @endauth

    <main class="p-6">
        @yield('content')
        {{ $slot ?? '' }}
    </main>
    @include('layouts.footer')

</div>

</body>
</html>