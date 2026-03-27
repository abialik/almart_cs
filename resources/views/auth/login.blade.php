<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Almart</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-pink-400 to-red-500">

<div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-10">

    <!-- Logo -->
    <div class="text-center mb-6">
        <img src="{{ asset('images/logo.png') }}" class="h-14 mx-auto mb-3">
        <h2 class="text-2xl font-bold text-gray-800">Almart</h2>
        <p class="text-sm text-gray-500 mt-1">
            Welcome back! Please login to your account
        </p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="mb-4">
            <label class="text-sm font-semibold text-gray-700">
                Email Address
            </label>
            <input type="email"
                   name="email"
                   required
                   placeholder="Enter your email"
                   class="w-full mt-2 px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-pink-400 outline-none text-sm">
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label class="text-sm font-semibold text-gray-700">
                Password
            </label>
            <input type="password"
                   name="password"
                   required
                   placeholder="Enter your password"
                   class="w-full mt-2 px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-pink-400 outline-none text-sm">
        </div>

        <!-- Remember & Forgot -->
        <div class="flex justify-between items-center text-sm mb-6">
            <label class="flex items-center gap-2 text-gray-600">
                <input type="checkbox" name="remember">
                Remember Me
            </label>

            <a href="{{ route('password.request') }}"
               class="text-pink-500 hover:underline">
                Forgot Password?
            </a>
        </div>

        <!-- Button -->
        <button type="submit"
                class="w-full py-3 rounded-xl bg-gradient-to-r from-pink-400 to-red-500 text-white font-semibold hover:opacity-90 transition">
            Login
        </button>

        <p class="text-center text-sm text-gray-500 mt-6">
            Don't have an account?
            <a href="{{ route('register') }}"
               class="text-pink-500 font-semibold hover:underline">
                Sign Up
            </a>
        </p>

    </form>

</div>

</body>
</html>