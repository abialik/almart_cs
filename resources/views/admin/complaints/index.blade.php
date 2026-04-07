@extends('layouts.admin')

@section('title', 'Keluhan Pelanggan')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6 bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
    <div class="shrink-0">
        <h2 class="text-2xl font-black text-gray-900 tracking-tight leading-tight">Keluhan Pelanggan</h2>
        <p class="text-sm text-gray-500 mt-1">Kelola dan tanggapi keluhan dari pelanggan Anda.</p>
    </div>

    <!-- Filter Form -->
    <form action="{{ url()->current() }}" method="GET" class="flex flex-col md:flex-row flex-1 items-center gap-4 w-full justify-end">
        <div class="relative w-full md:max-w-xs">
            <i data-lucide="search" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau deskripsi..." class="w-full pl-11 pr-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-2xl text-xs font-semibold text-gray-700 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all outline-none">
        </div>

        <div class="relative w-full md:w-40">
            <select name="status" onchange="this.form.submit()" class="w-full pl-4 pr-10 py-2.5 bg-gray-50/50 border border-gray-200 rounded-2xl text-xs font-bold text-gray-700 focus:bg-white focus:border-blue-500 transition-all outline-none appearance-none cursor-pointer">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                <option value="responded" {{ request('status') == 'responded' ? 'selected' : '' }}>Ditanggapi</option>
                <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Selesai</option>
            </select>
            <i data-lucide="chevron-down" class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
        </div>
    </form>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-gray-50/50 text-gray-500 font-semibold border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4">Tanggal Pengajuan</th>
                    <th class="px-6 py-4">Nama Pelanggan</th>
                    <th class="px-6 py-4">No. Pesanan</th>
                    <th class="px-6 py-4">Jenis Keluhan</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100/70 text-gray-700">
                @forelse($complaints as $complaint)
                <tr class="hover:bg-blue-50/50 transition-colors group">
                    <td class="px-6 py-4">
                        <span class="text-xs font-semibold text-gray-500">{{ $complaint->created_at->format('d M Y, H:i') }}</span>
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-900">
                        {{ $complaint->name }}
                        <div class="text-xs font-normal text-gray-400">{{ $complaint->email }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @if($complaint->order_number)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-gray-100 text-xs font-bold text-gray-700">
                                {{ $complaint->order_number }}
                            </span>
                        @else
                            <span class="text-gray-400 italic text-xs">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm">{{ $complaint->complaint_type }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @if($complaint->status == 'pending')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-orange-100 text-orange-700 text-xs font-bold">
                                <i data-lucide="clock" class="w-3.5 h-3.5"></i> Menunggu
                            </span>
                        @elseif($complaint->status == 'responded')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-blue-100 text-blue-700 text-xs font-bold">
                                <i data-lucide="reply" class="w-3.5 h-3.5"></i> Ditanggapi
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-green-100 text-green-700 text-xs font-bold">
                                <i data-lucide="check-circle" class="w-3.5 h-3.5"></i> Selesai
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.complaints.show', $complaint) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-gray-100 text-gray-500 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center">
                            <i data-lucide="inbox" class="w-12 h-12 text-gray-300 mb-3"></i>
                            <p class="font-medium">Belum ada keluhan pelanggan saat ini.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($complaints->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $complaints->links() }}
    </div>
    @endif
</div>
@endsection
