@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="space-y-8 pb-10">

    <!-- TITLE SECTION -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 font-plus-jakarta">Manajemen Kategori</h1>
            <p class="text-sm text-gray-500 mt-1">
                Kelola kategori produk untuk memudahkan pelanggan mencari barang
            </p>
        </div>
        <div>
            <button onclick="openAddModal()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-xl text-xs flex items-center gap-2 shadow-sm shadow-blue-200 transition tracking-wider">
                <i data-lucide="plus" class="w-4 h-4"></i> Tambah Kategori
            </button>
        </div>
    </div>

    <!-- CATEGORIES TABLE -->
    <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.02)] border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Nama Kategori</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Slug</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Jumlah Produk</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Status</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($categories as $category)
                    <tr class="group hover:bg-gray-50/50 transition-colors">
                        <td class="px-8 py-5">
                            <span class="text-sm font-bold text-gray-900">{{ $category->name }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-xs font-medium text-gray-400 font-mono">{{ $category->slug }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <span class="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-black uppercase tracking-widest border border-blue-100">
                                {{ $category->products_count }} Produk
                            </span>
                        </td>
                        <td class="px-8 py-5">
                            @if($category->is_active)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[10px] font-black uppercase tracking-widest border border-emerald-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-50 text-gray-400 rounded-lg text-[10px] font-black uppercase tracking-widest border border-gray-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                    Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button onclick="openEditModal({{ $category->id }}, '{{ $category->name }}', {{ $category->is_active }})" class="p-2 text-blue-500 hover:bg-blue-50 rounded-xl transition">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </button>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="confirmDeleteCategory(event, this)">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-rose-500 hover:bg-rose-50 rounded-xl transition">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i data-lucide="layers" class="w-8 h-8 text-gray-200"></i>
                            </div>
                            <h3 class="text-sm font-bold text-gray-900">Belum Ada Kategori</h3>
                            <p class="text-xs text-gray-500 mt-1">Klik tombol tambah untuk memulai</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- ADD MODAL -->
<div id="addModal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" onclick="closeAddModal()"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md p-6">
        <div class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 overflow-hidden animate-zoom-in">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-900 font-plus-jakarta">Tambah Kategori</h2>
                    <button onclick="closeAddModal()" class="text-gray-400 hover:text-gray-600"><i data-lucide="x" class="w-5 h-5"></i></button>
                </div>
                <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Nama Kategori</label>
                        <input type="text" name="name" required placeholder="Misal: Minuman Segar" class="w-full px-5 py-3.5 bg-gray-50 border border-transparent rounded-2xl text-sm font-bold focus:bg-white focus:border-blue-500 outline-none transition-all">
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="checkbox" name="is_active" id="is_active_add" checked value="1" class="w-5 h-5 text-blue-600 border-gray-200 rounded-lg focus:ring-blue-500 transition-all">
                        <label for="is_active_add" class="text-xs font-bold text-gray-600 cursor-pointer">Aktifkan Kategori</label>
                    </div>
                    <button type="submit" class="w-full py-4 bg-blue-600 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all active:scale-95">Simpan Kategori</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- EDIT MODAL -->
<div id="editModal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" onclick="closeEditModal()"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md p-6">
        <div class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 overflow-hidden animate-zoom-in">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-900 font-plus-jakarta">Edit Kategori</h2>
                    <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600"><i data-lucide="x" class="w-5 h-5"></i></button>
                </div>
                <form id="editForm" method="POST" class="space-y-6">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Nama Kategori</label>
                        <input type="text" name="name" id="edit_name" required class="w-full px-5 py-3.5 bg-gray-50 border border-transparent rounded-2xl text-sm font-bold focus:bg-white focus:border-blue-500 outline-none transition-all">
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="checkbox" name="is_active" id="edit_is_active" value="1" class="w-5 h-5 text-blue-600 border-gray-200 rounded-lg focus:ring-blue-500 transition-all">
                        <label for="edit_is_active" class="text-xs font-bold text-gray-600 cursor-pointer">Aktifkan Kategori</label>
                    </div>
                    <button type="submit" class="w-full py-4 bg-blue-600 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all active:scale-95">Perbarui Kategori</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openAddModal() {
        document.getElementById('addModal').classList.remove('hidden');
    }
    function closeAddModal() {
        document.getElementById('addModal').classList.add('hidden');
    }
    function openEditModal(id, name, isActive) {
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_is_active').checked = isActive;
        document.getElementById('editForm').action = `/admin/categories/${id}`;
        document.getElementById('editModal').classList.remove('hidden');
    }
    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
    function confirmDeleteCategory(event, form) {
        event.preventDefault();
        Swal.fire({
            title: 'Hapus Kategori?',
            text: "Kategori hanya bisa dihapus jika tidak memiliki produk di dalamnya.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-[2rem]',
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
<style>
    @keyframes zoomIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
    .animate-zoom-in { animation: zoomIn 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
</style>
@endpush

@endsection
