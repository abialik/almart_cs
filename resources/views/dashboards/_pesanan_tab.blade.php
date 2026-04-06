<div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-[0_8px_40px_rgb(0,0,0,0.04)] border border-white p-8 mb-20">

    {{-- Title --}}
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Manajemen Pesanan Masuk</h2>
        <p class="text-sm text-gray-500 mt-1">Kelola pesanan dari pelanggan Almart</p>
    </div>

    {{-- KPI CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        
        {{-- Card 1: Pesanan Baru --}}
        <div class="group bg-gradient-to-br from-white to-blue-50/80 rounded-[2rem] p-6 border border-white shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-32 h-32 bg-blue-100/50 rounded-full blur-3xl group-hover:bg-blue-200/60 transition duration-500"></div>
            <div>
                <div class="flex items-center gap-3 mb-4 relative z-10">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-blue-500 to-cyan-400 text-white flex items-center justify-center shadow-lg shadow-blue-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Pesanan Baru</p>
                </div>
                <h3 class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500 relative z-10">{{ $countBaru }}</h3>
            </div>
        </div>

        {{-- Card 2: Sedang Diproses --}}
        <div class="group bg-gradient-to-br from-white to-amber-50/80 rounded-[2rem] p-6 border border-white shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-32 h-32 bg-amber-100/50 rounded-full blur-3xl group-hover:bg-amber-200/60 transition duration-500"></div>
            <div>
                <div class="flex items-center gap-3 mb-4 relative z-10">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-amber-500 to-orange-400 text-white flex items-center justify-center shadow-lg shadow-amber-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                    </div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Diproses</p>
                </div>
                <h3 class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-amber-500 to-orange-500 relative z-10">{{ $countDiproses }}</h3>
            </div>
        </div>

        {{-- Card 3: Selesai Hari Ini --}}
        <div class="group bg-gradient-to-br from-white to-emerald-50/80 rounded-[2rem] p-6 border border-white shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-32 h-32 bg-emerald-100/50 rounded-full blur-3xl group-hover:bg-emerald-200/60 transition duration-500"></div>
            <div>
                <div class="flex items-center gap-3 mb-4 relative z-10">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-500 to-green-400 text-white flex items-center justify-center shadow-lg shadow-emerald-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Selesai (Hari Ini)</p>
                </div>
                <h3 class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-green-500 relative z-10">{{ $countSelesai }}</h3>
            </div>
        </div>
    </div>

    {{-- FILTERS --}}
    <div class="flex gap-3 mb-8">
        <a href="?tab={{ $tab }}&filter=semua" class="px-6 py-2.5 rounded-full text-xs font-bold transition-all duration-300 {{ $filter === 'semua' ? 'bg-gray-900 text-white shadow-lg shadow-gray-200' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
            Semua ({{ $countSemua }})
        </a>
        <a href="?tab={{ $tab }}&filter=baru" class="px-6 py-2.5 rounded-full text-xs font-bold transition-all duration-300 {{ $filter === 'baru' ? 'bg-gray-900 text-white shadow-lg shadow-gray-200' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
            Baru ({{ $countBaru }})
        </a>
        <a href="?tab={{ $tab }}&filter=diproses" class="px-6 py-2.5 rounded-full text-xs font-bold transition-all duration-300 {{ $filter === 'diproses' ? 'bg-gray-900 text-white shadow-lg shadow-gray-200' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
            Diproses ({{ $countDiproses }})
        </a>
    </div>

    {{-- ORDER LIST --}}
    <div class="space-y-5">
        @forelse($orders as $order)
        <div class="border border-gray-100/80 rounded-[2rem] p-6 hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:border-pink-100 hover:-translate-y-0.5 transition-all duration-300 bg-white flex flex-col md:flex-row md:items-center justify-between gap-5 relative group overflow-hidden">
            
            {{-- Status indicator glow line --}}
            <div class="absolute left-0 top-0 bottom-0 w-2 opacity-80 group-hover:opacity-100 transition-opacity {{ $order->status === 'paid' ? 'bg-gradient-to-b from-blue-400 to-blue-600 shadow-[0_0_15px_rgba(59,130,246,0.5)]' : ($order->status === 'processing' ? 'bg-gradient-to-b from-amber-400 to-amber-600 shadow-[0_0_15px_rgba(251,191,36,0.5)]' : 'bg-gradient-to-b from-emerald-400 to-emerald-600 shadow-[0_0_15px_rgba(16,185,129,0.5)]') }}"></div>

            <div class="pl-4">
                <div class="flex items-center gap-3 mb-2.5">
                    <span class="font-bold text-gray-900 text-base tracking-wide">{{ $order->order_code }}</span>
                    
                    @if($order->status === 'paid')
                        <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-blue-50 text-blue-600 border border-blue-100 uppercase tracking-widest whitespace-nowrap">Baru Masuk</span>
                    @elseif($order->status === 'processing')
                        <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-100 uppercase tracking-widest whitespace-nowrap">Diproses</span>
                    @elseif($order->status === 'delivered')
                        <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100 uppercase tracking-widest whitespace-nowrap">Selesai</span>
                    @endif

                    <span class="px-2.5 py-1 rounded-md text-[10px] font-bold border border-gray-100 text-gray-500 bg-gray-50 uppercase tracking-widest">Delivery</span>
                </div>
                
                <p class="text-sm text-gray-500 mb-1.5">Pelanggan: <span class="font-bold text-gray-900">{{ $order->customer->name ?? $order->full_name }}</span></p>
                
                <div class="flex items-center gap-3 text-[13px] text-gray-500 font-semibold">
                    <span class="bg-gray-50 px-2 py-0.5 rounded border border-gray-100">{{ $order->items->count() }} Item</span>
                    <span class="text-gray-300">•</span>
                    <span class="text-pink-500 font-bold">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    <span class="text-gray-300">•</span>
                    <span class="flex items-center gap-1 text-gray-400 hover:text-gray-600 transition"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> {{ $order->updated_at->diffForHumans() }}</span>
                </div>
            </div>

            <div class="flex items-center gap-2.5 pl-4 md:pl-0">
                <button onclick="openDetailModal({{ $order->id }})" class="px-5 py-2.5 bg-white hover:bg-gray-50 text-gray-600 hover:text-gray-900 text-xs font-bold rounded-xl border border-gray-200 hover:border-gray-300 transition-all shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    Detail
                </button>
                
                <button class="px-5 py-2.5 bg-white hover:bg-gray-50 text-gray-600 hover:text-gray-900 text-xs font-bold rounded-xl border border-gray-200 hover:border-gray-300 transition-all shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Print
                </button>

                {{-- Action Buttons Based on Status --}}
                @if($order->status === 'paid')
                    <form action="{{ route('petugas.orders.update-status', $order->id) }}" method="POST" class="inline" id="form-tolak-{{ $order->id }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="cancelled">
                        <button type="button" onclick="confirmTolak({{ $order->id }})" class="px-5 py-2.5 bg-white text-rose-500 hover:bg-rose-50 border border-rose-200 hover:border-rose-300 text-xs font-bold rounded-xl transition-all shadow-sm flex items-center gap-2 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            Tolak
                        </button>
                    </form>

                    <form action="{{ route('petugas.orders.update-status', $order->id) }}" method="POST" class="inline" id="form-terima-{{ $order->id }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="processing">
                        <button type="button" onclick="confirmTerima({{ $order->id }})" class="px-6 py-2.5 hover:-translate-y-0.5 bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white text-xs font-bold rounded-xl shadow-lg shadow-pink-200/80 transition-all duration-300 flex items-center gap-2 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            Terima
                        </button>
                    </form>
                @elseif($order->status === 'processing')
                    <form action="{{ route('petugas.orders.update-status', $order->id) }}" method="POST" class="inline" id="form-selesai-{{ $order->id }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="delivered">
                        <button type="button" onclick="confirmSelesai({{ $order->id }})" class="px-6 py-2.5 hover:-translate-y-0.5 bg-gradient-to-r from-emerald-500 to-green-500 hover:from-emerald-600 hover:to-green-600 text-white text-xs font-bold rounded-xl shadow-lg shadow-emerald-200/80 transition-all duration-300 flex items-center gap-2 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            Selesaikan
                        </button>
                    </form>
                @endif

            </div>
        </div>
        @empty
        <div class="text-center py-24 bg-white border border-dashed border-gray-200 rounded-[2rem]">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-5 border border-gray-100 shadow-inner">
                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Antrean</h3>
            <p class="text-sm text-gray-400 max-w-sm mx-auto leading-relaxed">Tidak ada pesanan masuk untuk status ini saat ini. Sistem akan otomatis memberitahu jika ada yang baru.</p>
        </div>
        @endforelse

        @if($orders->hasPages())
        <div class="mt-8">
            {{ $orders->links() }}
        </div>
        @endif
    </div>

</div>
