@extends('layouts.shop')

@section('title', 'Ajukan Pengembalian Pesanan ' . $order->order_code . ' — Almart')

@section('content')

<div class="bg-gradient-to-r from-blue-600 to-indigo-700 py-12 shadow-sm">
    <div class="max-w-4xl mx-auto px-6 text-white text-center">
        <h2 class="text-3xl font-black uppercase tracking-widest mb-2">Ajukan Pengembalian</h2>
        <p class="text-blue-100 font-medium tracking-wide">Pesanan #{{ $order->order_code }}</p>
    </div>
</div>

<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-6">
        
        <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
            <div class="p-8 sm:p-12">
                
                <div class="mb-10 flex items-start gap-4 bg-amber-50 border-l-4 border-amber-400 p-6 rounded-r-2xl">
                    <div class="bg-amber-100 p-2 rounded-lg text-amber-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-amber-900 uppercase tracking-wider">Penting</h4>
                        <p class="text-amber-800 text-sm mt-1 leading-relaxed">
                            Pastikan Anda melampirkan foto bukti kerusakan atau ketidaksesuaian barang. Pengajuan tanpa bukti foto yang jelas akan otomatis ditolak.
                        </p>
                    </div>
                </div>

                <form action="{{ route('customer.returns.store', $order->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    
                    {{-- REASON --}}
                    <div>
                        <label for="reason" class="block text-sm font-black text-gray-900 uppercase tracking-widest mb-3">Alasan Pengembalian</label>
                        <textarea name="reason" id="reason" rows="5" 
                                  class="w-full px-6 py-4 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:border-blue-500 focus:bg-white transition duration-200 outline-none text-gray-700 placeholder:text-gray-300"
                                  placeholder="Jelaskan secara detail kendala yang Anda alami..." required>{{ old('reason') }}</textarea>
                        @error('reason')
                            <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- IMAGE PROOF --}}
                    <div>
                        <label class="block text-sm font-black text-gray-900 uppercase tracking-widest mb-3">Bukti Foto</label>
                        <div class="relative group">
                            <input type="file" name="image_proof" id="image_proof" 
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" required>
                            <div class="w-full h-40 border-2 border-dashed border-gray-200 rounded-3xl flex flex-col items-center justify-center bg-gray-50 group-hover:bg-blue-50 group-hover:border-blue-200 transition duration-300">
                                <svg class="w-10 h-10 text-gray-300 group-hover:text-blue-400 mb-2 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-sm font-bold text-gray-400 group-hover:text-blue-500 transition duration-300">Klik atau seret foto ke sini</p>
                                <p class="text-[10px] text-gray-300 mt-1 uppercase tracking-widest">Maksimal 5MB (JPG, PNG)</p>
                            </div>
                        </div>
                        @error('image_proof')
                            <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-6 border-t border-gray-50 flex items-center justify-end gap-4">
                        <a href="{{ route('customer.orders.show', $order->id) }}" class="px-8 py-3 text-sm font-bold text-gray-400 hover:text-gray-600 transition tracking-widest uppercase">
                            Batal
                        </a>
                        <button type="submit" class="px-10 py-4 bg-blue-600 hover:bg-blue-700 text-white text-sm font-black rounded-2xl shadow-lg shadow-blue-100 transition transform hover:-translate-y-0.5 tracking-widest uppercase">
                            Ajukan Sekarang
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection
