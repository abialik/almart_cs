@extends('layouts.admin')

@section('title', 'Detail Pengguna')

@section('content')
<div class="space-y-8 pb-10">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.users.index', ['tab' => $user->role]) }}" class="w-10 h-10 bg-white border border-gray-100 rounded-xl flex items-center justify-center text-gray-500 hover:text-blue-600 hover:bg-blue-50 transition shadow-sm">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 font-plus-jakarta">Detail {{ ucfirst($user->role) }}</h1>
            <p class="text-sm text-gray-500 mt-1">Informasi lengkap pengguna sistem.</p>
        </div>
    </div>

    <div class="bg-white p-8 rounded-3xl border border-gray-50 shadow-[0_8px_30px_rgb(0,0,0,0.04)] max-w-4xl flex flex-col md:flex-row gap-8">
        
        <!-- Sidebar Profile -->
        <div class="w-full md:w-1/3 flex flex-col items-center text-center">
            <div class="w-32 h-32 rounded-3xl bg-blue-500 text-white flex items-center justify-center font-black text-5xl shadow-xl shadow-blue-200 mb-6">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <h2 class="text-xl font-black text-gray-900">{{ $user->name }}</h2>
            <div class="inline-flex px-3 py-1 mt-2 bg-gray-100 text-gray-600 text-xs font-bold rounded-lg uppercase tracking-widest">
                {{ $user->role === 'customer' ? 'M' : 'P' }}{{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}
            </div>
            
            <div class="mt-6 w-full space-y-3">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="w-full py-3 bg-blue-50 text-blue-600 font-bold rounded-xl text-sm hover:bg-blue-100 transition flex justify-center items-center gap-2">
                    <i data-lucide="edit-3" class="w-4 h-4"></i> Edit Profil
                </a>
            </div>
        </div>

        <!-- Main Info -->
        <div class="w-full md:w-2/3 space-y-8">
            
            <div>
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Informasi Kontak</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                        <p class="text-xs font-bold text-gray-500 mb-1">Email Saat Ini</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $user->email }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                        <p class="text-xs font-bold text-gray-500 mb-1">Nomor Telepon</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $user->phone ?? 'Belum diatur' }}</p>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Pengaturan Akun</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                        <p class="text-xs font-bold text-gray-500 mb-1">Status Keaktifan</p>
                        @if($user->is_active)
                            <span class="inline-flex px-2.5 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-md">Aktif</span>
                        @else
                            <span class="inline-flex px-2.5 py-1 bg-rose-100 text-rose-700 text-xs font-bold rounded-md">Nonaktif</span>
                        @endif
                    </div>
                    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                        <p class="text-xs font-bold text-gray-500 mb-1">Bergabung Pada</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $user->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            @if($user->role === 'customer')
            <div>
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Statistik Transaksi</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-blue-50/50 p-5 rounded-2xl border border-blue-50 flex items-center gap-4">
                        <div class="w-10 h-10 bg-blue-500 text-white rounded-xl flex items-center justify-center shadow-md shadow-blue-200">
                            <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-blue-500 mb-0.5 uppercase tracking-widest">Total Pesanan</p>
                            <p class="text-xl font-black text-blue-900 leading-none">{{ $user->orders_count ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="bg-emerald-50/50 p-5 rounded-2xl border border-emerald-50 flex items-center gap-4">
                        <div class="w-10 h-10 bg-emerald-500 text-white rounded-xl flex items-center justify-center shadow-md shadow-emerald-200">
                            <i data-lucide="wallet" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-emerald-500 mb-0.5 uppercase tracking-widest">Total Belanja</p>
                            <p class="text-xl font-black text-emerald-900 leading-none">Rp {{ number_format($user->orders_sum_total ?? 0, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection
