@extends('layouts.shop')

@section('title', 'FAQ — Almart')

@section('content')
<div class="bg-gray-50 min-h-screen py-20">
    <div class="max-w-4xl mx-auto px-6 bg-white rounded-3xl shadow-sm border border-gray-100 p-10 sm:p-16">
        <h1 class="text-4xl font-black text-gray-900 mb-8 tracking-tighter">Frequently Asked Questions</h1>
        <div class="space-y-8">
            <div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 italic">Bagaimana cara memesan di Almart?</h3>
                <p class="text-gray-600 tracking-wide">Cukup pilih produk yang Anda inginkan, masukkan ke keranjang, dan ikuti instruksi pembayaran di halaman checkout.</p>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 italic">Berapa biaya pengirimannya?</h3>
                <p class="text-gray-600 tracking-wide">Biaya pengiriman ditentukan berdasarkan jarak dan lokasi pengiriman Anda. Detail biaya akan muncul saat pengisian alamat di checkout.</p>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 italic">Apakah bisa retur barang?</h3>
                <p class="text-gray-600 tracking-wide">Ya, silakan masuk ke detail pesanan Anda dan klik tombol "Ajukan Pengembalian" jika barang yang diterima bermasalah atau tidak sesuai.</p>
            </div>
        </div>
    </div>
</div>
@endsection
