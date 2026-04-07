@extends('layouts.shop')

@section('title', 'Daftar Keluhan — Almart')

@section('content')

{{-- ===== PAGE HEADER ===== --}}
<div class="bg-gradient-to-r from-red-500 to-rose-600 py-10 mb-10 shadow-sm">
    <div class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-6 text-white text-center sm:text-left">
        <div>
            <h2 class="text-3xl font-extrabold mb-2 text-white">Riwayat Keluhan</h2>
            <p class="text-red-100 opacity-90">Pantau status tanggapan keluhan Anda di sini.</p>
        </div>
        <form action="{{ url()->current() }}" method="GET" class="w-full md:w-auto">
            <select name="status" onchange="this.form.submit()" class="w-full md:w-48 bg-white/20 backdrop-blur-md border border-white/30 text-white font-bold rounded-2xl px-5 py-3 outline-none focus:bg-white focus:text-gray-900 transition-all cursor-pointer">
                <option value="" class="text-gray-900">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }} class="text-gray-900">Menunggu</option>
                <option value="responded" {{ request('status') == 'responded' ? 'selected' : '' }} class="text-gray-900">Ditanggapi</option>
                <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }} class="text-gray-900">Selesai</option>
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
                        <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-gray-500">ID Tiket / Pesanan</th>
                        <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-gray-500">Keluhan</th>
                        <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-gray-500">Status & Tanggapan</th>
                        <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-gray-500">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($complaints as $complaint)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-8 py-6">
                                <span class="font-bold text-gray-900 block mb-1">
                                    #{{ $complaint->id }}
                                </span>
                                @if($complaint->order_number)
                                <span class="text-xs font-bold text-gray-500 bg-gray-100 px-2 py-0.5 rounded">
                                    ORD: {{ $complaint->order_number }}
                                </span>
                                @endif
                            </td>
                            <td class="px-8 py-6">
                                <p class="text-xs font-black uppercase tracking-widest text-gray-400 mb-1">{{ $complaint->complaint_type }}</p>
                                <p class="text-sm text-gray-600 line-clamp-2 max-w-xs">{{ $complaint->description }}</p>
                            </td>
                            <td class="px-8 py-6">
                                @php
                                    $statusClasses = [
                                        'pending'  => 'bg-amber-100 text-amber-700',
                                        'responded' => 'bg-blue-100 text-blue-700',
                                        'resolved' => 'bg-green-100 text-green-700',
                                    ];
                                    $statusLabels = [
                                        'pending' => 'Menunggu',
                                        'responded' => 'Ditanggapi',
                                        'resolved' => 'Selesai'
                                    ]
                                @endphp
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $statusClasses[$complaint->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ $statusLabels[$complaint->status] ?? $complaint->status }}
                                </span>

                                @if($complaint->admin_response)
                                    <div class="mt-3 p-3 bg-blue-50 border border-blue-100 rounded-xl text-xs text-gray-700 max-w-xs">
                                        <span class="font-bold text-blue-800 block mb-1">Tanggapan Admin:</span>
                                        <p class="italic">{{ $complaint->admin_response }}</p>
                                    </div>
                                @endif
                            </td>
                            <td class="px-8 py-6 text-sm text-gray-500">
                                {{ $complaint->created_at->format('d M Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center">
                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                                </div>
                                <h3 class="text-gray-800 font-bold mb-1">Tidak Ada Keluhan</h3>
                                <p class="text-gray-500 text-sm">Anda belum pernah mengajukan keluhan apa pun.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    {{-- Pagination --}}
    @if($complaints->hasPages())
    <div class="mt-8 flex justify-center">
        {{ $complaints->links() }}
    </div>
    @endif
</div>

@endsection
