@extends('layouts.admin')

@section('title', 'Detail Pengembalian Pesanan #' . $return->order->order_code)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <a href="{{ route('admin.returns.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-blue-600 font-bold text-sm mb-2 transition-colors">
                <i data-lucide="arrow-left" class="w-4 h-4 text-blue-500"></i>
                Kembali ke Daftar
            </a>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight uppercase">Detail Pengembalian</h1>
        </div>
        
        <div class="flex items-center gap-4">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">ID Pesanan</span>
            <span class="px-4 py-2 bg-gray-100 text-gray-900 rounded-xl font-black text-sm border border-gray-200">#{{ $return->order->order_code }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Reason Section -->
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/50 border border-gray-100 p-10">
                <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.25em] mb-6 flex items-center gap-3">
                    <span class="w-8 h-[2px] bg-blue-500"></span> Alasan Pengajuan
                </h3>
                <div class="p-6 bg-gray-50/50 rounded-3xl border border-gray-100 mb-8 italic text-gray-700 leading-relaxed">
                    "{{ $return->reason }}"
                </div>

                <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.25em] mb-6 flex items-center gap-3">
                    <span class="w-8 h-[2px] bg-blue-500"></span> Bukti Foto
                </h3>
                <div class="relative group aspect-square rounded-[2rem] overflow-hidden bg-gray-100 border-4 border-white shadow-2xl">
                    @if($return->image_proof)
                        <img src="{{ asset('storage/' . $return->image_proof) }}" 
                             alt="Bukti Pengembalian" 
                             class="w-full h-full object-cover transition duration-700 group-hover:scale-110 cursor-pointer"
                             onclick="window.open(this.src, '_blank')">
                        <div class="absolute inset-0 bg-gray-900/40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center pointer-events-none">
                            <span class="px-6 py-2.5 bg-white text-gray-900 rounded-full font-black text-[10px] tracking-widest uppercase shadow-xl transform translate-y-4 group-hover:translate-y-0 transition duration-500">
                                Klik untuk Perbesar
                            </span>
                        </div>
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-300 gap-4">
                            <i data-lucide="image-off" class="w-16 h-16"></i>
                            <span class="text-xs font-black uppercase tracking-widest">Tidak Ada Foto</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Order Info Summary -->
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/50 border border-gray-100 p-8">
                <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.25em] mb-6 flex items-center gap-3">
                    <span class="w-8 h-[2px] bg-blue-500"></span> Info Transaksi terkait
                </h3>
                <div class="divide-y divide-gray-50">
                    @foreach($return->order->items as $item)
                        <div class="py-4 flex items-center gap-4 group">
                            <div class="w-12 h-12 rounded-xl bg-gray-100 border border-gray-100 overflow-hidden flex-shrink-0 shadow-sm">
                                <img src="{{ asset($item->product->image ?? 'images/no-image.png') }}" class="w-full h-full object-cover" alt="{{ $item->product->name }}">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-black text-gray-900 truncate tracking-tight">{{ $item->product->name }}</p>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ $item->qty }}x @ Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-black text-blue-600 transition duration-300 group-hover:drop-shadow-sm">Rp{{ number_format($item->price * $item->qty, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="space-y-6">
            <!-- Customer Card -->
            <div class="bg-blue-600 rounded-[2.5rem] shadow-xl shadow-blue-200/50 p-8 text-white">
                <h3 class="text-[10px] font-black text-blue-200 uppercase tracking-[0.25em] mb-6">Pelanggan</h3>
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center font-black text-lg backdrop-blur-md shadow-inner">
                        {{ substr($return->customer->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-black text-lg leading-tight">{{ $return->customer->name }}</p>
                        <p class="text-[11px] font-bold text-blue-200 truncate max-w-[150px] uppercase tracking-wide">{{ $return->customer->email }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 pt-4 border-t border-white/10">
                    <div>
                        <p class="text-[9px] font-black text-blue-200 uppercase tracking-widest mb-1">Status</p>
                        <p class="text-sm font-black uppercase">{{ $return->status }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-blue-200 uppercase tracking-widest mb-1">Waktu</p>
                        <p class="text-xs font-bold">{{ $return->created_at->format('H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Action Form -->
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/50 border border-gray-100 p-8">
                <form action="{{ route('admin.returns.update', $return) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PATCH')
                    
                    <div>
                        <label for="status" class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.25em] mb-4">Keputusan Admin</label>
                        <select name="status" id="status" class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-100 rounded-2xl font-bold text-sm focus:border-blue-500 focus:bg-white outline-none transition duration-300">
                            <option value="pending" {{ $return->status == 'pending' ? 'selected' : '' }}>MENUNGGU</option>
                            <option value="approved" {{ $return->status == 'approved' ? 'selected' : '' }}>SETUJUI</option>
                            <option value="rejected" {{ $return->status == 'rejected' ? 'selected' : '' }}>TOLAK</option>
                        </select>
                    </div>

                    <div>
                        <label for="admin_note" class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.25em] mb-4">Catatan Balasan</label>
                        <textarea name="admin_note" id="admin_note" rows="5" class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-100 rounded-2xl font-bold text-sm focus:border-blue-500 focus:bg-white outline-none transition duration-300 placeholder:text-gray-300" placeholder="Berikan alasan atau instruksi lanjutan...">{{ $return->admin_note }}</textarea>
                    </div>

                    <div id="replacement-option" class="p-6 bg-blue-50 border-2 border-blue-100 rounded-3xl transition-all duration-300">
                        <label class="flex items-start gap-4 cursor-pointer group">
                            <div class="relative mt-1">
                                <input type="checkbox" name="send_replacement" value="1" class="peer sr-only">
                                <div class="w-6 h-6 bg-white border-2 border-blue-200 rounded-lg transition-all peer-checked:bg-blue-600 peer-checked:border-blue-600"></div>
                                <i data-lucide="check" class="w-4 h-4 text-white absolute top-1 left-1 opacity-0 transition-opacity peer-checked:opacity-100"></i>
                            </div>
                            <div>
                                <p class="text-sm font-black text-blue-900 uppercase">Ganti Baru & Kirim Otomatis</p>
                                <p class="text-[10px] font-bold text-blue-400 mt-0.5 leading-relaxed">
                                    Sistem akan otomatis membuat Pesanan Baru (Rp0) ke alamat pelanggan dan memberitahu petugas gudang.
                                </p>
                            </div>
                        </label>
                    </div>

                    <button type="submit" class="w-full py-5 bg-gray-900 text-white text-sm font-black rounded-2xl shadow-xl hover:bg-blue-600 hover:shadow-blue-100 transition-all active:scale-95 uppercase tracking-[0.2em]">
                        Konfirmasi Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
