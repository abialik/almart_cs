<div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-[0_8px_40px_rgb(0,0,0,0.04)] border border-white p-8 mb-20 animate-fade-in">
    
    {{-- Toggle Delivery / Pick-up (Tab dalam tab) --}}
    <div class="bg-gray-100/80 p-2 rounded-2xl flex max-w-2xl mx-auto mb-10 shadow-inner">
        <a href="?tab=delivery&subtab=delivery_list" 
           class="flex-1 py-3 font-bold rounded-xl text-sm flex items-center justify-center gap-2 transition-all {{ $subtab === 'delivery_list' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
            🚚 Delivery
        </a>
        <a href="?tab=delivery&subtab=pickup_list" 
           class="flex-1 py-3 font-bold rounded-xl text-sm flex items-center justify-center gap-2 transition-all {{ $subtab === 'pickup_list' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
            📦 Pick-up
        </a>
    </div>

    @if($subtab === 'delivery_list')
        {{-- Delivery List (Original UI) --}}
        <div class="mb-8 text-center md:text-left">
            <h2 class="text-2xl font-bold text-gray-900">Antrean Pengiriman Real-Time</h2>
            <p class="text-sm text-gray-500 mt-1">Daftar pesanan yang sedang dalam proses pengiriman oleh kurir</p>
        </div>

        {{-- KPI CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            {{-- Card 1: Sedang Dikirim --}}
            <div class="group bg-gradient-to-br from-blue-50 to-white rounded-[2rem] p-6 border border-blue-100 shadow-sm hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-200/20 rounded-full blur-2xl group-hover:bg-blue-300/30 transition duration-500"></div>
                <div class="flex items-center gap-3 mb-4 relative z-10">
                    <div class="w-10 h-10 rounded-xl bg-blue-500 text-white flex items-center justify-center shadow-lg shadow-blue-100">
                        <span class="text-lg">🚚</span>
                    </div>
                    <p class="text-xs font-bold text-blue-600 uppercase tracking-widest">Dalam Pengantaran</p>
                </div>
                <h3 class="text-4xl font-black text-blue-700 relative z-10">{{ $countDelivery }}</h3>
            </div>

            {{-- Card 2: Selesai Hari Ini --}}
            <div class="group bg-gradient-to-br from-emerald-50 to-white rounded-[2rem] p-6 border border-emerald-100 shadow-sm hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-200/20 rounded-full blur-2xl group-hover:bg-emerald-300/30 transition duration-500"></div>
                <div class="flex items-center gap-3 mb-4 relative z-10">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center shadow-lg shadow-emerald-100">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="text-xs font-bold text-emerald-600 uppercase tracking-widest">Terkirim (Hari Ini)</p>
                </div>
                <h3 class="text-4xl font-black text-emerald-700 relative z-10">{{ $countSelesai }}</h3>
            </div>

            {{-- Card 3: Total Aktif --}}
            <div class="group bg-gradient-to-br from-gray-50 to-white rounded-[2rem] p-6 border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-gray-200/20 rounded-full blur-2xl group-hover:bg-gray-300/30 transition duration-500"></div>
                <div class="flex items-center gap-3 mb-4 relative z-10">
                    <div class="w-10 h-10 rounded-xl bg-gray-900 text-white flex items-center justify-center shadow-lg shadow-gray-200">
                        <span class="text-lg">📊</span>
                    </div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Total Antrean Aktif</p>
                </div>
                <h3 class="text-4xl font-black text-gray-900 relative z-10">{{ $countSemua }}</h3>
            </div>
        </div>

        {{-- ORDER LIST --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @forelse($orders->where('status', 'delivering') as $order)
                <div class="border border-gray-100 rounded-[2.5rem] p-8 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 bg-white relative overflow-hidden group">
                    {{-- Status Badge --}}
                    <div class="absolute top-0 right-0 p-6">
                        <span class="px-4 py-1.5 rounded-full text-[10px] font-black bg-blue-600 text-white uppercase tracking-tighter shadow-lg shadow-blue-100">Dalam Perjalanan</span>
                    </div>

                    <div class="flex items-center gap-6 mb-6">
                        {{-- Product Thumbnail (First Item) --}}
                        <div class="hidden sm:flex w-16 h-16 bg-gray-50 rounded-2xl border border-gray-100 items-center justify-center p-2 shrink-0 group-hover:scale-105 transition-transform duration-500">
                            @if($order->items->first() && $order->items->first()->product && $order->items->first()->product->image)
                                <img src="{{ asset($order->items->first()->product->image) }}" class="max-w-full max-h-full object-contain">
                            @else
                                <i data-lucide="image" class="w-6 h-6 text-gray-200"></i>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-gray-900 tracking-tight mb-1 group-hover:text-pink-600 transition-colors">{{ $order->order_code }}</h3>
                            <p class="text-sm font-bold text-gray-400">Rp {{ number_format($order->total, 0, ',', '.') }} • {{ $order->items->count() }} Item</p>
                        </div>
                    </div>

                    <div class="space-y-4 mb-8">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-pink-50 text-pink-500 flex items-center justify-center shrink-0 border border-pink-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Nama Penerima</p>
                                <p class="text-sm font-bold text-gray-800">{{ $order->customer->name ?? $order->full_name }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center shrink-0 border border-amber-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Alamat Pengiriman</p>
                                <p class="text-xs font-bold text-gray-600 leading-relaxed">{{ $order->address }}, {{ $order->city }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center shrink-0 border border-blue-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Nomor Telepon</p>
                                <p class="text-sm font-bold text-gray-800">{{ $order->phone }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Action --}}
                    <div class="pt-6 border-t border-gray-100">
                        <form action="{{ route('petugas.orders.update-status', $order->id) }}" method="POST" id="form-selesai-delivery-{{ $order->id }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="delivered">
                            <button type="button" onclick="confirmSelesaiDelivery({{ $order->id }})" class="w-full py-4 bg-gray-900 hover:bg-emerald-600 text-white text-sm font-black rounded-2xl shadow-xl shadow-gray-200 transition-all duration-300 flex items-center justify-center gap-3 group/btn">
                                <svg class="w-5 h-5 transition-transform group-hover/btn:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                Selesaikan Pengiriman
                            </button>
                        </form>
                    </div>

                    {{-- Decorative background icon --}}
                    <div class="absolute -right-10 -bottom-10 opacity-[0.03] group-hover:opacity-[0.07] transition-opacity duration-500">
                        <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-24 bg-gray-50/50 border-2 border-dashed border-gray-100 rounded-[3rem] text-center">
                    <div class="w-24 h-24 bg-white rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-sm border border-gray-100">
                        <span class="text-4xl text-gray-300">🚚</span>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-2">Antrean Pengiriman Kosong</h3>
                    <p class="text-sm text-gray-400 max-w-sm mx-auto font-medium">Belum ada pesanan yang selesai dipacking dan siap dikirim. Selesaikan proses picking untuk memunculkan data di sini.</p>
                </div>
            @endforelse
        </div>
    @else
        {{-- Pick-up List (Mockup UI) --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            {{-- Left: Validasi Code --}}
            <div class="lg:col-span-4 bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-sm sticky top-8">
                <h3 class="text-xl font-bold text-gray-800 mb-6 tracking-tight">Validasi Pickup</h3>
                
                <form action="{{ route('petugas.orders.validate-pickup') }}" method="POST" id="pickupValidationForm">
                    @csrf
                    <div class="mb-5">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2.5">Masukkan kode pickup</label>
                        <input type="text" name="pickup_code" placeholder="PICK-XXXX" 
                               class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl text-lg font-black text-center focus:ring-4 focus:ring-pink-100 focus:border-pink-500 transition-all outline-none uppercase tracking-widest placeholder:text-gray-300" 
                               required>
                    </div>
                    
                    <button type="submit" class="w-full py-4 bg-gradient-to-r from-pink-500 to-rose-500 text-white font-black text-sm rounded-2xl shadow-xl shadow-pink-100 hover:-translate-y-1 transition-all flex items-center justify-center gap-3 mb-8 group active:scale-95">
                        <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Validasi Kode
                    </button>

                    <div class="space-y-2">
                         <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Catatan Pickup:</label>
                         <textarea name="pickup_note" rows="4" 
                                   class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl text-sm text-gray-700 font-medium focus:ring-4 focus:ring-pink-100 outline-none transition-all placeholder:text-gray-300 resize-none" 
                                   placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                    </div>
                </form>
            </div>

            {{-- Right: Pickup List --}}
            <div class="lg:col-span-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 px-2">
                    <div>
                        <h3 class="text-2xl font-black text-gray-800 tracking-tight">Daftar Pesanan Pick-up</h3>
                        <p class="text-xs font-bold text-gray-400 mt-0.5">Pesanan siap diambil pelanggan</p>
                    </div>
                    <div class="flex items-center gap-2">
                         <span class="px-4 py-1.5 bg-pink-50 text-pink-500 rounded-full text-[10px] font-black uppercase tracking-widest border border-pink-100 shadow-sm">Siap Diambil</span>
                    </div>
                </div>
                 
                <div class="space-y-5 max-h-[700px] overflow-y-auto pr-2 custom-scrollbar">
                    @forelse($orders->where('status', 'ready_for_pickup') as $pickup)
                        <div class="bg-white border border-gray-100 rounded-[2.5rem] p-7 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group overflow-hidden relative border-l-8 border-l-blue-500">
                             {{-- Status Badge --}}
                             <div class="absolute top-0 right-0 p-6 flex items-center gap-2">
                                <span class="bg-blue-50 text-blue-500 p-2 rounded-xl border border-blue-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                                </span>
                             </div>

                             <div class="flex flex-col md:flex-row md:justify-between items-start md:items-center mb-6 gap-4">
                                <div class="flex items-center gap-5 flex-1">
                                    {{-- Product Thumbnail (First Item) --}}
                                    <div class="hidden sm:flex w-14 h-14 bg-gray-50 rounded-xl border border-gray-100 items-center justify-center p-1.5 shrink-0 group-hover:scale-105 transition-transform duration-500 shadow-sm">
                                        @if($pickup->items->first() && $pickup->items->first()->product && $pickup->items->first()->product->image)
                                            <img src="{{ asset($pickup->items->first()->product->image) }}" class="max-w-full max-h-full object-contain">
                                        @else
                                            <i data-lucide="image" class="w-6 h-6 text-gray-200"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="text-2xl font-black text-gray-800 group-hover:text-pink-600 transition-colors leading-tight">{{ $pickup->order_code }}</h4>
                                        <div class="flex flex-wrap items-center gap-4 mt-2">
                                            <div class="flex items-center gap-2 text-xs font-bold text-gray-500">
                                                <div class="w-6 h-6 rounded-lg bg-pink-50 text-pink-500 flex items-center justify-center shrink-0 border border-pink-100">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                                </div>
                                                {{ $pickup->full_name ?? $pickup->customer->name }}
                                            </div>
                                             <div class="flex items-center gap-2 text-xs font-bold text-gray-500">
                                                <div class="w-6 h-6 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center shrink-0 border border-blue-100">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                                </div>
                                                {{ $pickup->phone }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right shrink-0">
                                    <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest mb-1">{{ $pickup->items->count() }} Item</p>
                                    <p class="text-xl font-black text-pink-600 tracking-tight">Rp {{ number_format($pickup->total, 0, ',', '.') }}</p>
                                </div>
                             </div>

                             <div class="bg-gray-50/80 border border-gray-100 rounded-2xl p-5 flex flex-wrap justify-between items-center gap-4 relative overflow-hidden group/code cursor-copy active:scale-[0.98] transition-transform" onclick="copyToClipboard('{{ $pickup->pickup_code }}')">
                                <div class="absolute -right-4 -bottom-4 opacity-[0.02] group-hover/code:opacity-[0.05] transition-opacity duration-300">
                                    <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-xs font-black text-gray-400 uppercase tracking-widest">Kode Pickup:</span>
                                    <div class="flex items-center gap-2">
                                        <span class="text-2xl font-black text-blue-600 tracking-[0.2em] font-mono">{{ $pickup->pickup_code }}</span>
                                        <svg class="w-4 h-4 text-gray-300 group-hover/code:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                                    </div>
                                </div>
                                <div class="text-xs font-bold text-gray-400 flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Siap sejak {{ $pickup->updated_at->diffForHumans() }}
                                </div>
                             </div>
                        </div>
                    @empty
                        <div class="py-24 bg-gray-50/50 border-2 border-dashed border-gray-100 rounded-[3rem] text-center">
                             <div class="w-20 h-20 bg-white rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-sm border border-gray-100">
                                <span class="text-4xl grayscale">📦</span>
                             </div>
                             <h4 class="text-xl font-black text-gray-900 mb-2">Antrean Pickup Kosong</h4>
                             <p class="text-xs font-bold text-gray-400 max-w-xs mx-auto">Semua pesanan ambil di toko telah terlayani dengan baik.</p>
                        </div>
                    @endforelse
                 </div>
            </div>
        </div>
    @endif
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #f1f1f1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #e5e5e5; }
    .animate-fade-in { animation: fadeIn 0.5s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Kode ' + text + ' disalin!',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                customClass: { popup: 'rounded-xl font-bold' }
            });
        });
    }

    function confirmSelesaiDelivery(orderId) {
        Swal.fire({
            title: 'Selesaikan Pengiriman?',
            text: "Pastikan barang sudah diterima oleh pelanggan dengan benar.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#f43f5e',
            confirmButtonText: 'Ya, Selesai!',
            cancelButtonText: 'Batal',
            border: 'none',
            customClass: {
                popup: 'rounded-[2rem] p-6 shadow-2xl border border-gray-100 font-plus-jakarta',
                confirmButton: 'rounded-xl font-bold px-6 py-3',
                cancelButton: 'rounded-xl font-bold px-6 py-3 border border-gray-200'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-selesai-delivery-' + orderId).submit();
            }
        })
    }
</script>
