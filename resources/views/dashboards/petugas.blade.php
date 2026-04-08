@extends('layouts.app')

@section('title', 'Almart Dashboard - Staff Management System')

@section('content')
@auth
<div class="min-h-screen bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-pink-50 via-gray-50/50 to-white font-plus-jakarta pb-20 relative selection:bg-pink-200">

    {{-- HEADER (GLASSMORPHISM) --}}
    <div class="backdrop-blur-xl bg-white/70 px-8 py-5 shadow-[0_4px_30px_rgb(0,0,0,0.03)] flex justify-between items-center sticky top-0 z-40 border-b border-white/50">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white rounded-xl shadow-sm border border-gray-100 flex items-center justify-center p-1.5">
                <img src="{{ asset('images/logo.png') }}" alt="Almart Logo" class="w-full h-full object-contain">
            </div>
            <div>
                <h1 class="font-bold text-gray-900 text-lg leading-tight"><span class="text-pink-500">Almart</span> Dashboard</h1>
                <p class="text-[10px] text-gray-400 font-semibold tracking-wide uppercase">Staff Management System</p>
            </div>
        </div>

        <div class="flex items-center gap-6">
            {{-- Real-time Clock --}}
            <div class="hidden md:flex items-center gap-2.5 bg-white/50 backdrop-blur px-4 py-2 rounded-2xl border border-white/50 shadow-sm">
                <div class="w-2 h-2 rounded-full bg-pink-500 animate-pulse"></div>
                <span id="realtime-clock" class="text-sm font-black text-gray-700 tracking-[0.1em] tabular-nums">--:--:--</span>
            </div>

            {{-- Notification --}}
            <button class="relative text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                @if($countBaru > 0)
                <span class="absolute -top-1 -right-1 w-4 h-4 bg-pink-500 rounded-full border-2 border-white text-[9px] font-bold text-white flex items-center justify-center shadow-sm">
                    {{ $countBaru }}
                </span>
                @endif
            </button>

            {{-- User Profile & Clear Logout --}}
            <div class="flex items-center gap-2 md:gap-3">
                <div class="flex items-center gap-2 md:gap-3 bg-gray-50/50 pl-3 pr-2 py-1.5 rounded-full border border-gray-100">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-bold text-gray-800 leading-tight">{{ auth()->user()->name }}</p>
                        <p class="text-[9px] font-semibold text-gray-400 uppercase tracking-wider">Shift 1</p>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-pink-500 to-rose-400 text-white flex items-center justify-center font-bold text-sm shadow-md shadow-pink-200 shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>

                {{-- Dedicated Logout Button (No Hover Needed) --}}
                <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                    @csrf
                    <button type="submit" class="p-2 md:p-2.5 rounded-full bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition-all shadow-sm border border-rose-100 flex items-center justify-center" title="Keluar Sistem">
                        <svg class="w-5 h-5 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-6 mt-8">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-[1.5rem] shadow-sm animate-fade-in font-bold text-sm">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 flex items-center gap-3 bg-rose-50 border border-rose-200 text-rose-700 px-6 py-4 rounded-[1.5rem] shadow-sm animate-fade-in font-bold text-sm">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- TOP NAVIGATION TABS (Pills) --}}
        <div class="flex justify-center gap-4 mb-8">
            <a href="?tab=pesanan" class="px-8 py-3.5 rounded-full text-sm font-bold shadow-sm flex items-center gap-2 hover:-translate-y-0.5 transition-all duration-300 {{ $tab === 'pesanan' ? 'bg-gradient-to-r from-pink-500 to-rose-500 text-white shadow-pink-200' : 'bg-white text-gray-600 hover:bg-pink-50 border border-gray-100' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                Pesanan
                @if($countBaru > 0)
                    <span class="ml-1 px-2 py-0.5 text-[10px] bg-white text-pink-600 rounded-full shadow-sm">{{ $countBaru }}</span>
                @endif
            </a>
            <a href="?tab=picking" class="px-8 py-3.5 rounded-full text-sm font-bold shadow-sm flex items-center gap-2 hover:-translate-y-0.5 transition-all duration-300 {{ $tab === 'picking' ? 'bg-gradient-to-r from-pink-500 to-rose-500 text-white shadow-pink-200' : 'bg-white text-gray-600 hover:bg-pink-50 border border-gray-100' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                Picking
                @if($countDiproses > 0)
                    <span class="ml-1 px-2 py-0.5 text-[10px] bg-white text-pink-600 rounded-full shadow-sm">{{ $countDiproses }}</span>
                @endif
            </a>
            <a href="?tab=delivery" class="px-8 py-3.5 rounded-full text-sm font-bold shadow-sm flex items-center gap-2 hover:-translate-y-0.5 transition-all duration-300 {{ $tab === 'delivery' ? 'bg-gradient-to-r from-pink-500 to-rose-500 text-white shadow-pink-200' : 'bg-white text-gray-600 hover:bg-pink-50 border border-gray-100' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Delivery
                @if(($countDelivery + $countReadyForPickup) > 0)
                    <span class="ml-1 px-2 py-0.5 text-[10px] bg-white text-pink-600 rounded-full shadow-sm">{{ $countDelivery + $countReadyForPickup }}</span>
                @endif
            </a>
        </div>

        {{-- PRESTASI ANDA (PERSONAL STATS) --}}
        <div class="mb-10 animate-fade-in-up" style="animation-delay: 150ms;">
            <div class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 rounded-[2.5rem] p-8 shadow-2xl relative overflow-hidden border border-gray-700">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/dark-matter.png')] opacity-10"></div>
                <div class="absolute -right-20 -top-20 w-64 h-64 bg-pink-500/10 rounded-full blur-[80px]"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
                    <div class="flex-1 text-center md:text-left border-b md:border-b-0 md:border-r border-white/10 pb-6 md:pb-0 md:pr-8">
                        <div class="flex items-center justify-center md:justify-start gap-4 mb-2">
                            <div class="w-10 h-10 rounded-xl bg-pink-500/20 flex items-center justify-center border border-pink-500/30">
                                <i data-lucide="trophy" class="w-5 h-5 text-pink-400"></i>
                            </div>
                            <h3 class="text-xl font-black text-white tracking-tight">Prestasi Anda</h3>
                        </div>
                        <p class="text-gray-400 text-sm font-medium">Performa layanan Anda hari ini</p>
                    </div>

                    <div class="grid grid-cols-2 gap-8 flex-[2] w-full">
                        <div class="text-center group">
                            <p class="text-[10px] font-black text-pink-500 uppercase tracking-[0.2em] mb-1 group-hover:scale-110 transition-transform">Selesai Hari Ini</p>
                            <div class="flex items-center justify-center gap-2">
                                <span class="text-4xl font-black text-white tabular-nums tracking-tighter">{{ $pribadiSelesai }}</span>
                                <span class="px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400 text-[10px] font-bold border border-emerald-500/30">+{{ $pribadiSelesai > 0 ? '100' : '0' }}%</span>
                            </div>
                        </div>
                        <div class="text-center group border-l border-white/5">
                            <p class="text-[10px] font-black text-amber-500 uppercase tracking-[0.2em] mb-1 group-hover:scale-110 transition-transform">Sedang Ditangani</p>
                            <div class="flex items-center justify-center gap-2">
                                <span class="text-4xl font-black text-white tabular-nums tracking-tighter">{{ $pribadiAktif }}</span>
                                <span class="px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-400 text-[10px] font-bold border border-amber-500/30">Aktif</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 bg-white/5 px-6 py-4 rounded-2xl border border-white/10 backdrop-blur-md">
                        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse shadow-[0_0_10px_rgba(16,185,129,0.5)]"></div>
                        <p class="text-[11px] font-bold text-gray-300 uppercase tracking-widest">Sistem Online</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- MAIN CONTAINER --}}
        @if($tab === 'pesanan')
            @include('dashboards._pesanan_tab')
        @elseif($tab === 'picking')
            @include('dashboards._picking_tab')
        @elseif($tab === 'delivery')
            @include('dashboards._delivery_tab')
        @endif
    </div>
</div>

{{-- MODAL OVERLAY DETAIL --}}
<div id="detailModalPanel" class="fixed inset-0 z-50 bg-gray-900/40 backdrop-blur-sm hidden flex items-center justify-center p-4 transition-opacity opacity-0" onclick="closeDetailModal(event)">
    {{-- MODAL CONTENT CARRIER (AJAX Injected) --}}
    <div id="detailContentTarget" class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-6 transform scale-95 transition-transform" onclick="event.stopPropagation()">
        <!-- Content injected here via AJAX -->
        <div class="flex items-center justify-center h-48">
            <svg class="animate-spin text-pink-500 w-8 h-8" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmTerima(id, status = 'paid') {
        const isPending = status === 'pending';
        const title = isPending ? 'Verifikasi & Terima?' : 'Terima Pesanan?';
        const msg = isPending 
            ? 'Pastikan <span class="font-bold text-rose-500">Bukti Transfer</span> sudah sesuai sebelum memproses pesanan ini.' 
            : 'Pesanan akan dipindahkan ke status <span class="font-bold text-amber-500">"Sedang Diproses"</span> dan siap untuk dipicking.';

        Swal.fire({
            html: `
                <div class="text-left font-plus-jakarta pb-2">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">${title}</h3>
                    <p class="text-sm text-gray-500">${msg}</p>
                </div>
            `,
            showCancelButton: true,
            confirmButtonColor: '#ec4899', // pink-500
            cancelButtonColor: '#f3f4f6', // gray-100
            cancelButtonText: '<span class="text-gray-600 font-bold">Batal</span>',
            confirmButtonText: `<span class="font-bold text-white flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> Ya, ${isPending ? 'Verifikasi' : 'Terima'}</span>`,
            customClass: {
                popup: 'rounded-[2rem] p-4 shadow-2xl border border-gray-100',
                confirmButton: 'rounded-xl px-6 py-3',
                cancelButton: 'rounded-xl px-6 py-3 border border-gray-200'
            },
            buttonsStyling: true,
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-terima-' + id).submit();
            }
        });
    }

    function confirmTolak(id) {
        Swal.fire({
            title: 'Tolak & Batalkan Pesanan?',
            text: "Pelanggan akan mendapat notifikasi bahwa pesanannya ditolak.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f43f5e', // rose-500
            cancelButtonColor: '#f3f4f6',
            cancelButtonText: '<span class="text-gray-600 font-bold">Kembali</span>',
            confirmButtonText: '<span class="font-bold text-white">Ya, Tolak</span>',
            customClass: {
                popup: 'rounded-[2rem] shadow-2xl border border-gray-100 font-plus-jakarta',
                confirmButton: 'rounded-xl px-6 py-3',
                cancelButton: 'rounded-xl px-6 py-3 border border-gray-200'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-tolak-' + id).submit();
            }
        });
    }
    
    function confirmSelesai(id) {
        Swal.fire({
            title: 'Pesanan Selesai?',
            text: "Pesanan ini akan ditandai sukses terkirim.",
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#10b981', // emerald-500
            cancelButtonColor: '#f3f4f6',
            cancelButtonText: '<span class="text-gray-600 font-bold">Kembali</span>',
            confirmButtonText: '<span class="font-bold text-white">Selesaikan</span>',
            customClass: {
                popup: 'rounded-[2rem] shadow-2xl border border-gray-100 font-plus-jakarta',
                confirmButton: 'rounded-xl px-6 py-3',
                cancelButton: 'rounded-xl px-6 py-3 border border-gray-200'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-selesai-' + id).submit();
            }
        });
    }

    // Modal Logic
    const detailModalPanel = document.getElementById('detailModalPanel');
    const detailContentTarget = document.getElementById('detailContentTarget');

    function openDetailModal(orderId) {
        // Show Background
        detailModalPanel.classList.remove('hidden');
        // Animate fading in
        setTimeout(() => {
            detailModalPanel.classList.remove('opacity-0');
            detailContentTarget.classList.remove('scale-95');
        }, 10);
        
        // Show Loader
        detailContentTarget.innerHTML = `
            <div class="flex items-center justify-center h-64">
                <svg class="animate-spin text-pink-500 w-10 h-10" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        `;

        // Fetch HTML Fragment
        fetch(`/petugas/orders/${orderId}/detail`)
            .then(res => res.json())
            .then(data => {
                detailContentTarget.innerHTML = data.html;
            })
            .catch(err => {
                detailContentTarget.innerHTML = `<div class="text-center text-red-500 py-10 font-bold">Gagal memuat data!</div>`;
            });
    }

    function closeDetailModal(e) {
        if(e) e.preventDefault();
        
        detailModalPanel.classList.add('opacity-0');
        detailContentTarget.classList.add('scale-95');
        
        // Wait for transition before hiding completely
        setTimeout(() => {
            detailModalPanel.classList.add('hidden');
        }, 300); // 300ms matches Tailwind default transition timing
    }

    // FUNGSI PICKING (TAB PICKING)
    function openPickingDetail(orderId) {
        const targetTarget = document.getElementById('pickingContentTarget');
        
        // Update Card Styling di Kiri
        document.querySelectorAll('.picking-card').forEach(card => {
            card.classList.remove('border-pink-500', 'ring-2', 'ring-pink-200');
            card.classList.add('border-gray-100');
        });
        const activeCard = document.getElementById('picking-card-' + orderId);
        if(activeCard) {
            activeCard.classList.remove('border-gray-100');
            activeCard.classList.add('border-pink-500', 'ring-2', 'ring-pink-200');
        }

        // Tampilkan Loader di Kanan
        targetTarget.innerHTML = `
            <div class="flex items-center justify-center w-full h-full min-h-[400px]">
                <svg class="animate-spin text-pink-500 w-10 h-10" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        `;

        fetch(`/petugas/orders/${orderId}/picking-detail`)
            .then(res => res.json())
            .then(data => {
                targetTarget.innerHTML = data.html;
            })
            .catch(err => {
                targetTarget.innerHTML = '<div class="p-6 text-center text-red-500 font-bold">Gagal memuat data picking.</div>';
            });
    }

    window.updatePickingProgress = function(orderId, totalItems) {
        const checkboxes = document.querySelectorAll('.picking-checkbox-' + orderId);
        const checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
        
        const progressText = document.getElementById('progress-text-' + orderId);
        if(progressText) progressText.innerText = `${checkedCount}/${totalItems} item`;

        const progressBarTarget = document.getElementById('progress-bar-' + orderId);
        if(progressBarTarget) progressBarTarget.style.width = ((checkedCount / totalItems) * 100) + '%';
        
        const progressBarLeft = document.querySelector(`.progress-bar-${orderId}`);
        if(progressBarLeft) progressBarLeft.style.width = ((checkedCount / totalItems) * 100) + '%';
        
        const progressSummaryLeft = document.getElementById(`picking-summary-${orderId}`);
        if(progressSummaryLeft) progressSummaryLeft.innerText = `${checkedCount}/${totalItems} item`;

        const btnSelesai = document.getElementById('btn-selesai-' + orderId);
        if(btnSelesai) {
            if(checkedCount === totalItems) {
                btnSelesai.disabled = false;
                btnSelesai.classList.remove('cursor-not-allowed', 'bg-pink-100', 'text-pink-400');
                btnSelesai.classList.add('bg-gradient-to-r', 'from-pink-500', 'to-rose-500', 'text-white', 'hover:shadow-lg', 'hover:shadow-pink-200');
            } else {
                btnSelesai.disabled = true;
                btnSelesai.classList.add('cursor-not-allowed', 'bg-pink-100', 'text-pink-400');
                btnSelesai.classList.remove('bg-gradient-to-r', 'from-pink-500', 'to-rose-500', 'text-white', 'hover:shadow-lg', 'hover:shadow-pink-200');
            }
        }
    }

    function confirmSelesai(id) {
        Swal.fire({
            title: 'Selesaikan Pesanan?',
            text: "Pesanan akan ditandai sebagai Selesai/Terkirim.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#f3f4f6',
            cancelButtonText: '<span class="text-gray-600 font-bold">Batal</span>',
            confirmButtonText: '<span class="font-bold text-white flex items-center gap-2">Ya, Selesai</span>',
            customClass: {
                popup: 'rounded-[2rem] p-4 shadow-2xl border border-gray-100 font-plus-jakarta',
                confirmButton: 'rounded-xl px-6 py-3',
                cancelButton: 'rounded-xl px-6 py-3 border border-gray-200'
            },
            buttonsStyling: true,
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-selesai-' + id).submit();
            }
        });
    }

    // Laravel Echo Configuration for Reverb
    window.Pusher = Pusher;
    if (typeof Echo !== 'undefined') {
        window.Echo = new Echo({
            broadcaster: 'reverb',
            key: "{{ env('VITE_REVERB_APP_KEY') }}",
            wsHost: "{{ env('VITE_REVERB_HOST') }}",
            wsPort: "{{ env('VITE_REVERB_PORT') }}",
            wssPort: "{{ env('VITE_REVERB_PORT') }}",
            forceTLS: "{{ env('VITE_REVERB_SCHEME') }}" === 'https',
            enabledTransports: ['ws', 'wss'],
        });

        // Listen for Real-time Events
        window.Echo.channel('admin-notifications')
            .listen('.new-order', (e) => {
                console.log('New Order Received (Petugas):', e);
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'info',
                    title: `Ada Pesanan Baru: ${e.order.order_code}`,
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true
                });
            });
    }

    function confirmSelesaiPicking(id) {
        Swal.fire({
            title: 'Selesai Picking?',
            text: "Pesanan akan dipindahkan ke tahap pengiriman/siap ambil.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#f43f5e',
            cancelButtonColor: '#f3f4f6',
            cancelButtonText: '<span class="text-gray-600 font-bold">Batal</span>',
            confirmButtonText: '<span class="font-bold text-white flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> Ya, Selesai</span>',
            customClass: {
                popup: 'rounded-[2rem] p-4 shadow-2xl border border-gray-100 font-plus-jakarta',
                confirmButton: 'rounded-xl px-6 py-3',
                cancelButton: 'rounded-xl px-6 py-3 border border-gray-200'
            },
            buttonsStyling: true,
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-selesai-picking-' + id).submit();
            }
        });
    }

    // Timer untuk SLA (Service Level Agreement)
    function updateSLATickers() {
        const badges = document.querySelectorAll('.sla-badge');
        const now = new Date();

        badges.forEach(badge => {
            const createdAt = new Date(badge.getAttribute('data-created-at'));
            const diffMs = now - createdAt;
            const diffMins = Math.floor(diffMs / 60000);
            
            const dot = badge.querySelector('span:first-child');
            const text = badge.querySelector('.sla-text');

            if (diffMins < 15) {
                badge.className = "sla-badge flex items-center gap-1.5 px-2 py-0.5 rounded-md border text-[9px] font-black uppercase tracking-tighter bg-blue-50 text-blue-500 border-blue-100";
                dot.className = "w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse";
                text.innerText = "NORMAL SLA (" + diffMins + "m)";
            } else if (diffMins < 30) {
                badge.className = "sla-badge flex items-center gap-1.5 px-2 py-0.5 rounded-md border text-[9px] font-black uppercase tracking-tighter bg-amber-50 text-amber-500 border-amber-100 animate-pulse";
                dot.className = "w-1.5 h-1.5 rounded-full bg-amber-400 animate-bounce";
                text.innerText = "HIGH URGENCY (" + diffMins + "m)";
            } else {
                badge.className = "sla-badge flex items-center gap-1.5 px-2 py-0.5 rounded-md border text-[9px] font-black uppercase tracking-tighter bg-rose-500 text-white border-rose-600 animate-bounce";
                dot.className = "w-1.5 h-1.5 rounded-full bg-white shadow-[0_0_10px_white]";
                text.innerText = "CRITICAL SLA (" + diffMins + "m)";
            }
        });
    }

    // Jalankan setiap menit
    setInterval(updateSLATickers, 60000);
    // Jalankan pertama kali saat load
    document.addEventListener('DOMContentLoaded', updateSLATickers);
</script>
@endauth
@endsection