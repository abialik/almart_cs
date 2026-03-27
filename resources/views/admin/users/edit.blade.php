@extends('layouts.admin')

@section('title', 'Edit Pengguna')

@section('content')
<div class="space-y-8 pb-10">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.users.index', ['tab' => $user->role]) }}" class="w-10 h-10 bg-white border border-gray-100 rounded-xl flex items-center justify-center text-gray-500 hover:text-blue-600 hover:bg-blue-50 transition shadow-sm">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 font-plus-jakarta">Edit {{ ucfirst($user->role) }}</h1>
            <p class="text-sm text-gray-500 mt-1">Ubah data profil dan pengaturan akses pengguna.</p>
        </div>
    </div>

    <div class="bg-white p-8 rounded-3xl border border-gray-50 shadow-[0_8px_30px_rgb(0,0,0,0.04)] max-w-3xl">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <input type="hidden" name="role" value="{{ $user->role }}">

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap <span class="text-rose-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-semibold focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition" required>
                @error('name')<p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Email <span class="text-rose-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-semibold focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition" required>
                    @error('email')<p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">No. Telepon / WhatsApp</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-semibold focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                    @error('phone')<p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="p-4 bg-gray-50 border border-gray-100 rounded-2xl">
                <p class="text-xs font-bold text-gray-500 mb-4 uppercase tracking-widest"><i data-lucide="lock" class="w-3 h-3 inline-block mr-1"></i> Ubah Password (Opsional)</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Password Baru</label>
                        <input type="password" name="password" placeholder="Kosongkan jika tidak diubah" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm font-semibold focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                        @error('password')<p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" placeholder="Ulangi password baru" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm font-semibold focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                    </div>
                </div>
            </div>

            <div>
                <label class="flex items-center gap-3 cursor-pointer select-none">
                    <input type="checkbox" name="is_active" value="1" {{ $user->is_active ? 'checked' : '' }} class="w-5 h-5 text-blue-600 rounded-lg border-gray-300 focus:ring-blue-500 transition">
                    <span class="text-sm font-bold text-gray-700">Akun Aktif (Dapat Login)</span>
                </label>
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('admin.users.index', ['tab' => $user->role]) }}" class="px-6 py-3 bg-gray-100 text-gray-700 font-bold rounded-xl text-sm hover:bg-gray-200 transition">Batal</a>
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-bold rounded-xl text-sm hover:bg-blue-700 shadow-lg shadow-blue-200 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
