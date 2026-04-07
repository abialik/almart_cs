@extends('layouts.admin')

@section('title', 'Newsletter Subscriptions')

@section('content')
<div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <nav class="flex text-gray-400 text-xs font-bold uppercase tracking-widest mb-2" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-3 h-3 mx-1"></i>
                        <span class="text-gray-500">Newsletter</span>
                    </div>
                </li>
            </ol>
        </nav>
        <h1 class="text-4xl font-black text-gray-900 tracking-tight">Daftar Berlangganan Newsletter</h1>
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mt-2">
            <p class="text-sm text-gray-500 font-medium">Kumpulan kontak email pelanggan yang tertarik dengan promo Toko Almart Anda.</p>
            <form action="{{ url()->current() }}" method="GET" class="relative group">
                <i data-lucide="search" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-blue-500 transition-colors"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari email..." class="bg-gray-100/50 border border-gray-100 rounded-2xl pl-11 pr-4 py-2.5 text-xs font-bold text-gray-700 outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all w-full md:w-64 shadow-sm shadow-blue-50/50">
            </form>
        </div>
    </div>
</div>

<div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-gray-100 overflow-hidden animate-fade-in">
    <div class="overflow-x-auto p-4">
        <table class="w-full text-left border-separate border-spacing-y-3">
            <thead>
                <tr class="text-gray-400 text-[10px] uppercase font-black tracking-[0.2em]">
                    <th class="px-6 py-4">No</th>
                    <th class="px-6 py-4">Alamat Email</th>
                    <th class="px-6 py-4">Tanggal Daftar</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subscriptions as $index => $sub)
                    <tr class="group hover:translate-x-1 transition-all duration-300">
                        <td class="bg-gray-50/50 group-hover:bg-blue-50 px-6 py-5 rounded-l-2xl text-xs font-bold text-gray-400 transition-colors">
                            {{ $subscriptions->firstItem() + $index }}
                        </td>
                        <td class="bg-gray-50/50 group-hover:bg-blue-50 px-6 py-5 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-white border border-gray-100 flex items-center justify-center text-blue-500 shadow-sm">
                                    <i data-lucide="mail" class="w-4 h-4"></i>
                                </div>
                                <span class="text-sm font-bold text-gray-900 tracking-tight">{{ $sub->email }}</span>
                            </div>
                        </td>
                        <td class="bg-gray-50/50 group-hover:bg-blue-50 px-6 py-5 transition-colors">
                            <span class="text-xs font-bold text-gray-500">{{ $sub->created_at->translatedFormat('d M Y, H:i') }}</span>
                        </td>
                        <td class="bg-gray-50/50 group-hover:bg-blue-50 px-6 py-5 rounded-r-2xl text-right transition-colors whitespace-nowrap">
                            <form action="{{ route('admin.newsletters.destroy', $sub->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus email ini dari daftar?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-10 h-10 rounded-xl bg-white border border-gray-100 text-rose-500 flex items-center justify-center hover:bg-rose-500 hover:text-white hover:border-rose-500 transition-all duration-300 shadow-sm active:scale-90">
                                    <i data-lucide="trash-2" class="w-4 h-4 text-current"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-20 text-center">
                            <div class="w-20 h-20 bg-gray-50 rounded-3xl flex items-center justify-center mx-auto mb-4 border border-gray-100 text-gray-300">
                                <i data-lucide="mail-warning" class="w-10 h-10"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Belum ada pelanggan</h3>
                            <p class="text-sm text-gray-400 font-medium">Email yang mendaftar lewat banner promosi akan muncul di sini.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-100">
        {{ $subscriptions->links() }}
    </div>
</div>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out forwards;
    }
</style>
@endsection
