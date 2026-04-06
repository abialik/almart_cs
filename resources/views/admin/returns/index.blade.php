@extends('layouts.admin')

@section('title', 'Manajemen Pengembalian Barang')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight">PENGEMBALIAN BARANG</h1>
            <p class="text-gray-500 font-medium">Kelola dan tinjau pengajuan retur dari pelanggan</p>
        </div>
        
        <div class="flex items-center gap-2 bg-white p-1 rounded-2xl shadow-sm border border-gray-100">
            <a href="{{ route('admin.returns.index', ['status' => 'all']) }}" 
               class="px-4 py-2 rounded-xl text-sm font-bold transition {{ !request('status') || request('status') == 'all' ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-gray-500 hover:bg-gray-50' }}">
                Semua
            </a>
            <a href="{{ route('admin.returns.index', ['status' => 'pending']) }}" 
               class="px-4 py-2 rounded-xl text-sm font-bold transition {{ request('status') == 'pending' ? 'bg-amber-500 text-white shadow-lg shadow-amber-200' : 'text-gray-500 hover:bg-gray-50' }}">
                Pending
            </a>
            <a href="{{ route('admin.returns.index', ['status' => 'approved']) }}" 
               class="px-4 py-2 rounded-xl text-sm font-bold transition {{ request('status') == 'approved' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-200' : 'text-gray-500 hover:bg-gray-50' }}">
                Disetujui
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-8 py-6 text-[11px] font-black text-gray-400 uppercase tracking-[0.2em]">Info Pengembalian</th>
                        <th class="px-8 py-6 text-[11px] font-black text-gray-400 uppercase tracking-[0.2em]">Pelanggan</th>
                        <th class="px-8 py-6 text-[11px] font-black text-gray-400 uppercase tracking-[0.2em]">Alasan</th>
                        <th class="px-8 py-6 text-[11px] font-black text-gray-400 uppercase tracking-[0.2em]">Status</th>
                        <th class="px-8 py-6 text-[11px] font-black text-gray-400 uppercase tracking-[0.2em]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($returns as $return)
                    <tr class="group hover:bg-blue-50/30 transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-sm font-black text-gray-900 group-hover:text-blue-600 transition-colors">#{{ $return->order->order_code }}</span>
                                <span class="text-[10px] font-bold text-gray-400 uppercase mt-0.5">{{ $return->created_at->translatedFormat('d M Y, H:i') }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center text-gray-500 font-bold text-xs ring-2 ring-white">
                                    {{ substr($return->customer->name, 0, 1) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-gray-700">{{ $return->customer->name }}</span>
                                    <span class="text-xs text-gray-400">{{ $return->customer->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <p class="text-sm text-gray-600 line-clamp-1 max-w-[200px] italic">"{{ $return->reason }}"</p>
                        </td>
                        <td class="px-8 py-6">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-amber-100 text-amber-600 ring-amber-50',
                                    'approved' => 'bg-emerald-100 text-emerald-600 ring-emerald-50',
                                    'rejected' => 'bg-rose-100 text-rose-600 ring-rose-50',
                                ];
                                $statusLabels = [
                                    'pending' => 'Menunggu',
                                    'approved' => 'Disetujui',
                                    'rejected' => 'Ditolak',
                                ];
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider ring-4 {{ $statusClasses[$return->status] ?? 'bg-gray-100 text-gray-600 ring-gray-50' }}">
                                {{ $statusLabels[$return->status] ?? $return->status }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <a href="{{ route('admin.returns.show', $return) }}" 
                               class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-900 text-white text-[10px] font-black rounded-xl hover:bg-blue-600 hover:shadow-lg hover:shadow-blue-200 transition-all active:scale-95 uppercase tracking-widest">
                                Periksa
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-20 h-20 bg-gray-50 rounded-[2rem] flex items-center justify-center text-gray-200">
                                    <i data-lucide="refresh-ccw" class="w-10 h-10"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Belum Ada Pengajuan</h3>
                                    <p class="text-sm text-gray-400">Semua pengajuan pengembalian akan muncul di sini</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($returns->hasPages())
        <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-100 font-bold">
            {{ $returns->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
