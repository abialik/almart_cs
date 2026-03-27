@extends('layouts.shop')

@section('title', 'Profile Saya — Almart')

@section('content')

{{-- ===== PAGE HEADER ===== --}}
<div class="bg-gradient-to-r from-green-500 to-emerald-600 py-10 mb-10 shadow-sm">
    <div class="max-w-6xl mx-auto px-6 text-white text-center sm:text-left">
        <h2 class="text-3xl font-extrabold mb-2">Pengaturan Profil</h2>
        <p class="text-green-100 opacity-90">Kelola informasi pribadi dan keamanan akun Anda.</p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-6 pb-24 space-y-10">
    
    {{-- Update Profile --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 sm:p-12">
        <div class="max-w-xl">
             <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-1">Informasi Profil</h3>
                <p class="text-sm text-gray-500">Perbarui nama dan alamat email akun Anda.</p>
             </div>
             @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    {{-- MANAGE ADDRESSES --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 sm:p-12">
        @include('profile.partials.manage-addresses')
    </div>

    {{-- Update Password --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 sm:p-12">
        <div class="max-w-xl">
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-1">Ubah Password</h3>
                <p class="text-sm text-gray-500">Pastikan akun Anda menggunakan password yang kuat dan acak.</p>
             </div>
            @include('profile.partials.update-password-form')
        </div>
    </div>

    {{-- Delete Account --}}
    <div class="bg-red-50 rounded-3xl border border-red-100 p-8 sm:p-12">
        <div class="max-w-xl">
             <div class="mb-8">
                <h3 class="text-xl font-bold text-red-900 mb-1">Hapus Akun</h3>
                <p class="text-sm text-red-600">Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen.</p>
             </div>
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>

@endsection
