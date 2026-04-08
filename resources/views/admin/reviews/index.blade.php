@extends('layouts.admin')

@section('title', 'Manajemen Ulasan Pelanggan — Almart Admin')

@section('header', 'Ulasan Pelanggan')

@section('content')
<div class="px-6 py-8">
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        
        <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold text-gray-900 tracking-tight">Kritik & Saran Pelanggan</h3>
                <p class="text-xs text-gray-400 mt-1 uppercase font-bold tracking-widest">Total {{ $reviews->total() }} Ulasan Masuk</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Pelanggan & Produk</th>
                        <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Rating</th>
                        <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Komentar & Foto</th>
                        <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Tanggal</th>
                        <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($reviews as $review)
                        <tr class="hover:bg-gray-50/30 transition duration-200">
                            {{-- Info --}}
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-indigo-50 rounded-full flex items-center justify-center text-indigo-600 font-bold shrink-0">
                                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900 leading-none mb-1.5">{{ $review->user->name }}</p>
                                        <p class="text-xs text-gray-400 font-medium">Beli: <span class="text-rose-500 font-bold">{{ $review->product->name }}</span></p>
                                        <p class="text-[10px] text-gray-400 mt-1">Order ID: {{ $review->order->order_code }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Rating --}}
                            <td class="px-8 py-6 text-center">
                                <div class="flex items-center justify-center gap-0.5 text-amber-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i data-lucide="star" class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-200' }}"></i>
                                    @endfor
                                </div>
                                <span class="text-[10px] font-black text-gray-400 mt-1 block tracking-tighter">{{ $review->rating }}.0 / 5.0</span>
                            </td>

                            {{-- Comment --}}
                            <td class="px-8 py-6">
                                <div class="max-w-xs">
                                    <p class="text-sm text-gray-600 leading-relaxed italic mb-3">"{{ $review->comment ?? 'Hanya memberikan rating' }}"</p>
                                    @if($review->photo_path)
                                        <div class="relative group inline-block">
                                            <img src="{{ Storage::url($review->photo_path) }}" 
                                                 class="w-16 h-16 rounded-xl border border-gray-100 object-cover shadow-sm group-hover:scale-105 transition duration-300">
                                            <a href="{{ Storage::url($review->photo_path) }}" target="_blank" class="absolute inset-0 bg-black/40 rounded-xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                                <i data-lucide="zoom-in" class="w-4 h-4 text-white"></i>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </td>

                            {{-- Date --}}
                            <td class="px-8 py-6">
                                <p class="text-xs text-gray-500 font-medium">{{ $review->created_at->format('d M Y') }}</p>
                                <p class="text-[10px] text-gray-400 mt-1 tracking-widest uppercase font-bold">{{ $review->created_at->format('H:i') }} WIB</p>
                            </td>

                            {{-- Action --}}
                            <td class="px-8 py-6 text-right">
                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="p-2 text-rose-400 hover:bg-rose-50 rounded-xl transition duration-300">
                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center">
                                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <i data-lucide="star" class="w-10 h-10 text-gray-200"></i>
                                </div>
                                <h3 class="text-gray-900 font-black text-xl mb-1">Belum ada ulasan</h3>
                                <p class="text-gray-400 text-sm">Pelanggan belum memberikan feedback untuk produk Anda.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($reviews->hasPages())
        <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-100">
            {{ $reviews->links() }}
        </div>
        @endif

    </div>
</div>
@endsection
