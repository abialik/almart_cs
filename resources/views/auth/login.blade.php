<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Almart Shop</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css'])
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow: hidden; /* Mencegah scroll saat ada animasi orb */
        }

        /* PREMIUM ANIMATED BACKGROUND */
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
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6 bg-rose-500">

    <!-- ANIMATED ORBS -->
    <div class="bg-animate">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>

    <div class="w-full max-w-md glass-card rounded-[3rem] shadow-[0_32px_64px_-16px_rgba(0,0,0,0.2)] p-10 mt-10 animate-up relative z-10 overflow-hidden">
        
        <!-- TOP DECORATION LOGO -->
        <div class="flex justify-center mb-8">
            <div class="relative">
                <div class="absolute inset-0 bg-red-400 blur-2xl opacity-20"></div>
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 relative hover:scale-110 transition-transform duration-500">
            </div>
        </div>

        <div class="text-center mb-10">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Selamat Datang</h1>
            <p class="text-gray-500 text-sm mt-3 font-medium">Banyak promo menarik sudah menantimu!</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-600 rounded-2xl text-xs font-bold animate-pulse">
                @foreach ($errors->all() as $error)
                    <p class="flex items-center gap-2"><span class="w-1 h-1 bg-red-500 rounded-full"></span> {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Field -->
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest ml-1 mb-2">Email Address</label>
                <div class="relative group">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-red-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 12a4 4 0 11-8 0 4 4 0 018 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"/></svg>
                    </span>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full bg-gray-100 border-none px-12 py-4 rounded-2xl text-sm font-semibold input-premium outline-none placeholder:text-gray-400 focus:bg-white focus:ring-4 focus:ring-red-100" 
                           placeholder="yourname@email.com">
                </div>
            </div>

            <!-- Password Field -->
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest ml-1 mb-2">Password</label>
                <div class="relative group">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-red-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </span>
                    <input id="password" type="password" name="password" required
                           class="w-full bg-gray-100 border-none px-12 py-4 rounded-2xl text-sm font-semibold input-premium outline-none placeholder:text-gray-400 focus:bg-white focus:ring-4 focus:ring-red-100" 
                           placeholder="••••••••">
                    <button type="button" onclick="togglePassword()" 
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500 transition-colors focus:outline-none">
                        <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Remember Me removed for security (logout on close policy) --}}

            <button type="submit" 
                    class="w-full py-4 bg-gradient-to-r from-rose-500 to-red-600 text-white rounded-2xl text-sm font-black uppercase tracking-widest shadow-xl shadow-red-200 hover:-translate-y-1 active:scale-95 transition-all duration-300">
                Masuk Sekarang
            </button>
        </form>

        <div class="mt-10 text-center">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-red-600 hover:text-red-700 underline underline-offset-4 ml-1">Daftar DISINI</a>
            </p>
        </div>

    </div>

    <!-- SCRIPT FOR PASSWORD TOGGLE -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />`;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            }
        }
    </script>
</body>
</html>