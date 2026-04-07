<footer class="bg-[#fcfcfc] border-t border-gray-100 pt-20 pb-10 relative overflow-hidden">
    {{-- Subtle Decorative Vegetable Icons (Visual Aesthetic from Photo) --}}
    <div class="absolute left-[-20px] top-[20%] opacity-[0.05] pointer-events-none select-none rotate-12">
        <i data-lucide="citrus" class="w-32 h-32 text-green-600"></i>
    </div>
    <div class="absolute right-[-10px] top-[-10px] opacity-[0.05] pointer-events-none select-none rotate-[-15deg]">
        <i data-lucide="apple" class="w-40 h-40 text-rose-600"></i>
    </div>
    <div class="absolute right-[5%] bottom-[-20px] opacity-[0.05] pointer-events-none select-none rotate-[20deg]">
        <i data-lucide="pepper" class="w-32 h-32 text-orange-600"></i>
    </div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
            
            {{-- COLUMN 1: BRAND IDENTITY --}}
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" class="h-10 w-auto" alt="Almart Logo">
                    <div class="leading-tight">
                        <p class="font-black text-xl text-gray-900 tracking-tight">Almart</p>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">Segar Setiap Hari untuk Hidup Anda</p>
                    </div>
                </div>
                <p class="text-[14px] text-gray-400 font-medium leading-relaxed">
                    Almart menghadirkan makanan dan minuman segar, dipilih dengan kualitas tinggi untuk kebutuhan sehari-hari Anda.
                </p>
                <div class="space-y-4 pt-2">
                    <div class="flex items-start gap-3">
                        <i data-lucide="map-pin" class="w-5 h-5 text-rose-500 shrink-0"></i>
                        <span class="text-[13px] text-gray-500 font-medium">JL Pertanian Grogol Limo, Depok</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <i data-lucide="mail" class="w-5 h-5 text-rose-500 shrink-0"></i>
                        <span class="text-[13px] text-gray-500 font-medium">almartofficial@gmail.com</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <i data-lucide="phone" class="w-5 h-5 text-rose-500 shrink-0"></i>
                        <span class="text-[13px] text-gray-500 font-medium">0895347920306</span>
                    </div>
                </div>
            </div>

            {{-- COLUMN 2: COMPANY (ORIGINAL LINKS) --}}
            <div>
                <h4 class="font-black text-gray-900 mb-8 text-[15px] tracking-tight">Perusahaan</h4>
                <ul class="space-y-4 text-[13px] text-gray-400 font-medium">
                    <li><a href="{{ route('pages.about') }}" class="hover:text-rose-500 transition-colors">Tentang Kami</a></li>
                    <li><a href="{{ route('pages.delivery') }}" class="hover:text-rose-500 transition-colors">Informasi Pengiriman</a></li>
                    <li><a href="{{ route('pages.privacy') }}" class="hover:text-rose-500 transition-colors">Kebijakan Privasi</a></li>
                    <li><a href="{{ route('pages.terms') }}" class="hover:text-rose-500 transition-colors">Syarat & Ketentuan</a></li>
                </ul>
            </div>

            {{-- COLUMN 3: SUPPORT (ORIGINAL LINKS) --}}
            <div>
                <h4 class="font-black text-gray-900 mb-8 text-[15px] tracking-tight">Dukungan / Bantuan</h4>
                <ul class="space-y-4 text-[13px] text-gray-400 font-medium">
                    <li><a href="{{ route('pages.contact') }}" class="hover:text-rose-500 transition-colors">Hubungi Kami</a></li>
                    <li><a href="{{ route('pages.support') }}" class="hover:text-rose-500 transition-colors">Pusat Bantuan</a></li>
                    <li><a href="{{ route('pages.faq') }}" class="hover:text-rose-500 transition-colors">Tanya Jawab (FAQ)</a></li>
                    <li><a href="{{ route('customer.complaint.create') }}" class="hover:text-rose-500 transition-colors text-rose-600 font-bold">Pengajuan Keluhan</a></li>
                </ul>
            </div>

            {{-- COLUMN 4: UTILITY & STATUS --}}
            <div class="space-y-10">
                <div>
                    <h4 class="font-black text-gray-900 mb-6 text-[15px] tracking-tight">Metode Pembayaran</h4>
                    <div class="flex flex-wrap gap-2.5">
                        @foreach(['Transfer Bank', 'E-Wallet', 'QRIS', 'COD'] as $pm)
                        <div class="px-4 py-2 bg-white border border-gray-100 rounded-xl text-[10px] font-black text-gray-400 uppercase tracking-widest shadow-sm hover:border-rose-200 transition-all cursor-default">
                             {{ $pm }}
                        </div>
                        @endforeach
                    </div>
                </div>
                <div>
                     <h4 class="font-black text-gray-900 mb-4 text-[15px] tracking-tight font-black">Jam Operasional</h4>
                     <div class="flex items-center gap-3 text-rose-500">
                         <i data-lucide="clock" class="w-5 h-5"></i>
                         <span class="text-xs font-black text-gray-500 uppercase tracking-widest">Setiap Hari: 08:00 - 21:00</span>
                     </div>
                </div>
                <div class="flex items-center gap-4 pt-2">
                    <a href="#" class="w-10 h-10 bg-white border border-gray-100 rounded-xl flex items-center justify-center text-gray-400 hover:text-rose-500 hover:shadow-lg hover:shadow-rose-100 transition-all duration-300">
                        <i data-lucide="instagram" class="w-5 h-5"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-white border border-gray-100 rounded-xl flex items-center justify-center text-gray-400 hover:text-blue-600 hover:shadow-lg hover:shadow-blue-50 transition-all duration-300">
                        <i data-lucide="facebook" class="w-5 h-5"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-white border border-gray-100 rounded-xl flex items-center justify-center text-gray-400 hover:text-black hover:shadow-lg hover:shadow-gray-200 transition-all duration-300">
                         <i data-lucide="twitter" class="w-5 h-5 text-black"></i>
                    </a>
                </div>
            </div>

        </div>

        <div class="mt-20 pt-10 border-t border-gray-50 text-center">
            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest leading-loose">
                © 2026 <span class="text-rose-500">Almart</span> — Hak cipta dilindungi.
            </p>
        </div>
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if(typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
