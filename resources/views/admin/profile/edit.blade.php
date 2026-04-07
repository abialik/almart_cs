@extends('layouts.admin')

@section('title', 'Pengaturan Akun')

@section('content')
<div class="mb-10 animate-fade-in">
    <nav class="flex text-gray-400 text-[10px] font-black uppercase tracking-[0.2em] mb-3" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-2">
            <li><a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a></li>
            <li><div class="flex items-center"><i data-lucide="chevron-right" class="w-3 h-3 mx-1"></i> <span class="text-gray-500">Profil Saya</span></div></li>
        </ol>
    </nav>
    <h1 class="text-4xl font-black text-gray-900 tracking-tight">Kelola Akun Admin</h1>
    <p class="text-sm text-gray-500 mt-2 font-medium">Perbarui seluruh data profil dan keamanan Anda dalam sekejap.</p>
</div>

{{-- ERROR MESSAGES --}}
@if ($errors->any())
    <div class="max-w-5xl mb-8 p-6 bg-rose-50 border-l-8 border-rose-500 text-rose-600 rounded-[2rem] shadow-xl shadow-rose-100 animate-slide-up">
        <div class="flex items-center gap-3 mb-2">
            <i data-lucide="alert-circle" class="w-5 h-5"></i>
            <h5 class="font-black uppercase tracking-widest text-xs">Terjadi Kesalahan Input</h5>
        </div>
        <ul class="list-disc ml-8 uppercase font-bold text-[10px] tracking-widest opacity-80">
            @foreach ($errors->all() as $error)
                <li class="mb-1">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="max-w-5xl pb-20 animate-slide-up">
    
    <form method="post" action="{{ route('profile.full-update') }}" class="space-y-8">
        @csrf
        @method('patch')

        <div class="bg-white rounded-[3.5rem] shadow-[0_32px_80px_-16px_rgba(0,0,0,0.1)] border border-gray-100 overflow-hidden">
            
            {{-- Profile Header --}}
            <div class="bg-gradient-to-br from-gray-900 via-gray-800 to-indigo-950 p-12 flex flex-col md:flex-row items-center gap-10 justify-between relative overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute -right-20 -top-20 w-80 h-80 bg-blue-400 rounded-full blur-3xl"></div>
                    <div class="absolute -left-20 -bottom-20 w-60 h-60 bg-indigo-500 rounded-full blur-3xl"></div>
                </div>

                <div class="flex items-center gap-8 relative z-10">
                    <div class="w-24 h-24 bg-white/10 backdrop-blur-2xl rounded-[2.5rem] flex items-center justify-center text-white text-4xl font-black border border-white/20 shadow-inner">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="text-white">
                        <h3 class="text-3xl font-black tracking-tight leading-none mb-3">{{ $user->name }}</h3>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-4 py-1.5 bg-blue-500/20 text-blue-300 rounded-full text-[10px] font-black uppercase tracking-widest border border-blue-500/20">Authorized Account</span>
                            <span class="px-4 py-1.5 bg-white/10 text-white/50 rounded-full text-[10px] font-black uppercase tracking-widest border border-white/10">{{ strtoupper($user->role) }}</span>
                        </div>
                    </div>
                </div>

                <div class="relative z-10">
                    <span class="px-5 py-2 bg-white/10 rounded-2xl text-[10px] font-black uppercase tracking-widest text-white/50 border border-white/10">Admin Panel v2.0</span>
                </div>
            </div>

            <div class="p-12 space-y-16">
                
                {{-- SECTION 1: IDENTITY --}}
                <div class="space-y-10">
                    <div class="flex items-center gap-4 text-blue-600">
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center shadow-inner">
                            <i data-lucide="identification-card" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h4 class="text-xl font-black text-gray-900 tracking-tight leading-none">Identitas Pengguna</h4>
                            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mt-2">Ubah informasi nama dan email pendaftaran</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] ml-2">Nama Lengkap Admin</label>
                            <div class="relative group">
                                <span class="absolute left-6 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                    <i data-lucide="user" class="w-5 h-5"></i>
                                </span>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                       class="w-full bg-gray-50 border-none px-16 py-5 rounded-3xl text-sm font-bold shadow-inner outline-none focus:bg-white focus:ring-8 focus:ring-blue-50/50 transition-all">
                            </div>
                        </div>
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] ml-2">Email Korespondensi</label>
                            <div class="relative group">
                                <span class="absolute left-6 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                    <i data-lucide="mail-check" class="w-5 h-5"></i>
                                </span>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                       class="w-full bg-gray-50 border-none px-16 py-5 rounded-3xl text-sm font-bold shadow-inner outline-none focus:bg-white focus:ring-8 focus:ring-blue-50/50 transition-all">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SECTION 2: SECURITY --}}
                <div class="space-y-10 pt-10 border-t border-gray-100">
                    <div class="flex items-center gap-4 text-rose-500">
                        <div class="w-12 h-12 rounded-2xl bg-rose-50 flex items-center justify-center shadow-inner">
                            <i data-lucide="lock" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h4 class="text-xl font-black text-gray-900 tracking-tight leading-none">Keamanan & Sandi</h4>
                            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mt-2">Biarkan kolom kosong jika tidak ingin merubah sandi</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] ml-2 font-black">Password Saat Ini</label>
                            <input type="password" name="current_password"
                                   class="w-full bg-gray-50 border-none px-8 py-5 rounded-3xl text-sm font-bold shadow-inner outline-none focus:bg-white focus:ring-8 focus:ring-rose-50/50 transition-all"
                                   placeholder="••••••••">
                        </div>
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] ml-2 font-black">Password Baru</label>
                            <input type="password" name="password"
                                   class="w-full bg-gray-50 border-none px-8 py-5 rounded-3xl text-sm font-bold shadow-inner outline-none focus:bg-white focus:ring-8 focus:ring-rose-50/50 transition-all"
                                   placeholder="••••••••">
                        </div>
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] ml-2 font-black">Konfirmasi Baru</label>
                            <input type="password" name="password_confirmation"
                                   class="w-full bg-gray-50 border-none px-8 py-5 rounded-3xl text-sm font-bold shadow-inner outline-none focus:bg-white focus:ring-8 focus:ring-rose-50/50 transition-all"
                                   placeholder="••••••••">
                        </div>
                    </div>
                </div>

                {{-- SUBMIT FOOTER --}}
                <div class="pt-10 flex flex-col items-center">
                    <button type="submit" class="w-full md:w-auto px-20 py-6 bg-gray-900 text-white rounded-[2.5rem] text-sm font-black uppercase tracking-[0.2em] shadow-2xl shadow-gray-200 hover:-translate-y-2 active:scale-95 transition-all duration-300">
                        Simpan Semua Perubahan
                    </button>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-6">Seluruh data yang Anda ubah akan langsung sinkron dengan sistem Almart</p>
                </div>

            </div>
        </div>
    </form>
</div>

<style>
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes slideUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { animation: fadeIn 0.6s ease-out; }
    .animate-slide-up { animation: slideUp 0.9s cubic-bezier(0.16, 1, 0.3, 1); }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
</script>
@endsection
