@extends('layouts.admin')

@section('title', 'Profile Saya — Admin Panel')

@section('content')

{{-- ===== PAGE HEADER ===== --}}
<div class="bg-gradient-to-r from-blue-500 to-indigo-600 py-8 mb-8 rounded-3xl shadow-sm">
    <div class="max-w-6xl mx-auto px-8 text-white">
        <h2 class="text-3xl font-extrabold mb-2">Pengaturan Profil Admin</h2>
        <p class="text-blue-100 opacity-90">Kelola informasi pribadi dan keamanan akun Anda.</p>
    </div>
</div>

<div class="max-w-4xl space-y-8">
    
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

</div>

@endsection
