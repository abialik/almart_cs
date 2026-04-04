@extends('layouts.shop')

@section('title', 'Pengajuan Keluhan — Almart')

@section('content')
<div class="bg-gray-50 min-h-screen py-20 relative overflow-hidden">
    {{-- Decorative backgrounds --}}
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 rounded-full bg-green-100 opacity-50 blur-3xl mix-blend-multiply"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 rounded-full bg-blue-100 opacity-50 blur-3xl mix-blend-multiply"></div>

    <div class="max-w-3xl mx-auto px-6 relative z-10">
        
        @if(session('success'))
        <div class="mb-8 p-6 bg-green-50 rounded-2xl border-l-4 border-green-500 shadow-sm transition-all duration-300 transform scale-100 opacity-100 animate-[fadeIn_0.5s_ease-out]">
            <div class="flex items-center gap-4">
                <div class="bg-green-100 p-2 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-green-900">Keluhan Berhasil Dikirim</h3>
                    <p class="text-sm text-green-700 mt-1">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        <div class="bg-white/80 backdrop-blur-xl border border-white/40 shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-3xl p-8 sm:p-12 transition-all">
            <div class="mb-10 text-center">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-gray-100/80 text-gray-800 text-xs font-semibold tracking-wider uppercase mb-4">
                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    Pusat Bantuan
                </span>
                <h1 class="text-3xl sm:text-4xl font-black text-gray-900 mb-4 tracking-tight">Pengajuan Keluhan</h1>
                <p class="text-gray-500 max-w-lg mx-auto">Kami mohon maaf atas ketidaknyamanan yang Anda alami. Silakan isi form di bawah ini jika barang tidak sesuai atau terdapat masalah lain pada pesanan Anda.</p>
            </div>

            <form action="{{ route('customer.complaint.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Name -->
                <div class="space-y-2">
                    <label for="name" class="block text-sm font-semibold text-gray-700">Nama Lengkap</label>
                    <input type="text" id="name" name="name" required class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-green-500/10 focus:border-green-500 focus:bg-white transition-all text-sm @error('name') border-red-500 focus:ring-red-500/10 focus:border-red-500 @enderror" placeholder="Cth: John Doe" value="{{ old('name') }}">
                    @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Email -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-semibold text-gray-700">Alamat Email</label>
                        <input type="email" id="email" name="email" required class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-green-500/10 focus:border-green-500 focus:bg-white transition-all text-sm @error('email') border-red-500 focus:ring-red-500/10 focus:border-red-500 @enderror" placeholder="Cth: john@example.com" value="{{ old('email') }}">
                        @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Phone -->
                    <div class="space-y-2">
                        <label for="phone" class="block text-sm font-semibold text-gray-700">No. WhatsApp</label>
                        <input type="text" id="phone" name="phone" required class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-green-500/10 focus:border-green-500 focus:bg-white transition-all text-sm @error('phone') border-red-500 focus:ring-red-500/10 focus:border-red-500 @enderror" placeholder="0812xxxxxx" value="{{ old('phone') }}">
                        @error('phone') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Order Number -->
                    <div class="space-y-2">
                        <label for="order_number" class="block text-sm font-semibold text-gray-700">Nomor Pesanan <span class="text-gray-400 font-normal">(Opsional)</span></label>
                        <input type="text" id="order_number" name="order_number" class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-green-500/10 focus:border-green-500 focus:bg-white transition-all text-sm uppercase placeholder-normal @error('order_number') border-red-500 focus:ring-red-500/10 focus:border-red-500 @enderror" placeholder="ORD-XXXXXX" value="{{ old('order_number') }}">
                        @error('order_number') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Complaint Category -->
                    <div class="space-y-2">
                        <label for="complaint_type" class="block text-sm font-semibold text-gray-700">Jenis Keluhan</label>
                        <div class="relative">
                            <select id="complaint_type" name="complaint_type" required class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-green-500/10 focus:border-green-500 focus:bg-white transition-all text-sm appearance-none @error('complaint_type') border-red-500 focus:ring-red-500/10 focus:border-red-500 @enderror">
                                <option value="" disabled {{ old('complaint_type') ? '' : 'selected' }}>-- Pilih Jenis Keluhan --</option>
                                <option value="Barang tidak sesuai pesanan" {{ old('complaint_type') == 'Barang tidak sesuai pesanan' ? 'selected' : '' }}>Barang tidak sesuai pesanan</option>
                                <option value="Barang tiba rusak/cacat" {{ old('complaint_type') == 'Barang tiba rusak/cacat' ? 'selected' : '' }}>Barang tiba rusak/cacat</option>
                                <option value="Kualitas produk buruk" {{ old('complaint_type') == 'Kualitas produk buruk' ? 'selected' : '' }}>Kualitas produk buruk</option>
                                <option value="Barang kurang/hilang" {{ old('complaint_type') == 'Barang kurang/hilang' ? 'selected' : '' }}>Barang kurang/hilang</option>
                                <option value="Pengiriman sangat terlambat" {{ old('complaint_type') == 'Pengiriman sangat terlambat' ? 'selected' : '' }}>Pengiriman terlampau lambat</option>
                                <option value="Lainnya" {{ old('complaint_type') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                        @error('complaint_type') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="space-y-2">
                    <label for="description" class="block text-sm font-semibold text-gray-700">Detail Keluhan</label>
                    <textarea id="description" name="description" rows="5" required class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-green-500/10 focus:border-green-500 focus:bg-white transition-all text-sm resize-none @error('description') border-red-500 focus:ring-red-500/10 focus:border-red-500 @enderror" placeholder="Ceritakan secara detail keluhan yang Anda alami agar kami dapat membantu membedah masalahnya lebih cepat...">{{ old('description') }}</textarea>
                    @error('description') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-xs text-gray-500 max-w-xs text-center sm:text-left">Pengaduan Anda akan kami proses maksimal dalam waktu 1x24 jam hari kerja.</p>
                    <button type="submit" class="w-full sm:w-auto px-8 py-3.5 bg-gray-900 text-white font-semibold rounded-xl shadow-[0_8px_20px_rgb(0,0,0,0.12)] hover:bg-green-600 hover:shadow-green-600/30 hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2 group">
                        Kirim Keluhan
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </form>
        </div>
        
        <div class="mt-8 text-center text-sm text-gray-500">
            Punya kendala serius? Silakan <a href="{{ route('pages.contact') }}" class="font-semibold text-gray-900 hover:text-green-600 transition underline decoration-gray-300 underline-offset-4">hubungi customer service</a> kami secara langsung.
        </div>
    </div>
</div>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endsection
