@extends('layouts.shop')

@section('title', 'Pesanan Saya — Almart')

@section('content')

{{-- ===== PAGE HEADER ===== --}}
<div class="bg-gradient-to-r from-green-500 to-emerald-600 py-8 mb-10 shadow-sm">
    <div class="max-w-6xl mx-auto px-6 text-white text-center sm:text-left">
        <h2 class="text-3xl font-extrabold mb-2">Riwayat Pesanan</h2>
        <p class="text-green-100 opacity-90">Pantau status pesanan dan rincian belanja Anda di sini.</p>
    </div>
</div>

<div class="max-w-6xl mx-auto px-6 pb-20">
    <div class="bg-white rounded-3xl shadow-xl shadow-gray-100/50 border border-gray-100 overflow-hidden">
        
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">Pesanan</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">Tanggal</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">Total</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50/50 transition duration-150">
                            <td class="px-8 py-6">
                                <span class="font-bold text-gray-900 tracking-wide">{{ $order->order_code }}</span>
                            </td>
                            <td class="px-8 py-6 text-sm text-gray-500">
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="px-8 py-6">
                                <span class="font-bold text-gray-900">Rp {{ number_format($order->total) }}</span>
                            </td>
                            <td class="px-8 py-6">
                                @php
                                    $statusClasses = [
                                        'pending'    => 'bg-amber-100 text-amber-700',
                                        'paid'       => 'bg-emerald-100 text-emerald-700',
                                        'processing' => 'bg-blue-100 text-blue-700',
                                        'delivered'  => 'bg-purple-100 text-purple-700',
                                        'cancelled'  => 'bg-rose-100 text-rose-700',
                                    ];
                                    $class = $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wide {{ $class }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="{{ route('customer.orders.show', $order->id) }}" 
                                       class="px-5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition duration-200">
                                        Detail
                                    </a>
                                    
                                    @if($order->status === 'pending' && (!$order->payment || $order->payment->status === 'unpaid'))
                                        <a href="{{ route('customer.checkout.payment', $order->id) }}" 
                                           class="px-5 py-2 bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold rounded-xl shadow-md shadow-pink-100 transition duration-200">
                                            Bayar Sekarang
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center gap-4">
                                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center">
                                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                        </svg>
                                    </div>
                                    <p class="text-gray-400 font-medium">Belum ada riwayat pesanan.</p>
                                    <a href="{{ route('shop.home') }}" class="text-green-600 font-bold hover:underline">Mulai Berbelanja</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->isNotEmpty())
            <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-100">
                {{ $orders->links() }}
            </div>
        @endif

    </div>
</div>

@endsection
