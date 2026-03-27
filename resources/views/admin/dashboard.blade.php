@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="space-y-8 pb-10">

    <!-- TITLE SECTION -->
    <div class="flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-gray-900 font-plus-jakarta">Dashboard Overview</h1>
            <p class="text-sm text-gray-500 mt-1 flex items-center gap-2">
                Pantau kinerja toko Anda secara real-time
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                </span>
            </p>
        </div>
        <div class="hidden md:block">
            <!-- Add any global filters or date range pickers here if needed -->
        </div>
    </div>

    <!-- STATS CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Card: Total Transaksi -->
        <div class="bg-white p-6 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-50 flex justify-between items-start transition-all duration-300 hover:shadow-[0_20px_40px_rgba(59,130,246,0.08)] hover:-translate-y-1 group">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Transaksi Hari Ini</p>
                <h2 id="stats-total-orders" class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalOrdersToday) }}</h2>
                <div class="flex items-center gap-1 mt-2 text-green-500 font-semibold text-xs transition-transform group-hover:translate-x-1">
                    <i data-lucide="trending-up" class="w-3 h-3"></i>
                    <span>Terkini</span>
                </div>
            </div>
            <div class="p-3 bg-blue-500 rounded-2xl text-white shadow-lg shadow-blue-200 transition-transform group-hover:rotate-12">
                <i data-lucide="shopping-cart" class="w-6 h-6"></i>
            </div>
        </div>

        <!-- Card: Total Pendapatan -->
        <div class="bg-white p-6 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-50 flex justify-between items-start transition-all duration-300 hover:shadow-[0_20px_40px_rgba(16,185,129,0.08)] hover:-translate-y-1 group">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Pendapatan</p>
                <h2 id="stats-total-revenue" class="text-3xl font-bold text-gray-900 mt-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
                <div class="flex items-center gap-1 mt-2 text-emerald-500 font-semibold text-xs transition-transform group-hover:translate-x-1">
                    <i data-lucide="wallet" class="w-3 h-3"></i>
                    <span>Sukses</span>
                </div>
            </div>
            <div class="p-3 bg-emerald-500 rounded-2xl text-white shadow-lg shadow-emerald-200 transition-transform group-hover:rotate-12">
                <i data-lucide="bar-chart-3" class="w-6 h-6"></i>
            </div>
        </div>

        <!-- Card: Produk Tersedia -->
        <div class="bg-white p-6 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-50 flex justify-between items-start transition-all duration-300 hover:shadow-[0_20px_40px_rgba(249,115,22,0.08)] hover:-translate-y-1 group">
            <div>
                <p class="text-sm font-medium text-gray-500">Produk Tersedia</p>
                <h2 class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalProducts) }}</h2>
                <div class="flex items-center gap-1 mt-2 text-blue-500 font-semibold text-xs transition-transform group-hover:translate-x-1">
                    <i data-lucide="check-circle" class="w-3 h-3"></i>
                    <span>Aktif</span>
                </div>
            </div>
            <div class="p-3 bg-orange-500 rounded-2xl text-white shadow-lg shadow-orange-200 transition-transform group-hover:rotate-12">
                <i data-lucide="package" class="w-6 h-6"></i>
            </div>
        </div>

        <!-- Card: Total Member -->
        <div class="bg-white p-6 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-50 flex justify-between items-start transition-all duration-300 hover:shadow-[0_20px_40px_rgba(168,85,247,0.08)] hover:-translate-y-1 group">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Member</p>
                <h2 class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalMembers) }}</h2>
                <div class="flex items-center gap-1 mt-2 text-purple-500 font-semibold text-xs transition-transform group-hover:translate-x-1">
                    <i data-lucide="users" class="w-3 h-3"></i>
                    <span>Pelanggan</span>
                </div>
            </div>
            <div class="p-3 bg-purple-500 rounded-2xl text-white shadow-lg shadow-purple-200 transition-transform group-hover:rotate-12">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
        </div>

    </div>

    <!-- MAIN CHARTS SECTION -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Weekly Transactions Chart -->
        <div class="lg:col-span-2 bg-white p-8 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-50">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Transaksi Mingguan</h3>
            <div class="h-[300px] relative">
                <canvas id="weeklyChart"></canvas>
            </div>
            <div class="flex justify-center gap-6 mt-6">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                    <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Online</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                    <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Offline</span>
                </div>
            </div>
        </div>

        <!-- Monthly Orders Chart -->
        <div class="bg-white p-8 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-50">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Pesanan Bulanan</h3>
            <div class="h-[300px] relative">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>

    </div>

    <!-- BOTTOM SECTION: STATUS & RECENT TRANSACTIONS -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Shipping Status Donut Chart -->
        <div class="lg:col-span-4 bg-white p-8 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-50">
            <h3 class="text-lg font-bold text-gray-900 mb-6 flex justify-between items-center">
                <span>Status Pengiriman (SAPA)</span>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black bg-blue-50 text-blue-600 uppercase tracking-widest shadow-sm">Realtime</span>
            </h3>
            <div class="h-[240px] relative flex justify-center items-center drop-shadow-md transition-transform hover:scale-105 duration-300">
                <canvas id="statusChart"></canvas>
                <!-- Central Text Overlay -->
                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none mt-2 transition-all">
                    <span id="donut-total" class="text-5xl font-black text-gray-900 leading-tight transition-transform duration-500">{{ array_sum($statusCounts) }}</span>
                    <span class="text-[10px] font-black text-gray-400 mt-2 uppercase tracking-widest bg-gray-50 px-3 py-1 rounded-full border border-gray-100 shadow-inner">Total</span>
                </div>
            </div>
            <div class="mt-8 space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                        <span class="text-sm font-medium text-gray-600">Terkirim</span>
                    </div>
                    <span id="donut-terkirim" class="text-sm font-bold text-gray-900 tracking-tight">{{ $statusCounts['Terkirim'] }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-orange-500"></div>
                        <span class="text-sm font-medium text-gray-600">Dalam Proses</span>
                    </div>
                    <span id="donut-proses" class="text-sm font-bold text-gray-900 tracking-tight">{{ $statusCounts['Dalam Proses'] }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-rose-500"></div>
                        <span class="text-sm font-medium text-gray-600">Pending</span>
                    </div>
                    <span id="donut-pending" class="text-sm font-bold text-gray-900 tracking-tight">{{ $statusCounts['Pending'] }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-gray-400"></div>
                        <span class="text-sm font-medium text-gray-600">Dibatalkan</span>
                    </div>
                    <span id="donut-batal" class="text-sm font-bold text-gray-900 tracking-tight">{{ $statusCounts['Dibatalkan'] }}</span>
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="lg:col-span-8 bg-white p-8 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-50 flex flex-col">
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-lg font-bold text-gray-900">Transaksi Terbaru</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-rose-500 text-sm font-bold hover:text-rose-600 transition-colors uppercase tracking-widest leading-none">Lihat Semua</a>
            </div>

            <div id="recent-transactions-list" class="space-y-6 flex-1">
                @forelse($recentTransactions as $order)
                <div class="flex items-center justify-between group cursor-pointer hover:bg-gray-50/50 p-2 -m-2 rounded-2xl transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center font-bold text-lg">
                            {{ strtoupper(substr($order->customer->name ?? 'U', 0, 2)) }}
                        </div>
                        <div>
                            <p class="text-base font-bold text-gray-900 leading-tight">{{ $order->customer->name ?? 'Guest' }}</p>
                            <p class="text-xs font-semibold text-gray-400 mt-1 uppercase tracking-wider">{{ $order->order_code }} • {{ $order->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-base font-extrabold text-gray-900">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                        @php
                            $statusColor = 'bg-gray-100 text-gray-600';
                            if (in_array($order->status, ['Baru'])) $statusColor = 'bg-blue-100 text-blue-600';
                            elseif (in_array($order->status, ['Dibatalkan'])) $statusColor = 'bg-rose-100 text-rose-600';
                            elseif (in_array($order->status, ['Diterima'])) $statusColor = 'bg-emerald-100 text-emerald-600';
                            else $statusColor = 'bg-orange-100 text-orange-600';
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-extrabold {{ $statusColor }} mt-1 uppercase tracking-widest">
                            {{ $order->status }}
                        </span>
                    </div>
                </div>
                @empty
                    <p class="text-gray-400 text-sm text-center items-center py-6 block font-medium">Belum ada transaksi</p>
                @endforelse
            </div>
        </div>

    </div>

</div>

<!-- CHARTS INITIALIZATION -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof ChartDataLabels !== 'undefined') {
            Chart.register(ChartDataLabels);
        }
        window.updateDashboardStats = function(order) {
            // Update Total Orders counter (simple increment)
            const el = document.getElementById('stats-total-orders');
            if (el) {
                let current = parseInt(el.innerText.replace(/\./g, ''));
                el.innerText = (current + 1).toLocaleString('id-ID');
                el.classList.add('scale-110', 'text-emerald-600');
                setTimeout(() => el.classList.remove('scale-110', 'text-emerald-600'), 1000);
            }
            
            // Also bump Revenue slightly (assumes we just add the order total for now, though it's technically still 'Baru' not 'Sukses', but for real-time visual it's fine or we just leave revenue until status updates)
            // Revenue only counts "Diterima / Dikirim" dynamically, it's better to update via pusher when status changes. Let's omit revenue update on 'new-order'.

            // Prepend to Recent Transactions list
            const list = document.getElementById('recent-transactions-list');
            const noTransactionText = list.querySelector('p.text-center');
            if (noTransactionText) noTransactionText.remove();
            
            if (list) {
                const newItem = document.createElement('div');
                newItem.className = 'flex items-center justify-between group cursor-pointer hover:bg-gray-50/50 p-2 -m-2 rounded-2xl transition-all animate-pulse';
                newItem.innerHTML = `
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center font-bold text-lg">
                            ${order.customer.name.substring(0, 2).toUpperCase()}
                        </div>
                        <div>
                            <p class="text-base font-bold text-gray-900 leading-tight">${order.customer.name}</p>
                            <p class="text-xs font-semibold text-gray-400 mt-1 uppercase tracking-wider">${order.order_code} • Baru Saja</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-base font-extrabold text-gray-900">Rp ${new Intl.NumberFormat('id-ID').format(order.total)}</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-blue-100 text-blue-600 mt-1 uppercase tracking-widest">Baru</span>
                    </div>
                `;
                list.prepend(newItem);
                if (list.children.length > 5) {
                    list.removeChild(list.lastChild);
                }
                setTimeout(() => newItem.classList.remove('animate-pulse'), 3000);
            }
            
            // Additionally increment 'Pending' Donut Chart counter
            const pendingEl = document.getElementById('donut-pending');
            if (pendingEl) pendingEl.innerText = parseInt(pendingEl.innerText) + 1;

            // Increment Total in the Center of Donut Chart
            const donutTotalEl = document.getElementById('donut-total');
            if (donutTotalEl) {
                donutTotalEl.innerText = parseInt(donutTotalEl.innerText) + 1;
                donutTotalEl.classList.add('scale-125', 'text-blue-600');
                setTimeout(() => donutTotalEl.classList.remove('scale-125', 'text-blue-600'), 1000);
            }
        };

        // Shared colors
        const colors = {
            emerald: '#10b981',
            blue: '#3b82f6',
            orange: '#f59e0b',
            rose: '#f43f5e',
            gray: '#94a3b8'
        };

        // Shared chart options
        const sharedOptions = {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 2000,
                easing: 'easeOutQuart'
            },
            plugins: {
                legend: { display: false },
                datalabels: { display: false }, // Disable by default for all charts
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    titleColor: '#1e293b',
                    bodyColor: '#64748b',
                    borderColor: '#f1f5f9',
                    borderWidth: 1,
                    padding: 12,
                    boxPadding: 6,
                    usePointStyle: true,
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 12 },
                    cornerRadius: 12,
                    displayColors: true
                }
            }
        };

        // Weekly Transaction Chart (Line)
        const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
        new Chart(weeklyCtx, {
            type: 'line',
            data: {
                labels: @json($weeklyLabels),
                datasets: [
                    {
                        label: 'Pesanan',
                        data: @json($weeklyData),
                        borderColor: colors.emerald,
                        backgroundColor: (context) => {
                            const chart = context.chart;
                            const {ctx, chartArea} = chart;
                            if (!chartArea) return null;
                            const gradient = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                            gradient.addColorStop(0, 'rgba(16, 185, 129, 0.1)');
                            gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');
                            return gradient;
                        },
                        fill: true,
                        borderWidth: 3,
                        tension: 0.4,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: colors.emerald,
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 3,
                    }
                ]
            },
            options: {
                ...sharedOptions,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f8fafc',
                            drawTicks: false
                        },
                        border: { display: false },
                        ticks: {
                            stepSize: 2000,
                            padding: 10,
                            color: '#94a3b8',
                            font: { weight: '600', family: "'Plus Jakarta Sans'" }
                        }
                    },
                    x: {
                        grid: { display: false },
                        border: { display: false },
                        ticks: {
                            padding: 10,
                            color: '#94a3b8',
                            font: { weight: '600', family: "'Plus Jakarta Sans'" }
                        }
                    }
                }
            }
        });

        // Monthly Order Chart (Bar)
        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        const barGradient = monthlyCtx.createLinearGradient(0, 0, 0, 300);
        barGradient.addColorStop(0, '#3b82f6');
        barGradient.addColorStop(1, '#60a5fa33');

        new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    data: @json($monthlyData),
                    backgroundColor: barGradient,
                    hoverBackgroundColor: '#3b82f6',
                    borderRadius: 12,
                    barThickness: 24,
                }]
            },
            options: {
                ...sharedOptions,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { display: false },
                        border: { display: false },
                        ticks: {
                            stepSize: 250,
                            color: '#94a3b8',
                            font: { weight: '600', family: "'Plus Jakarta Sans'" }
                        }
                    },
                    x: {
                        grid: { display: false },
                        border: { display: false },
                        ticks: {
                            color: '#94a3b8',
                            font: { weight: '600', family: "'Plus Jakarta Sans'" }
                        }
                    }
                }
            }
        });

        // Shipping Status Chart (Donut)
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        
        // Buat gradient dinamis untuk membuat tampilannya lebih modern (Glow Effect)
        const emeraldGradient = statusCtx.createLinearGradient(0, 0, 0, 300);
        emeraldGradient.addColorStop(0, '#10b981');
        emeraldGradient.addColorStop(1, '#34d399');
        
        const orangeGradient = statusCtx.createLinearGradient(0, 0, 0, 300);
        orangeGradient.addColorStop(0, '#f59e0b');
        orangeGradient.addColorStop(1, '#fbbf24');
        
        const roseGradient = statusCtx.createLinearGradient(0, 0, 0, 300);
        roseGradient.addColorStop(0, '#f43f5e');
        roseGradient.addColorStop(1, '#fb7185');

        const grayGradient = statusCtx.createLinearGradient(0, 0, 0, 300);
        grayGradient.addColorStop(0, '#94a3b8');
        grayGradient.addColorStop(1, '#cbd5e1');

        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Terkirim', 'Dalam Proses', 'Pending', 'Dibatalkan'],
                datasets: [{
                    data: [
                        {{ $statusCounts['Terkirim'] }},
                        {{ $statusCounts['Dalam Proses'] }},
                        {{ $statusCounts['Pending'] }},
                        {{ $statusCounts['Dibatalkan'] }}
                    ],
                    backgroundColor: [emeraldGradient, orangeGradient, roseGradient, grayGradient],
                    hoverBackgroundColor: [colors.emerald, colors.orange, colors.rose, colors.gray],
                    borderWidth: 4,
                    borderColor: '#ffffff',
                    hoverOffset: 15,
                    borderRadius: 15,
                    radius: '95%',
                }]
            },
            options: {
                ...sharedOptions,
                cutout: '80%',
                layout: {
                    padding: { top: 15, bottom: 15, left: 15, right: 15 }
                },
                plugins: {
                    ...sharedOptions.plugins,
                    tooltip: {
                        ...sharedOptions.plugins.tooltip,
                        backgroundColor: 'rgba(255, 255, 255, 0.98)',
                        titleColor: '#1e293b',
                        bodyColor: '#64748b',
                        borderColor: '#e2e8f0',
                        borderWidth: 1,
                        boxShadow: '0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1)',
                        callbacks: {
                            label: (item) => ` ${item.label} : ${item.raw} Pesanan`
                        }
                    },
                    datalabels: {
                        display: false // Mematikan datalabels untuk tampilan clean minimalism
                    }
                }
            }
        });
    });
</script>

@endsection