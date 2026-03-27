@extends('layouts.shop')

@section('title', 'Informasi Pengiriman — Almart')

@section('content')
<div class="bg-gray-50 min-h-screen py-20">
    <div class="max-w-4xl mx-auto px-6 bg-white rounded-3xl shadow-sm border border-gray-100 p-10 sm:p-16">
        <h1 class="text-4xl font-black text-gray-900 mb-8 tracking-tighter">Informasi Pengiriman</h1>
        <div class="prose max-w-none text-gray-600 space-y-6">
            <p>Kami berkomitmen untuk mengantarkan produk pesanan Anda dalam kondisi segar dan tepat waktu.</p>
            
            <h2 class="text-2xl font-bold text-gray-900 mt-10 mb-4">Area Pengiriman</h2>
            <p>Saat ini kami melayani pengiriman untuk area Depok dan sekitarnya. Kami terus memperluas jangkauan layanan kami.</p>

            <h2 class="text-2xl font-bold text-gray-900 mt-10 mb-4">Waktu Pengiriman</h2>
            <p>Pesanan yang masuk sebelum pukul 10:00 WIB akan dikirim pada hari yang sama. Setelah jam tersebut, pengiriman akan dilakukan keesokan harinya.</p>
        </div>
    </div>
</div>
@endsection
