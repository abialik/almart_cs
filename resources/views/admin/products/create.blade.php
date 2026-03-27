@extends('layouts.admin')

@section('title', 'Tambah Produk Baru')

@section('content')
<div class="space-y-8 pb-10">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.products.index') }}" class="w-10 h-10 bg-white border border-gray-100 rounded-xl flex items-center justify-center text-gray-500 hover:text-blue-600 hover:bg-blue-50 transition shadow-sm">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 font-plus-jakarta">Tambah Produk Baru</h1>
            <p class="text-sm text-gray-500 mt-1">Lengkapi form di bawah untuk menambahkan barang ke dalam stok.</p>
        </div>
    </div>

    <div class="bg-white p-8 rounded-3xl border border-gray-50 shadow-[0_8px_30px_rgb(0,0,0,0.04)] max-w-4xl">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Col -->
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Produk <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-semibold focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition" required>
                        @error('name')<p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Kategori <span class="text-rose-500">*</span></label>
                        <select name="category_id" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-semibold focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Stok <span class="text-rose-500">*</span></label>
                            <input type="number" name="stock" value="{{ old('stock', 0) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-semibold focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Harga (Rp) <span class="text-rose-500">*</span></label>
                            <input type="number" name="price" value="{{ old('price', 0) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-semibold focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition" required>
                        </div>
                    </div>
                </div>

                <!-- Right Col -->
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Produk</label>
                        <textarea name="description" rows="5" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-semibold focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Gambar Produk</label>
                        <input type="file" name="image" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-semibold focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>

                    <div>
                        <label class="flex items-center gap-3 cursor-pointer select-none">
                            <input type="checkbox" name="is_active" value="1" checked class="w-5 h-5 text-blue-600 rounded-lg border-gray-300 focus:ring-blue-500 transition">
                            <span class="text-sm font-bold text-gray-700">Produk Aktif (Ditampilkan)</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('admin.products.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 font-bold rounded-xl text-sm hover:bg-gray-200 transition">Batal</a>
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-bold rounded-xl text-sm hover:bg-blue-700 shadow-lg shadow-blue-200 transition">Simpan Produk</button>
            </div>
        </form>
    </div>
</div>
@endsection
