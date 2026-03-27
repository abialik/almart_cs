<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title')</title>
    @vite(['resources/css/app.css'])
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/pusher-js@8.3.0/dist/web/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800 antialiased">

<div class="flex min-h-screen">

    <!-- ================= SIDEBAR ================= -->
    <aside id="adminSidebar" class="w-64 flex-shrink-0 bg-white border-r border-gray-200 shadow-sm flex flex-col transition-all duration-300 relative z-40 overflow-hidden">


        <!-- Logo -->
        <div class="px-6 py-6 border-b border-gray-100 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-green-50">
                <span class="text-xl">🏪</span>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-800 leading-tight">Almart</h2>
                <p class="text-[10px] text-gray-400 font-semibold tracking-wider uppercase">Admin Panel</p>
            </div>
        </div>

        <!-- Menu -->
        <nav class="flex-1 p-4 space-y-2 text-sm">

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition
               {{ request()->routeIs('admin.dashboard')
                    ? 'bg-blue-500 text-white shadow-lg shadow-blue-200'
                    : 'hover:bg-gray-100 text-gray-500' }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                Dashboard
            </a>

            <a href="{{ route('admin.orders.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition
               {{ request()->routeIs('admin.orders.*')
                    ? 'bg-blue-500 text-white shadow-lg shadow-blue-200'
                    : 'hover:bg-gray-100 text-gray-800' }}">
                <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                Transaksi
            </a>

            <a href="{{ route('admin.products.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition
               {{ request()->routeIs('admin.products.*')
                    ? 'bg-blue-500 text-white shadow-lg shadow-blue-200'
                    : 'hover:bg-gray-100 text-gray-800' }}">
                <i data-lucide="boxes" class="w-5 h-5"></i>
                Stok Barang
            </a>

            <a href="{{ route('admin.users.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition
               {{ request()->routeIs('admin.users.*')
                    ? 'bg-blue-500 text-white shadow-lg shadow-blue-200'
                    : 'hover:bg-gray-100 text-gray-800' }}">
                <i data-lucide="users" class="w-5 h-5"></i>
                Member & Petugas
            </a>

        </nav>



    </aside>


    <!-- ================= MAIN ================= -->
    <div class="flex-1 flex flex-col">

        <!-- ================= TOPBAR ================= -->
        <header class="bg-white px-8 py-5 flex justify-between items-center border-b border-gray-200">

            <!-- Toggle Sidebar & Search -->
            <div class="flex items-center gap-4 w-full max-w-md">
                <button id="toggleSidebarBtn" class="p-2 -ml-2 text-gray-500 hover:text-blue-600 hover:bg-gray-100 rounded-xl transition-colors focus:outline-none flex-shrink-0">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
                
                <div class="w-full relative group">
                    <i data-lucide="search" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-blue-500 transition-colors"></i>
                    <input type="text"
                           placeholder="Cari transaksi, produk, member..."
                           class="w-full pl-11 pr-5 py-3 rounded-2xl border border-gray-100 bg-gray-50/50
                                  focus:ring-2 focus:ring-blue-400/20 focus:border-blue-400 focus:bg-white outline-none text-sm font-medium transition-all">
                </div>
            </div>

            <!-- User -->
            <div class="flex items-center gap-5 ml-6">

                <button class="w-10 h-10 rounded-xl border border-gray-100 bg-white flex items-center justify-center text-gray-400 hover:text-blue-500 transition-colors shadow-sm relative">
                    <span class="absolute top-2 right-2 flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                    </span>
                    <span class="text-lg">🎉</span>
                </button>

                <div class="h-8 w-px bg-gray-200"></div>

                <!-- User Profile Dropdown -->
                <div class="relative">
                    <div id="profileDropdownBtn" class="flex items-center gap-3 cursor-pointer group select-none">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                {{ Auth::user()->name ?? 'Admin Store' }}
                            </p>
                            <p class="text-xs font-semibold text-gray-400 capitalize">
                                {{ Auth::user()->role ?? 'Store Manager' }}
                            </p>
                        </div>

                        <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl
                                    flex items-center justify-center shadow-sm border border-blue-100 group-hover:bg-blue-100 transition-colors">
                            <i data-lucide="user" class="w-5 h-5"></i>
                        </div>
                    </div>

                    <!-- Dropdown Menu -->
                    <div id="profileDropdownMenu" class="hidden absolute right-0 mt-4 w-48 bg-white rounded-2xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.1)] border border-gray-100 py-2 z-50 transition-all origin-top-right transform">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-5 py-2.5 text-sm text-red-600 hover:bg-red-50 flex items-center gap-3 font-bold transition-colors">
                                <i data-lucide="log-out" class="w-4 h-4"></i> Logout
                            </button>
                        </form>
                        <hr class="border-gray-100 my-1">
                        <a href="{{ route('profile.edit') }}" class="w-full text-left px-5 py-2.5 text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-3 font-bold transition-colors">
                            <i data-lucide="settings" class="w-4 h-4"></i> Pengaturan
                        </a>
                    </div>
                </div>

            </div>

        </header>

        <!-- ================= CONTENT ================= -->
        <main class="p-8">
            @yield('content')
        </main>

    </div>

</div>

    <script>
        lucide.createIcons();

        // -------------------------
        // Profile Dropdown Toggle
        // -------------------------
        const profileBtn = document.getElementById('profileDropdownBtn');
        const profileMenu = document.getElementById('profileDropdownMenu');
        
        if (profileBtn && profileMenu) {
            profileBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                profileMenu.classList.toggle('hidden');
            });

            document.addEventListener('click', (e) => {
                if (!profileMenu.contains(e.target) && !profileBtn.contains(e.target)) {
                    profileMenu.classList.add('hidden');
                }
            });
        }

        // -------------------------
        // Sidebar Toggle
        // -------------------------
        const adminSidebar = document.getElementById('adminSidebar');
        const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');

        function toggleSidebar() {
            if (adminSidebar.classList.contains('w-64')) {
                adminSidebar.classList.remove('w-64');
                adminSidebar.classList.add('w-0');
            } else {
                adminSidebar.classList.add('w-64');
                adminSidebar.classList.remove('w-0');
            }
        }

        if (toggleSidebarBtn) toggleSidebarBtn.addEventListener('click', toggleSidebar);

        // Laravel Echo Configuration for Reverb
        window.Pusher = Pusher;
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
                console.log('New Order Received:', e);
                showToast(`Pesanan Baru: ${e.order.order_code} dari ${e.order.customer.name}`, 'success');
                
                // Update stats if on dashboard
                if (window.updateDashboardStats) {
                    window.updateDashboardStats(e.order);
                }
            })
            .listen('.new-return', (e) => {
                console.log('New Return Received:', e);
                showToast(`Pengajuan Retur Baru: ${e.productReturn.order.order_code}`, 'warning');
            });

        // Simple Toast Function
        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            const colors = {
                success: 'bg-emerald-500',
                warning: 'bg-orange-500',
                error: 'bg-rose-500',
                info: 'bg-blue-500'
            };
            
            toast.className = `fixed bottom-5 right-5 ${colors[type]} text-white px-6 py-4 rounded-2xl shadow-2xl z-[9999] transform transition-all duration-500 translate-y-20 flex items-center gap-3 font-bold`;
            toast.innerHTML = `
                <i data-lucide="${type === 'success' ? 'check-circle' : 'bell'}" class="w-5 h-5"></i>
                <span>${message}</span>
            `;
            
            document.body.appendChild(toast);
            lucide.createIcons();
            
            setTimeout(() => {
                toast.classList.remove('translate-y-20');
            }, 100);
            
            setTimeout(() => {
                toast.classList.add('translate-y-20', 'opacity-0');
                setTimeout(() => toast.remove(), 500);
            }, 5000);
        }
    </script>
</body>
</html>