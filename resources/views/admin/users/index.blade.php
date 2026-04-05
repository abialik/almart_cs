@extends('layouts.admin')

@section('title', 'Manajemen Member & Petugas')

@section('content')
<div class="space-y-8 pb-10">

    <!-- TITLE SECTION -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 font-plus-jakarta">Manajemen Member & Petugas</h1>
            <p class="text-sm text-gray-500 mt-1">
                Kelola data member dan petugas toko
            </p>
        </div>
        <div>
            <!-- Add Button -->
            <a href="{{ route('admin.users.create', ['role' => $tab]) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-5 rounded-xl text-xs flex items-center gap-2 shadow-sm shadow-blue-200 transition tracking-wider">
                <i data-lucide="user-plus" class="w-4 h-4"></i> Tambah {{ ucfirst($tab === 'petugas' ? 'Petugas' : 'Member') }}
            </a>
        </div>
    </div>

    <!-- STATS CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card: Total Member -->
        <div class="bg-white p-5 rounded-2xl border border-gray-50 flex items-center gap-4 shadow-[0_2px_10px_rgb(0,0,0,0.02)]">
            <div class="w-10 h-10 rounded-xl bg-blue-500 text-white flex items-center justify-center shrink-0 shadow-md shadow-blue-200">
                <i data-lucide="user" class="w-5 h-5"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-500 mb-0.5 uppercase tracking-widest leading-none">Total Member</p>
                <h2 class="text-xl font-black text-gray-900 leading-tight">{{ $totalMember }}</h2>
            </div>
        </div>

        <!-- Card: Total Petugas -->
        <div class="bg-white p-5 rounded-2xl border border-gray-50 flex items-center gap-4 shadow-[0_2px_10px_rgb(0,0,0,0.02)]">
            <div class="w-10 h-10 rounded-xl bg-purple-500 text-white flex items-center justify-center shrink-0 shadow-md shadow-purple-200">
                <i data-lucide="shield" class="w-5 h-5"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-500 mb-0.5 uppercase tracking-widest leading-none">Total Petugas</p>
                <h2 class="text-xl font-black text-gray-900 leading-tight">{{ $totalPetugas }}</h2>
            </div>
        </div>

        <!-- Card: Member Aktif -->
        <div class="bg-white p-5 rounded-2xl border border-gray-50 flex items-center gap-4 shadow-[0_2px_10px_rgb(0,0,0,0.02)]">
            <div class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0 shadow-md shadow-emerald-200">
                <i data-lucide="user-check" class="w-5 h-5"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-500 mb-0.5 uppercase tracking-widest leading-none">Member Aktif</p>
                <h2 class="text-xl font-black text-gray-900 leading-tight">{{ $memberAktif }}</h2>
            </div>
        </div>

        <!-- Card: Member Baru (Bulan Ini) -->
        <div class="bg-white p-5 rounded-2xl border border-gray-50 flex items-center gap-4 shadow-[0_2px_10px_rgb(0,0,0,0.02)]">
            <div class="w-10 h-10 rounded-xl bg-orange-500 text-white flex items-center justify-center shrink-0 shadow-md shadow-orange-200">
                <i data-lucide="calendar" class="w-5 h-5"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-500 mb-0.5 uppercase tracking-widest leading-none">Member Baru (Bulan Ini)</p>
                <h2 class="text-xl font-black text-gray-900 leading-tight">{{ $memberBaru }}</h2>
            </div>
        </div>
    </div>

    <!-- FILTERS AND TABS -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 bg-white p-2.5 rounded-2xl shadow-[0_2px_10px_rgb(0,0,0,0.02)] border border-gray-50">
        <!-- Tabs -->
        <div class="flex items-center gap-2 w-full md:w-auto overflow-x-auto">
            <a href="{{ route('admin.users.index', ['tab' => 'member']) }}" 
               class="px-5 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap transition-colors {{ $tab === 'member' ? 'bg-blue-500 text-white shadow-md shadow-blue-200' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                Member ({{ $totalMember }})
            </a>
            <a href="{{ route('admin.users.index', ['tab' => 'petugas']) }}" 
               class="px-5 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap transition-colors {{ $tab === 'petugas' ? 'bg-blue-500 text-white shadow-md shadow-blue-200' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                Petugas ({{ $totalPetugas }})
            </a>
        </div>
        
        <!-- Search -->
        <form action="{{ url()->current() }}" method="GET" class="relative w-full md:w-80">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <i data-lucide="search" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau nomor telepon..." class="w-full pl-10 pr-20 py-2 border border-gray-200 rounded-full text-xs font-semibold text-gray-700 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-shadow">
            <button type="submit" class="absolute right-1 top-1/2 -translate-y-1/2 bg-blue-500 text-white hover:bg-blue-600 font-bold text-[10px] py-1.5 px-3 rounded-full shadow-sm transition-colors">Cari</button>
        </form>
    </div>

    <!-- USERS GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @forelse($users as $user)
        <div class="bg-white rounded-3xl p-6 border border-gray-50 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-lg transition flex flex-col group">
            
            <!-- Top Header -->
            <div class="flex justify-between items-start mb-6">
                <div class="flex gap-4 items-center">
                    <div class="w-12 h-12 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold text-lg shadow-sm">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h3 class="text-base font-black text-gray-900 leading-tight">{{ $user->name }}</h3>
                        <div class="inline-flex px-2 py-0.5 mt-1 bg-gray-100 text-gray-500 text-[10px] font-bold rounded uppercase tracking-widest">
                            {{ $user->role === 'customer' ? 'M' : 'P' }}{{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}
                        </div>
                    </div>
                </div>
                <!-- Actions -->
                <div class="flex gap-2">
                    <a href="{{ route('admin.users.show', $user->id) }}" class="text-blue-500 hover:text-blue-700 hover:bg-blue-50 p-1.5 rounded-lg transition" title="Lihat">
                        <i data-lucide="eye" class="w-4 h-4"></i>
                    </a>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="text-gray-400 hover:text-gray-600 hover:bg-gray-50 p-1.5 rounded-lg transition" title="Edit">
                        <i data-lucide="edit" class="w-4 h-4"></i>
                    </a>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="confirmDelete(event, this)">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-rose-400 hover:text-rose-600 hover:bg-rose-50 p-1.5 rounded-lg transition" title="Hapus">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Details List -->
            <div class="space-y-3 mb-6 flex-1">
                <div class="flex items-center gap-3 text-sm font-medium text-gray-500">
                    <i data-lucide="mail" class="w-4 h-4 text-gray-400"></i>
                    {{ $user->email }}
                </div>
                <div class="flex items-center gap-3 text-sm font-medium text-gray-500">
                    <i data-lucide="phone" class="w-4 h-4 text-gray-400"></i>
                    {{ $user->phone ?? '-' }}
                </div>
                <div class="flex items-center gap-3 text-sm font-medium text-gray-500">
                    <i data-lucide="calendar" class="w-4 h-4 text-gray-400"></i>
                    Bergabung: {{ $user->created_at->format('d M Y') }}
                </div>
            </div>

            <!-- Bottom Stats -->
            @if($user->role === 'customer')
            <div class="flex gap-4">
                <div class="flex-1 bg-blue-50/80 p-3 rounded-2xl border border-blue-50">
                    <p class="text-[10px] font-bold text-blue-500 mb-1">Total Pesanan</p>
                    <p class="text-lg font-black text-blue-700 leading-none">{{ $user->orders_count ?? 0 }}</p>
                </div>
                <div class="flex-1 bg-emerald-50/80 p-3 rounded-2xl border border-emerald-50">
                    <p class="text-[10px] font-bold text-emerald-500 mb-1">Total Belanja</p>
                    <p class="text-lg font-black text-emerald-700 leading-none">Rp {{ number_format($user->orders_sum_total ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
            @endif
        </div>
        @empty
        <div class="lg:col-span-2 text-center py-16 bg-white rounded-3xl border border-gray-50 shadow-sm">
            <div class="w-16 h-16 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="users" class="w-8 h-8"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900">Data Tidak Ditemukan</h3>
            <p class="text-sm text-gray-500 mt-1">Belum ada data member atau petugas dengan kata kunci tersebut.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
    <div class="mt-8 flex justify-center">
        {{ $users->links() }}
    </div>
    @endif
</div>
<script>
    function confirmDelete(event, form) {
        event.preventDefault();
        Swal.fire({
            title: 'Hapus Pengguna?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#9ca3af',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-3xl shadow-xl border border-gray-100',
                confirmButton: 'rounded-xl font-bold px-6 py-2.5',
                cancelButton: 'rounded-xl font-bold px-6 py-2.5'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
@endsection
