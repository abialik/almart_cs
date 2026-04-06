{{-- PICKING UI: 2 Columns Grid --}}
<div class="flex flex-col lg:flex-row gap-6 mb-20 items-stretch">
    
    {{-- Left Column: Daftar Picking --}}
    <div class="w-full lg:w-1/3 bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-[0_8px_40px_rgb(0,0,0,0.04)] border border-white p-6">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-900">Daftar Picking</h2>
            <p class="text-xs text-gray-500 mt-1">Pilih pesanan untuk mulai picking</p>
        </div>

        <div class="space-y-4">
            @forelse($orders->where('status', 'processing') as $order)
                <div onclick="openPickingDetail({{ $order->id }})" id="picking-card-{{ $order->id }}" class="picking-card cursor-pointer border-2 border-transparent border-gray-100 rounded-2xl p-5 hover:border-pink-300 transition-all duration-300 bg-white relative overflow-hidden group shadow-sm hover:shadow-md">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="font-bold text-gray-900 text-sm group-hover:text-pink-600 transition-colors">{{ $order->order_code }}</h3>
                        @if($order->total > 500000)
                            <span class="bg-rose-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">Prioritas Tinggi</span>
                        @else
                            <span class="bg-blue-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">Normal</span>
                        @endif
                    </div>
                    <p class="text-xs font-semibold text-gray-600 mb-4 truncate">{{ $order->customer->name ?? $order->full_name }}</p>
                    
                    {{-- Info Bawah --}}
                    <div class="flex justify-between items-center text-[10px] text-gray-400 font-bold mb-1.5">
                        <span class="flex items-center gap-1.5"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2"/></svg> {{ $order->updated_at->format('H:i') }}</span>
                        <span class="tracking-wide">Menunggu</span>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 opacity-60">
                    <p class="text-sm font-bold text-gray-500">Belum ada pesanan yang diproses.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Right Column: Kanvas Detail --}}
    <div id="pickingContentTarget" class="w-full lg:w-2/3 bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-[0_8px_40px_rgb(0,0,0,0.04)] border border-white p-8 lg:min-h-[500px] flex items-center justify-center relative transition-all duration-300">
        {{-- State Default / Kosong --}}
        <div class="text-center opacity-40">
            <svg class="w-20 h-20 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            <p class="text-lg font-bold text-gray-500">Pilih Pesanan di Samping</p>
            <p class="text-sm text-gray-400 mt-1 max-w-sm mx-auto">Daftar item untuk di-picking akan muncul di sini</p>
        </div>
    </div>

</div>
