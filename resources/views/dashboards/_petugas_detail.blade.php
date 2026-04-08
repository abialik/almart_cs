<div class="relative">
    {{-- CLOSE BUTTON --}}
    <button type="button" onclick="closeDetailModal(event)" class="absolute top-0 right-0 text-gray-400 hover:text-gray-600 p-2 rounded-xl hover:bg-gray-50 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
    </button>

    {{-- HEADER --}}
    <div class="mb-6 pr-10">
        <h2 class="text-xl font-bold text-gray-900 leading-tight">Detail Pesanan</h2>
        <p class="text-xs text-gray-400 font-semibold mb-3">{{ $order->order_code }}</p>
        
        <div class="flex gap-2">
            @if($order->status === 'paid')
                <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-blue-500 text-white shadow-sm uppercase tracking-widest">Baru</span>
            @elseif($order->status === 'processing')
                <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-amber-500 text-white shadow-sm uppercase tracking-widest">Diproses</span>
            @elseif($order->status === 'delivered')
                <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-500 text-white shadow-sm uppercase tracking-widest">Selesai</span>
            @endif
            <span class="px-3 py-1 rounded-full text-[10px] font-bold border border-emerald-200 text-emerald-600 bg-emerald-50 shadow-sm uppercase tracking-widest">Delivery</span>
        </div>
    </div>

    {{-- PAYMENT PROOF (IF PENDING/PAID) --}}
    @if(in_array($order->status, ['pending', 'paid']) && $order->payment && $order->payment->proof_of_payment)
    <div class="mb-5">
        <h3 class="text-[11px] font-bold text-rose-500 uppercase tracking-widest mb-3 flex items-center gap-2">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Bukti Pembayaran
        </h3>
        <div class="relative group/proof cursor-zoom-in" onclick="window.open('{{ Storage::url($order->payment->proof_of_payment) }}', '_blank')">
            <img src="{{ Storage::url($order->payment->proof_of_payment) }}" class="w-full h-32 object-cover rounded-2xl border-2 border-dashed border-rose-100 group-hover/proof:border-rose-300 transition-all">
            <div class="absolute inset-0 bg-black/20 opacity-0 group-hover/proof:opacity-100 rounded-2xl flex items-center justify-center transition-opacity">
                <span class="text-[10px] font-black text-white uppercase tracking-widest">Klik untuk Perbesar</span>
            </div>
        </div>
    </div>
    @endif

    {{-- TRACKING & RESPONSIBILITY --}}
    <div class="mb-5 bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl p-4 shadow-lg border border-gray-700 relative overflow-hidden">
        <div class="absolute -right-4 -bottom-4 w-16 h-16 bg-white/5 rounded-full blur-xl"></div>
        <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3 flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            Lacak & Tanggung Jawab
        </h3>
        
        <div class="space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center border border-white/10">
                    <i data-lucide="user-check" class="w-4 h-4 text-pink-400"></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Petugas Penanggung Jawab</p>
                    <p class="text-sm font-bold text-white">{{ $order->petugas->name ?? 'Belum Ditentukan' }}</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center border border-white/10">
                    <i data-lucide="calendar" class="w-4 h-4 text-amber-400"></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Waktu Masuk Sistem</p>
                    <p class="text-xs text-gray-300 font-medium">{{ $order->created_at->translatedFormat('d M Y, H:i') }} ({{ $order->created_at->diffForHumans() }})</p>
                </div>
            </div>
        </div>
    </div>

    {{-- CUSTOMER INFO CARD --}}
    <div class="bg-gray-50/50 rounded-2xl p-4 border border-gray-100 mb-5">
        <h3 class="text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-3">Informasi Pelanggan</h3>
        
        <div class="space-y-3">
            <div class="flex gap-3 items-start">
                <svg class="w-4 h-4 text-gray-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <p class="text-sm font-bold text-gray-800">{{ $order->customer->name ?? $order->full_name }}</p>
            </div>
            <div class="flex gap-3 items-start justify-between">
                <div class="flex gap-3 items-start">
                    <svg class="w-4 h-4 text-gray-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1.01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <p class="text-sm text-gray-600">{{ $order->phone ?? '-' }}</p>
                </div>
                @if($order->phone)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->phone) }}" target="_blank" class="text-emerald-500 hover:text-emerald-600 transition flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 448 512"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.7 17.9 69.4 27.3 107.1 27.3 122.3 0 222-99.6 222-222 0-59.3-23.1-115.1-65.1-157.1zM223.9 445.5c-33.1 0-65.7-8.9-94.1-25.7l-6.7-4-69.8 18.3 18.7-68.1-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.5-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-5.6-2.8-23.5-8.7-44.8-27.7-16.6-14.8-27.8-33-31.1-38.6-3.3-5.6-.4-8.6 2.5-11.4 2.5-2.5 5.6-6.5 8.3-9.8 2.8-3.3 3.7-5.6 5.6-9.3 1.8-3.7.9-7-.5-9.8-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 13.2 5.8 23.5 9.2 31.6 11.8 13.3 4.2 25.4 3.6 35 2.2 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>
                        Hubungi
                    </a>
                @endif
            </div>
            <div class="flex gap-3 items-start">
                <svg class="w-4 h-4 text-gray-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $order->address }}, {{ $order->city }}, {{ $order->province }}</p>
            </div>
        </div>
    </div>

    {{-- ITEMS LIST --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-6">
        <h3 class="text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-3">Daftar Barang</h3>
        
        <div class="max-h-48 overflow-y-auto pr-2 space-y-3 custom-scrollbar">
            @foreach($order->items as $item)
            <div class="flex gap-3 items-center group relative p-2 rounded-xl flex-wrap">
                <div class="w-12 h-12 bg-gray-50 rounded-lg flex items-center justify-center p-1.5 border border-gray-100 shrink-0">
                    @if($item->product && $item->product->image)
                        <img src="{{ asset($item->product->image) }}" class="w-full h-full object-contain" alt="{{ $item->product->name }}">
                    @else
                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-gray-900 truncate">{{ $item->product->name ?? 'Produk Dihapus' }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $item->qty }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                </div>
                <div class="text-right shrink-0">
                    <p class="text-sm font-black text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                </div>
                
                {{-- CHECKBOX INTERACTION UNTUK PICKING --}}
                <label class="w-full mt-2 cursor-pointer relative flex items-center gap-2 group-hover:bg-pink-50/50 p-2 rounded-lg border border-transparent hover:border-pink-100 transition">
                    <input type="checkbox" class="w-4 h-4 text-pink-500 rounded border-gray-300 focus:ring-pink-500 focus:ring-2 peer">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 peer-checked:text-pink-500 transition">Tandai telah diambil</span>
                </label>
            </div>
            @if(!$loop->last)
                <hr class="border-gray-50 border-dashed">
            @endif
            @endforeach
        </div>
        
        <div class="mt-4 pt-4 border-t border-gray-100 flex flex-col gap-3">
            <div class="flex justify-between items-center">
                <p class="font-bold text-gray-900">Total:</p>
                <p class="text-lg font-black text-pink-500">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
            </div>
            
            {{-- TOMBOL PRINT --}}
            <a href="{{ route('petugas.orders.receipt', $order->id) }}" target="_blank" class="w-full flex items-center justify-center gap-2 py-3 bg-gray-900 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-gray-800 transition">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Struk
            </a>
        </div>
    </div>

    </div>
</div>
