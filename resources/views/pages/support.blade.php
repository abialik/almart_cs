@extends('layouts.shop')

@section('title', 'Pusat Bantuan — Almart')

@section('content')
<div class="bg-gray-50 min-h-screen py-20">
    <div class="max-w-4xl mx-auto px-6 bg-white rounded-3xl shadow-sm border border-gray-100 p-10 sm:p-16">
        <h1 class="text-4xl font-black text-gray-900 mb-8 tracking-tighter">Pusat Bantuan</h1>
        <div class="space-y-6 text-gray-600">
            <p>Butuh bantuan lebih lanjut terkait layanan Almart? Tim support kami siap membantu Anda dengan segala kendala teknis maupun operasional.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-10">
                <div class="p-6 border border-gray-100 rounded-2xl">
                    <h3 class="font-bold text-gray-900 mb-2">Bantuan Akun</h3>
                    <p class="text-sm">Kendala login, ubah profile, atau keamanan akun.</p>
                </div>
                <div class="p-6 border border-gray-100 rounded-2xl">
                    <h3 class="font-bold text-gray-900 mb-2">Bantuan Pesanan</h3>
                    <p class="text-sm">Status pengiriman, konfirmasi pembayaran, dan retur.</p>
                </div>
            </div>
            
            <p class="mt-10 italic">Hubungi kami melalui halaman <a href="{{ route('pages.contact') }}" class="text-green-600 font-bold underline">Kontak</a> jika bantuan di atas tidak menyelesaikan masalah Anda.</p>
        </div>
    </div>
</div>
@endsection
