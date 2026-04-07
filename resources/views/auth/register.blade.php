<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Almart Shop</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css'])
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow-x: hidden;
        }

        /* PREMIUM ANIMATED BACKGROUND (Sama dengan Login) */
        .bg-animate {
            background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
            position: fixed;
            inset: 0;
            z-index: -1;
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.6;
            animation: moveOrb 20s infinite alternate-reverse;
        }

        .orb-1 { width: 400px; height: 400px; background: rgba(255, 182, 193, 0.4); top: -100px; left: -100px; }
        .orb-2 { width: 500px; height: 500px; background: rgba(244, 63, 94, 0.3); bottom: -100px; right: -100px; animation-duration: 25s; }
        .orb-3 { width: 300px; height: 300px; background: rgba(251, 113, 133, 0.4); top: 50%; left: 50%; transform: translate(-50%, -50%); animation-duration: 30s; }

        @keyframes moveOrb {
            from { transform: translate(0, 0) scale(1); }
            to { transform: translate(100px, 100px) scale(1.2); }
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .input-premium {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .input-premium:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(244, 63, 94, 0.15);
        }

        .animate-up {
            animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Custom Scrollbar for the form card if it grows tall */
        .custom-scroll::-webkit-scrollbar { width: 4px; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #fee2e2; border-radius: 10px; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6 bg-rose-500 py-12">

    <!-- ANIMATED ORBS -->
    <div class="bg-animate">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>

    <div class="w-full max-w-lg glass-card rounded-[3rem] shadow-[0_32px_64px_-16px_rgba(0,0,0,0.2)] p-10 animate-up relative z-10 overflow-hidden">
        
        <!-- TOP DECORATION LOGO -->
        <div class="flex justify-center mb-6">
            <div class="relative">
                <div class="absolute inset-0 bg-red-400 blur-2xl opacity-20"></div>
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-14 relative hover:scale-110 transition-transform duration-500">
            </div>
        </div>

        <div class="text-center mb-8">
            <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Bergabung Bersama Almart</h1>
            <p class="text-gray-500 text-xs mt-2 font-medium uppercase tracking-widest">Pendaftaran pelanggan baru</p>
        </div>

        <!-- ERROR MESSAGES -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-600 rounded-2xl text-[11px] font-bold">
                @foreach ($errors->all() as $error)
                    <p class="flex items-center gap-2 mb-1 last:mb-0"><span class="w-1 h-1 bg-red-500 rounded-full"></span> {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Full Name -->
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1 mb-2">Nama Lengkap</label>
                <div class="relative group">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-red-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </span>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                           class="w-full bg-gray-100 border-none px-12 py-3.5 rounded-2xl text-sm font-semibold input-premium outline-none placeholder:text-gray-400 focus:bg-white focus:ring-4 focus:ring-red-100" 
                           placeholder="Nama sesuai KTP">
                </div>
            </div>

            <!-- Email & Phone (Grid) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1 mb-2">Email</label>
                    <div class="relative group">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-red-500 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full bg-gray-100 border-none px-10 py-3.5 rounded-2xl text-sm font-semibold input-premium outline-none placeholder:text-gray-400 focus:bg-white focus:ring-4 focus:ring-red-100" 
                               placeholder="email@example.com">
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1 mb-2">Telepon</label>
                    <div class="relative group">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-red-500 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </span>
                        <input type="text" name="phone" value="{{ old('phone') }}" required
                               class="w-full bg-gray-100 border-none px-10 py-3.5 rounded-2xl text-sm font-semibold input-premium outline-none placeholder:text-gray-400 focus:bg-white focus:ring-4 focus:ring-red-100" 
                               placeholder="0812xxxx">
                    </div>
                </div>
            </div>

            <!-- Password -->
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1 mb-2">Password</label>
                <div class="relative group">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-red-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </span>
                    <input id="password" type="password" name="password" required
                           class="w-full bg-gray-100 border-none px-12 py-3.5 rounded-2xl text-sm font-semibold input-premium outline-none placeholder:text-gray-400 focus:bg-white focus:ring-4 focus:ring-red-100" 
                           placeholder="Min. 8 Karakter">
                    <button type="button" onclick="togglePW('password', 'eye-1')" 
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500 transition-colors focus:outline-none">
                        <svg id="eye-1" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1 mb-2">Konfirmasi Password</label>
                <div class="relative group">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-red-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </span>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                           class="w-full bg-gray-100 border-none px-12 py-3.5 rounded-2xl text-sm font-semibold input-premium outline-none placeholder:text-gray-400 focus:bg-white focus:ring-4 focus:ring-red-100" 
                           placeholder="Ulangi password">
                    <button type="button" onclick="togglePW('password_confirmation', 'eye-2')" 
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500 transition-colors focus:outline-none">
                        <svg id="eye-2" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" 
                    class="w-full mt-2 py-4 bg-gradient-to-r from-rose-500 to-red-600 text-white rounded-2xl text-sm font-black uppercase tracking-widest shadow-xl shadow-red-200 hover:-translate-y-1 active:scale-95 transition-all duration-300">
                Daftar Akun Sekarang
            </button>
        </form>

        <div class="mt-8 text-center">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-red-600 hover:text-red-700 underline underline-offset-4 ml-1">LOG IN DISINI</a>
            </p>
        </div>

    </div>

    <!-- SCRIPT FOR PASSWORD TOGGLE -->
    <script>
        function togglePW(id, eyeId) {
            const input = document.getElementById(id);
            const eye = document.getElementById(eyeId);
            
            if (input.type === 'password') {
                input.type = 'text';
                eye.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />`;
            } else {
                input.type = 'password';
                eye.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
            }
        }
    </script>
</body>
</html>