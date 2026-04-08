<div class="w-full h-full animate-fade-in-up">
    {{-- Top Header Details --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 pb-6 border-b border-gray-100 gap-4">
        <div>
            <h2 class="text-xl font-bold text-gray-900 leading-tight">Picking List - {{ $order->order_code }}</h2>
            <p class="text-sm font-semibold text-gray-500 mt-1">{{ $order->customer->name ?? $order->full_name }}</p>
        </div>
        
        <div class="flex items-center gap-3">
            {{-- TOMBOL PRINT --}}
            <a href="{{ route('petugas.orders.receipt', $order->id) }}" target="_blank" class="px-5 py-2.5 rounded-full text-xs font-black bg-gray-100 text-gray-500 hover:bg-gray-200 transition uppercase tracking-widest flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Struk
            </a>

            <form action="{{ route('petugas.orders.complete-picking', $order->id) }}" method="POST" id="form-selesai-picking-{{ $order->id }}">
                @csrf
                @method('PATCH')
                <button type="button" onclick="confirmSelesaiPicking({{ $order->id }})" id="btn-selesai-{{ $order->id }}" class="px-6 py-2.5 rounded-full text-sm font-bold bg-pink-100 text-pink-400 cursor-not-allowed transition-all duration-300 flex items-center gap-2 shadow-sm" disabled>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Selesai Picking
                </button>
            </form>
        </div>
    </div>

    {{-- Progress Bar Interaktif --}}
    <div class="mb-8">
        <div class="flex justify-between text-xs font-bold text-gray-800 mb-3">
            <span class="uppercase tracking-wider text-[10px] text-gray-500">Progress Picking</span>
            <span id="progress-text-{{ $order->id }}">0/{{ $order->items->count() }} item</span>
        </div>
        <div class="w-full bg-gray-100 rounded-full h-4 shadow-inner overflow-hidden">
            <div id="progress-bar-{{ $order->id }}" class="bg-gradient-to-r from-pink-400 to-rose-400 h-4 rounded-full transition-all duration-500 ease-out shadow-[0_0_10px_rgba(2fb,113,133,0.4)]" style="width: 0%"></div>
        </div>
    </div>

    {{-- Item List Checkboxes --}}
    <div class="space-y-4">
        @foreach($order->items as $item)
            <label class="flex items-center p-4 border border-gray-100 rounded-2xl cursor-pointer hover:bg-gray-50 hover:border-gray-200 transition-all group relative overflow-hidden">
                
                {{-- Custom Checkbox --}}
                <div class="mr-5 relative shrink-0">
                    <input type="checkbox" onchange="updatePickingProgress({{ $order->id }}, {{ $order->items->count() }})" class="picking-checkbox-{{ $order->id }} peer appearance-none w-6 h-6 border-2 border-gray-300 rounded-md checked:bg-pink-500 checked:border-pink-500 hover:border-pink-400 transition-colors cursor-pointer ring-pink-200 focus:ring-2 focus:ring-offset-2">
                    <svg class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-4 h-4 text-white opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>

                {{-- Image --}}
                <div class="w-14 h-14 bg-white rounded-xl shadow-sm border border-gray-100 mr-4 flex-shrink-0 flex items-center justify-center p-1.5 object-cover overflow-hidden">
                    @if($item->product && $item->product->image)
                        <img src="{{ asset($item->product->image) }}" class="w-full h-full object-contain">
                    @else
                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    @endif
                </div>

                {{-- Text Details --}}
                <div class="flex-grow">
                    <h4 class="text-sm font-bold text-gray-900 group-hover:text-pink-600 transition-colors">{{ $item->product->name ?? 'Produk Dihapus' }}</h4>
                    <div class="text-xs text-gray-500 font-semibold mt-1 flex items-center gap-2">
                        <span class="text-gray-900">Qty: {{ $item->qty }}</span>
                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                        <span>Rak {{ strtoupper(substr(md5($item->product_id ?? 0), 0, 4)) }}</span>
                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                        <span>SKU: {{ $item->product_id ?? '0000' }}</span>
                    </div>
                </div>

            </label>
        @endforeach
    </div>
</div>
