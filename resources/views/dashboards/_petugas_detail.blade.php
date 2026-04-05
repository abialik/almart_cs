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

    {{-- CUSTOMER INFO CARD --}}
    <div class="bg-gray-50/50 rounded-2xl p-4 border border-gray-100 mb-5">
        <h3 class="text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-3">Informasi Pelanggan</h3>
        
        <div class="space-y-3">
            <div class="flex gap-3 items-start">
                <svg class="w-4 h-4 text-gray-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <p class="text-sm font-bold text-gray-800">{{ $order->customer->name ?? $order->full_name }}</p>
            </div>
            <div class="flex gap-3 items-start">
                <svg class="w-4 h-4 text-gray-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1.01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                <p class="text-sm text-gray-600">{{ $order->phone ?? '-' }}</p>
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
        
        <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
            <p class="font-bold text-gray-900">Total:</p>
            <p class="text-lg font-black text-pink-500">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- PRINT BUTTON --}}
    <button onclick="window.print()" class="w-full py-3.5 bg-white border border-gray-200 text-gray-800 font-bold rounded-xl shadow-sm hover:bg-gray-50 hover:shadow transition flex justify-center items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
        Print Pesanan
    </button>
</div>
