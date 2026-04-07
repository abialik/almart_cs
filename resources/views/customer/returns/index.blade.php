@extends('layouts.shop')

@section('title', 'Daftar Pengajuan — Almart')

@section('content')

{{-- ===== PAGE HEADER ===== --}}
<div class="bg-gradient-to-r from-orange-500 to-amber-600 py-10 mb-10 shadow-sm">
    <div class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-6 text-white text-center sm:text-left">
        <div>
            <h2 class="text-3xl font-extrabold mb-2 text-white">Riwayat Pengajuan</h2>
            <p class="text-orange-100 opacity-90">Pantau status pengembalian barang Anda di sini.</p>
        </div>
        <form action="{{ url()->current() }}" method="GET" class="w-full md:w-auto">
            <select name="status" onchange="this.form.submit()" class="w-full md:w-48 bg-white/20 backdrop-blur-md border border-white/30 text-white font-bold rounded-2xl px-5 py-3 outline-none focus:bg-white focus:text-gray-900 transition-all cursor-pointer">
                <option value="" class="text-gray-900">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }} class="text-gray-900">Menunggu</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }} class="text-gray-900">Disetujui</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }} class="text-gray-900">Ditolak</option>
            </select>
        </form>
    </div>
</div>

<div class="max-w-6xl mx-auto px-6 pb-24">
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-gray-500">ID Pesanan</th>
                        <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-gray-500">Alasan</th>
                        <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-gray-500">Bukti</th>
                        <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-gray-500">Status</th>
                        <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-gray-500">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($returns as $return)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-8 py-6">
                                <a href="{{ route('customer.orders.show', $return->order_id) }}" class="font-bold text-gray-900 hover:text-orange-600 transition">
                                    #{{ $return->order->order_code }}
                                </a>
                            </td>
                            <td class="px-8 py-6">
                                <p class="text-sm text-gray-600 line-clamp-1 max-w-xs">{{ $return->reason }}</p>
                            </td>
                            <td class="px-8 py-6">
                                @if($return->image_proof)
                                    <div class="w-12 h-12 rounded-xl overflow-hidden border border-gray-100 shadow-sm cursor-zoom-in group/img relative" onclick="window.open('{{ asset('storage/' . $return->image_proof) }}', '_blank')">
                                        <img src="{{ asset('storage/' . $return->image_proof) }}" class="w-full h-full object-cover transition duration-300 group-hover/img:scale-110" alt="Bukti">
                                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover/img:opacity-100 transition flex items-center justify-center">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </div>
                                    </div>
                                @else
                                    <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center border border-gray-100 text-gray-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                            </td>
                            <td class="px-8 py-6">
                                @php
                                    $statusClasses = [
                                        'pending'  => 'bg-amber-100 text-amber-700',
                                        'approved' => 'bg-green-100 text-green-700',
                                        'rejected' => 'bg-red-100 text-red-700',
                                    ];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $statusClasses[$return->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ $return->status === 'pending' ? 'Menunggu' : ($return->status === 'approved' ? 'Disetujui' : 'Ditolak') }}
                                </span>

                                @if($return->admin_note)
                                    <p class="text-[10px] text-gray-400 mt-2 italic max-w-[200px]">Catatan: {{ $return->admin_note }}</p>
                                @endif
                            </td>
                            <td class="px-8 py-6 text-sm text-gray-500">
                                {{ $return->created_at->format('d M Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center">
                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <h3 class="text-gray-800 font-bold mb-1">Tidak Ada Pengajuan</h3>
                                <p class="text-gray-500 text-sm">Anda belum pernah melakukan pengajuan pengembalian barang.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    @if($returns->hasPages())
    <div class="mt-8 flex justify-center">
        {{ $returns->links() }}
    </div>
    @endif
</div>

@endsection
