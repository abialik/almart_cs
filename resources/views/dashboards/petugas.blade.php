@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('content')

@auth
<div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-gray-100 py-10">

    <div class="max-w-7xl mx-auto space-y-10 px-6">

        <!-- ================= HEADER ================= -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 flex justify-between items-center">

            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Dashboard <span class="text-pink-500">Petugas</span>
                </h1>
                <p class="text-sm text-gray-400 mt-1">
                    Kelola dan pantau pesanan pelanggan secara real-time
                </p>
                <div class="mt-4">
                    <a href="{{ route('petugas.orders.index') }}" class="inline-flex items-center gap-2 px-6 py-2 bg-pink-500 text-white text-sm font-bold rounded-xl shadow-md shadow-pink-100 hover:bg-pink-600 transition">
                         Kelola Semua Pesanan
                    </a>
                </div>
            </div>

            <div class="flex items-center gap-4">

                <div class="text-right">
                    <p class="text-sm font-semibold text-gray-800">
                        {{ auth()->user()->name ?? 'Petugas' }}
                    </p>
                    <p class="text-xs text-gray-400">
                        Staff Operasional
                    </p>
                </div>

                <div class="w-11 h-11 bg-gradient-to-r from-pink-500 to-rose-500 text-white 
                            rounded-full flex items-center justify-center font-bold shadow-md text-lg">
                    {{ strtoupper(substr(auth()->user()->name ?? 'P',0,1)) }}
                </div>

            </div>

        </div>

        <!-- ================= STATS ================= -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
                <p class="text-sm text-gray-500">Pesanan Baru</p>
                <h2 class="text-3xl font-bold text-blue-600 mt-2">3</h2>
                <p class="text-xs text-gray-400 mt-2">Perlu segera diproses</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
                <p class="text-sm text-gray-500">Sedang Diproses</p>
                <h2 class="text-3xl font-bold text-yellow-500 mt-2">1</h2>
                <p class="text-xs text-gray-400 mt-2">Dalam tahap picking</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
                <p class="text-sm text-gray-500">Selesai Hari Ini</p>
                <h2 class="text-3xl font-bold text-green-600 mt-2">0</h2>
                <p class="text-xs text-gray-400 mt-2">Pesanan berhasil dikirim</p>
            </div>

        </div>

        <!-- ================= FILTER BAR ================= -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex gap-3 flex-wrap">

            <button class="px-5 py-2 rounded-xl bg-pink-500 text-white text-sm font-semibold shadow">
                Semua (4)
            </button>

            <button class="px-5 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-sm transition">
                Baru (3)
            </button>

            <button class="px-5 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-sm transition">
                Diproses (1)
            </button>

            <button class="px-5 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-sm transition">
                Selesai
            </button>

        </div>

        <!-- ================= ORDER CARD ================= -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition">

            <div class="flex justify-between items-start flex-wrap gap-6">

                <div class="space-y-3">

                    <div class="flex items-center gap-3 flex-wrap">

                        <p class="font-semibold text-gray-800">
                            ORD-2024-411
                        </p>

                        <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-600 font-medium">
                            Baru
                        </span>

                        <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600 font-medium">
                            Pickup
                        </span>

                    </div>

                    <p class="text-sm text-gray-600">
                        Pelanggan: <span class="font-medium text-gray-800">Ahmad Wibowo</span>
                    </p>

                    <p class="text-xs text-gray-400">
                        1 item • Rp 22.000 • Baru saja
                    </p>

                </div>

                <div class="flex gap-2 flex-wrap">

                    <button class="px-4 py-2 text-sm bg-gray-50 border border-gray-200 
                                   hover:bg-gray-100 rounded-xl transition">
                        Detail
                    </button>

                    <button class="px-4 py-2 text-sm bg-gray-50 border border-gray-200 
                                   hover:bg-gray-100 rounded-xl transition">
                        Print
                    </button>

                    <button class="px-4 py-2 text-sm bg-red-50 text-red-600 
                                   hover:bg-red-100 rounded-xl transition">
                        Tolak
                    </button>

                    <button class="px-5 py-2 text-sm bg-pink-500 text-white 
                                   hover:bg-pink-600 rounded-xl shadow-sm transition">
                        Terima
                    </button>

                </div>

            </div>

        </div>

    </div>

</div>
@endauth

@endsection