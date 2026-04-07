@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#f43f5e',
            timer: 3000,
            timerProgressBar: true,
            showClass: { popup: 'animate__animated animate__fadeInDown' },
            hideClass: { popup: 'animate__animated animate__fadeOutUp' }
        });
    });
</script>
@endif

<div class="space-y-8 pb-10">

    <!-- TITLE SECTION -->
    <div class="flex justify-between items-end animate-fade-in">
        <div>
            <h1 class="text-4xl font-black tracking-tight text-gray-900 font-plus-jakarta italic">Almart <span class="text-rose-600">Insight</span></h1>
            <p class="text-xs text-gray-400 font-bold uppercase tracking-[0.3em] mt-2 flex items-center gap-2">
                Real-time Analytics Dashboard
                <span class="flex h-1.5 w-1.5 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-rose-500"></span>
                </span>
            </p>
        </div>
        <div class="hidden md:block">
            <div class="flex items-center gap-3 px-5 py-3 bg-white border border-gray-100 rounded-[2rem] shadow-sm">
                <i data-lucide="calendar" class="w-4 h-4 text-rose-500"></i>
                <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest">
                    {{ now()->translatedFormat('l, d F Y') }}
                </span>
            </div>
        </div>
    </div>

    <!-- STATS CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 animate-slide-up">

        <!-- Card: Total Transaksi -->
        <div class="bg-white p-7 rounded-[3rem] shadow-[0_20px_50px_rgba(0,0,0,0.02)] border border-gray-100 flex justify-between items-start transition-all duration-700 hover:shadow-[0_40px_80px_rgba(244,63,94,0.12)] hover:-translate-y-3 group overflow-hidden relative">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-rose-50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
            <div class="relative z-10">
                <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Total Orders</p>
                <h2 id="stats-total-orders" class="text-4xl font-black text-gray-900 tracking-tighter">{{ number_format($totalOrders) }}</h2>
                <div class="mt-4 flex items-center gap-2">
                    <span class="px-2 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-emerald-100 group-hover:scale-110 transition-transform">Live Update</span>
                </div>
            </div>
            <div class="p-5 bg-rose-500 rounded-[2rem] text-white shadow-2xl shadow-rose-200 group-hover:rotate-12 transition-all duration-700 animate-float relative z-10">
                <i data-lucide="shopping-cart" class="w-6 h-6"></i>
            </div>
        </div>

        <!-- Card: Total Pendapatan -->
        <div class="bg-white p-7 rounded-[3rem] shadow-[0_20px_50px_rgba(0,0,0,0.02)] border border-gray-100 flex justify-between items-start transition-all duration-700 hover:shadow-[0_40px_80px_rgba(16,185,129,0.12)] hover:-translate-y-3 group overflow-hidden relative">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-emerald-50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
            <div class="relative z-10">
                <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Gross Revenue</p>
                <h2 class="text-3xl font-black text-gray-900 tracking-tighter">Rp {{ number_format($totalRevenue/1000, 0) }}k</h2>
                <div class="mt-4 flex items-center gap-2">
                    <span class="px-2 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-emerald-100 group-hover:scale-110 transition-transform">+{{ number_format(count($recentTransactions)) }} New</span>
                </div>
            </div>
            <div class="p-5 bg-emerald-500 rounded-[2rem] text-white shadow-2xl shadow-emerald-200 group-hover:rotate-12 transition-all duration-700 animate-float-delayed relative z-10">
                <i data-lucide="banknote" class="w-6 h-6"></i>
            </div>
        </div>

        <!-- Card: Produk Tersedia -->
        <div class="bg-white p-7 rounded-[3rem] shadow-[0_20px_50px_rgba(0,0,0,0.02)] border border-gray-100 flex justify-between items-start transition-all duration-700 hover:shadow-[0_40px_80px_rgba(245,158,11,0.12)] hover:-translate-y-3 group overflow-hidden relative">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-orange-50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
            <div class="relative z-10">
                <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Inventories</p>
                <h2 class="text-4xl font-black text-gray-900 tracking-tighter">{{ number_format($totalProducts) }}</h2>
                <div class="mt-4 flex items-center gap-2">
                    <span class="px-2 py-1 bg-rose-50 text-rose-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-rose-100 group-hover:scale-110 transition-transform">Ready</span>
                </div>
            </div>
            <div class="p-5 bg-orange-500 rounded-[2rem] text-white shadow-2xl shadow-orange-200 group-hover:rotate-12 transition-all duration-700 animate-float relative z-10">
                <i data-lucide="package" class="w-6 h-6"></i>
            </div>
        </div>

        <!-- Card: Total Member -->
        <div class="bg-white p-7 rounded-[3rem] shadow-[0_20px_50px_rgba(0,0,0,0.02)] border border-gray-100 flex justify-between items-start transition-all duration-700 hover:shadow-[0_40px_80px_rgba(168,85,247,0.12)] hover:-translate-y-3 group overflow-hidden relative">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-purple-50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
            <div class="relative z-10">
                <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Total Users</p>
                <h2 class="text-4xl font-black text-gray-900 tracking-tighter">{{ number_format($totalMembers) }}</h2>
                <div class="mt-4 flex items-center gap-2">
                    <span class="px-2 py-1 bg-purple-50 text-purple-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-purple-100 group-hover:scale-110 transition-transform">Customers</span>
                </div>
            </div>
            <div class="p-5 bg-purple-500 rounded-[2rem] text-white shadow-2xl shadow-purple-200 group-hover:rotate-12 transition-all duration-700 animate-float-delayed relative z-10">
                <i data-lucide="user-check" class="w-6 h-6"></i>
            </div>
        </div>

    </div>

    <!-- MAIN CHARTS SECTION -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 animate-slide-up" style="animation-delay: 0.1s">

        <!-- Weekly Transactions Chart -->
        <div class="lg:col-span-2 bg-white p-10 rounded-[4rem] shadow-[0_32px_64px_-16px_rgba(0,0,0,0.03)] border border-gray-100 relative group overflow-hidden">
             <div class="absolute -right-20 -top-20 w-60 h-60 bg-rose-50/50 rounded-full blur-3xl transition-colors group-hover:bg-rose-100/50 duration-1000"></div>
             
             <div class="relative z-10">
                <div class="flex items-center justify-between mb-10">
                    <div>
                        <h3 class="text-2xl font-black text-gray-900 tracking-tight leading-none">Vomume Transaksi</h3>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mt-3">Monitoring harian 7 hari terakhir</p>
                    </div>
                </div>
                <div class="h-[350px] relative">
                    <canvas id="weeklyChart"></canvas>
                </div>
             </div>
        </div>

        <!-- Monthly Orders Chart -->
        <div class="bg-white p-10 rounded-[4rem] shadow-[0_32px_64px_-16px_rgba(0,0,0,0.03)] border border-gray-100 relative overflow-hidden group">
            <h3 class="text-2xl font-black text-gray-900 tracking-tight leading-none mb-10 relative z-10">Performa Tahunan</h3>
            <div class="h-[350px] relative z-10">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>

    </div>

    <!-- BOTTOM SECTION -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 animate-slide-up" style="animation-delay: 0.2s">

        <!-- Shipping Status -->
        <div class="lg:col-span-4 bg-white p-10 rounded-[4rem] shadow-[0_32px_64px_-16px_rgba(0,0,0,0.03)] border border-gray-100 flex flex-col relative overflow-hidden">
            <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-rose-50/30 rounded-full blur-2xl"></div>
            
            <h3 class="text-xl font-black text-gray-900 mb-10 flex justify-between items-center relative z-10">
                <span>Status SAPA</span>
                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[9px] font-black bg-rose-500 text-white uppercase tracking-widest shadow-xl shadow-rose-100 transition-transform hover:scale-110">Live Tracker</span>
            </h3>
            
            <div class="h-[280px] relative flex justify-center items-center scale-110 relative z-10">
                <canvas id="statusChart"></canvas>
                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                    <span id="donut-total" class="text-5xl font-black text-gray-900 leading-none tracking-tighter">{{ array_sum($statusCounts) }}</span>
                    <span class="text-[9px] font-black text-gray-400 mt-3 uppercase tracking-widest bg-white px-3 py-1 rounded-full shadow-sm border border-gray-50">Total Orders</span>
                </div>
            </div>

            <div class="mt-12 space-y-3 relative z-10">
                <div class="p-5 bg-gray-50/80 backdrop-blur-sm rounded-[2rem] border border-white flex items-center justify-between group hover:bg-emerald-50 hover:border-emerald-100 transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_10px_#10b981]"></div>
                        <span class="text-[10px] font-black text-gray-400 group-hover:text-emerald-600 uppercase tracking-widest transition-colors tracking-tight">Selesai Dikirim</span>
                    </div>
                    <span class="text-xl font-black text-gray-900 group-hover:text-emerald-700 transition-colors">{{ $statusCounts['Terkirim'] }}</span>
                </div>
                <div class="p-5 bg-gray-50/80 backdrop-blur-sm rounded-[2rem] border border-white flex items-center justify-between group hover:bg-orange-50 hover:border-orange-100 transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-2 h-2 rounded-full bg-orange-500 shadow-[0_0_10px_#f59e0b]"></div>
                        <span class="text-[10px] font-black text-gray-400 group-hover:text-orange-600 uppercase tracking-widest transition-colors tracking-tight">Dalam Antrean</span>
                    </div>
                    <span class="text-xl font-black text-gray-900 group-hover:text-orange-700 transition-colors">{{ $statusCounts['Dalam Proses'] }}</span>
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="lg:col-span-8 bg-white p-12 rounded-[4rem] shadow-[0_32px_64px_-16px_rgba(0,0,0,0.03)] border border-gray-100 flex flex-col">
            <div class="flex justify-between items-center mb-12">
                <div>
                    <h3 class="text-3xl font-black text-gray-900 tracking-tight leading-none">Arus Transaksi</h3>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-[0.2em] mt-3">Monitoring 5 Aktivitas Terbaru</p>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="group flex items-center gap-3 px-8 py-4 bg-gray-900 text-white rounded-[1.8rem] text-[10px] font-black uppercase tracking-widest hover:bg-rose-500 hover:-translate-x-1 transition-all duration-500 shadow-xl shadow-gray-200">
                    View Master List
                    <i data-lucide="external-link" class="w-3 h-3 text-rose-400 group-hover:text-white transition-colors"></i>
                </a>
            </div>

            <div id="recent-transactions-list" class="space-y-6 flex-1">
                @forelse($recentTransactions as $order)
                <div class="flex items-center justify-between group p-4 hover:bg-gray-50/80 rounded-[2.5rem] transition-all duration-500 border border-transparent hover:border-gray-100">
                    <div class="flex items-center gap-6">
                        <div class="w-16 h-16 bg-white text-rose-600 rounded-[1.8rem] flex items-center justify-center font-black text-2xl shadow-[0_10px_30px_rgba(0,0,0,0.04)] border border-gray-50 group-hover:scale-110 group-hover:bg-rose-500 group-hover:text-white transition-all duration-500">
                            {{ strtoupper(substr($order->customer->name ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-xl font-black text-gray-900 leading-tight group-hover:text-rose-600 transition-colors">{{ $order->customer->name ?? 'Guest' }}</p>
                            <div class="flex items-center gap-3 mt-2">
                                <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest bg-gray-100 px-3 py-1 rounded-lg">{{ $order->order_code }}</span>
                                <span class="text-[9px] font-bold text-gray-300 italic">{{ $order->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-black text-gray-900 tracking-tighter">Rp {{ number_format($order->total/1000, 0) }}k</p>
                        @php
                            $statusColor = 'bg-gray-100 text-gray-400';
                            $displayStatus = ucfirst($order->status);
                            if (in_array($order->status, ['pending'])) { $statusColor = 'bg-rose-50 text-rose-500'; $displayStatus = 'Baru'; }
                            elseif (in_array($order->status, ['cancelled'])) { $statusColor = 'bg-gray-50 text-gray-300'; $displayStatus = 'Batal'; }
                            elseif (in_array($order->status, ['delivered'])) { $statusColor = 'bg-emerald-50 text-emerald-600'; $displayStatus = 'Finish'; }
                            elseif (in_array($order->status, ['paid', 'processing','picking','delivering','ready_for_pickup'])) { $statusColor = 'bg-orange-50 text-orange-500'; $displayStatus = 'Proses'; }
                        @endphp
                        <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-[9px] font-black {{ $statusColor }} mt-3 uppercase tracking-widest shadow-sm">
                            ● {{ $displayStatus }}
                        </span>
                    </div>
                </div>
                @empty
                    <div class="py-24 text-center">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i data-lucide="inbox" class="w-8 h-8 text-gray-200"></i>
                        </div>
                        <p class="text-gray-300 text-[10px] font-black uppercase tracking-[0.4em]">Empty Orders Record</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</div>

<style>
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes slideUp { from { opacity: 0; transform: translateY(50px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-8px); } }
    .animate-fade-in { animation: fadeIn 0.8s ease-out; }
    .animate-slide-up { animation: slideUp 1s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    .animate-float { animation: float 4s ease-in-out infinite; }
    .animate-float-delayed { animation: float 4s ease-in-out infinite; animation-delay: 2s; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();

        // SHARED THEME COLORS
        const theme = {
            rose: '#f43f5e',
            emerald: '#10b981',
            orange: '#f59e0b',
            purple: '#a855f7',
            gray: '#e2e8f0',
            textGray: '#94a3b8'
        };

        // WEEKLY CHART (LINE GLOW EFFECT)
        const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
        
        // Shadow configuration for the glow
        weeklyCtx.shadowBlur = 15;
        weeklyCtx.shadowOffsetX = 0;
        weeklyCtx.shadowOffsetY = 10;
        weeklyCtx.shadowColor = 'rgba(244, 63, 94, 0.4)';

        const weeklyGradient = weeklyCtx.createLinearGradient(0, 0, 0, 350);
        weeklyGradient.addColorStop(0, 'rgba(244, 63, 94, 0.2)');
        weeklyGradient.addColorStop(1, 'rgba(244, 63, 94, 0)');

        new Chart(weeklyCtx, {
            type: 'line',
            data: {
                labels: @json($weeklyLabels),
                datasets: [{
                    label: 'Orders',
                    data: @json($weeklyData),
                    borderColor: theme.rose,
                    backgroundColor: weeklyGradient,
                    fill: true,
                    borderWidth: 6,
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 10,
                    pointHoverBackgroundColor: theme.rose,
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 5,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { display: false },
                    tooltip: {
                         backgroundColor: '#111827',
                         padding: 15,
                         cornerRadius: 20,
                         titleFont: { weight: 'black', size: 12 },
                         bodyFont: { weight: 'bold', size: 14 },
                         displayColors: false,
                         callbacks: {
                             label: (ctx) => ` ${ctx.formattedValue} Transaksi`
                         }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f3f4f6', drawTicks: false },
                        border: { display: false },
                        ticks: { color: '#cbd5e1', font: { weight: 'black', size: 10 }, padding: 15 }
                    },
                    x: {
                        grid: { display: false },
                        border: { display: false },
                        ticks: { color: '#cbd5e1', font: { weight: 'black', size: 10 }, padding: 15 }
                    }
                }
            }
        });

        // MONTHLY CHART (BAR WITH GRADIENT)
        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        const monthlyGradient = monthlyCtx.createLinearGradient(0, 0, 0, 350);
        monthlyGradient.addColorStop(0, theme.rose);
        monthlyGradient.addColorStop(1, '#ffedd5');

        new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    data: @json($monthlyData),
                    backgroundColor: monthlyGradient,
                    hoverBackgroundColor: theme.rose,
                    borderRadius: 20,
                    barThickness: 14,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { display: false }, border: { display: false }, ticks: { display: false } },
                    x: { grid: { display: false }, border: { display: false }, ticks: { color: '#cbd5e1', font: { weight: 'bold', size: 9 }, padding: 10 } }
                }
            }
        });

        // STATUS CHART (MINIMALIST DONUT)
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Selesai', 'Proses', 'Pending', 'Batal'],
                datasets: [{
                    data: [{{ $statusCounts['Terkirim'] }}, {{ $statusCounts['Dalam Proses'] }}, {{ $statusCounts['Pending'] }}, {{ $statusCounts['Dibatalkan'] }}],
                    backgroundColor: [theme.emerald, theme.orange, theme.rose, theme.gray],
                    borderWidth: 0,
                    borderRadius: 20,
                    spacing: 15,
                    cutout: '88%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { display: false },
                    tooltip: {
                         backgroundColor: '#ffffff',
                         bodyColor: '#1f2937',
                         padding: 12,
                         cornerRadius: 15,
                         borderColor: '#f3f4f6',
                         borderWidth: 1,
                         bodyFont: { weight: 'black', size: 12 }
                    }
                }
            }
        });
    });
</script>
@endsection