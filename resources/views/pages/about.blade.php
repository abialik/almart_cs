@extends('layouts.shop')

@section('title', 'Tentang Kami — Almart')

@section('content')
<div class="bg-gray-50 min-h-screen py-20">
    <div class="max-w-4xl mx-auto px-6 bg-white rounded-3xl shadow-sm border border-gray-100 p-10 sm:p-16">
        <h1 class="text-4xl font-black text-gray-900 mb-8 tracking-tighter">Tentang Almart</h1>
        <div class="prose prose-green max-w-none text-gray-600 space-y-6">
            <p class="text-lg leading-relaxed">
                Selamat datang di <strong>Almart</strong>, destinasi utama Anda untuk kebutuhan makanan segar dan berkualitas setiap hari. Kami percaya bahwa gaya hidup sehat dimulai dari meja makan Anda.
            </p>
            <p>
                Almart didirikan dengan visi untuk memudahkan masyarakat dalam mengakses produk pertanian segar, buah-buahan, dan kebutuhan pokok lainnya secara praktis dan hemat. Kami bekerja sama langsung dengan mitra pilihan untuk memastikan setiap barang yang sampai ke tangan Anda adalah yang terbaik.
            </p>
            <h2 class="text-2xl font-bold text-gray-900 mt-10 mb-4">Misi Kami</h2>
            <ul class="list-disc pl-6 space-y-2">
                <li>Menyediakan pangan segar berkualitas tinggi setiap hari.</li>
                <li>Memberikan pengalaman belanja yang nyaman dan terpercaya.</li>
                <li>Mendukung gaya hidup sehat masyarakat luas.</li>
            </ul>
        </div>
    </div>
</div>
@endsection
