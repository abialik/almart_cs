<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Almart</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-pink-400 to-red-500">

<div class="w-full max-w-lg bg-white rounded-3xl shadow-2xl p-10">

    <!-- Logo -->
    <div class="text-center mb-6">
        <img src="{{ asset('images/logo.png') }}" class="h-14 mx-auto mb-3">
        <h2 class="text-2xl font-bold text-gray-800">Almart</h2>
        <p class="text-sm text-gray-500 mt-1">
            Create your account to get started
        </p>
    </div>

    <!-- SUCCESS MESSAGE -->
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-xl text-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- ERROR MESSAGE -->
    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-600 rounded-xl text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Full Name -->
        <div class="mb-4">
            <label class="text-sm font-semibold text-gray-700">
                Full Name
            </label>
            <input type="text"
                   name="name"
                   value="{{ old('name') }}"
                   required
                   placeholder="Enter your full name"
                   class="w-full mt-2 px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-pink-400 outline-none text-sm">
        </div>

        <!-- Email & Phone -->
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="text-sm font-semibold text-gray-700">
                    Email
                </label>
                <input type="email"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       placeholder="Enter your email"
                       class="w-full mt-2 px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-pink-400 outline-none text-sm">
            </div>

            <div>
                <label class="text-sm font-semibold text-gray-700">
                    Phone Number
                </label>
                <input type="text"
                       name="phone"
                       value="{{ old('phone') }}"
                       placeholder="Enter phone number"
                       class="w-full mt-2 px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-pink-400 outline-none text-sm">
            </div>
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label class="text-sm font-semibold text-gray-700">
                Password
            </label>
            <input type="password"
                   name="password"
                   required
                   placeholder="Create a password"
                   class="w-full mt-2 px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-pink-400 outline-none text-sm">
        </div>

        <!-- Confirm Password -->
        <div class="mb-6">
            <label class="text-sm font-semibold text-gray-700">
                Confirm Password
            </label>
            <input type="password"
                   name="password_confirmation"
                   required
                   placeholder="Confirm your password"
                   class="w-full mt-2 px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-pink-400 outline-none text-sm">
        </div>

        <!-- Button -->
        <button type="submit"
                class="w-full py-3 rounded-xl bg-gradient-to-r from-pink-400 to-red-500 text-white font-semibold hover:opacity-90 transition">
            Sign Up
        </button>

        <p class="text-center text-sm text-gray-500 mt-6">
            Already have an account?
            <a href="{{ route('login') }}"
               class="text-pink-500 font-semibold hover:underline">
                Login
            </a>
        </p>

    </form>

</div>

</body>
</html>