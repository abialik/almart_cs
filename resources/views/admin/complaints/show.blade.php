@extends('layouts.admin')

@section('title', 'Detail Keluhan')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.complaints.index') }}" class="w-10 h-10 bg-white border border-gray-200 text-gray-500 rounded-xl flex items-center justify-center hover:bg-gray-50 hover:text-gray-700 transition">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Detail Keluhan #{{ $complaint->id }}</h2>
            <p class="text-sm text-gray-500 mt-1">Diajukan pada {{ $complaint->created_at->format('d M Y, H:i') }}</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Complaint Info -->
    <div class="lg:col-span-2 space-y-6">
        @if(session('success'))
            <div class="p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 font-medium flex items-center gap-3">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm relative overflow-hidden">
            <!-- Status Badge in Top Right -->
            <div class="absolute top-8 right-8">
                @if($complaint->status == 'pending')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-orange-50 text-orange-600 text-xs font-bold border border-orange-100">
                        <i data-lucide="clock" class="w-4 h-4"></i> Menunggu Tanggapan
                    </span>
                @elseif($complaint->status == 'responded')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-blue-50 text-blue-600 text-xs font-bold border border-blue-100">
                        <i data-lucide="reply" class="w-4 h-4"></i> Ditanggapi
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-green-50 text-green-600 text-xs font-bold border border-green-100">
                        <i data-lucide="check-circle" class="w-4 h-4"></i> Selesai
                    </span>
                @endif
            </div>

            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                <i data-lucide="user" class="text-gray-400 w-5 h-5"></i> Informasi Pelanggan
            </h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-12 mb-8">
                <div>
                    <p class="text-sm text-gray-500 font-medium mb-1">Nama</p>
                    <p class="font-bold text-gray-900">{{ $complaint->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium mb-1">Email</p>
                    <p class="font-bold text-gray-900">{{ $complaint->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium mb-1">No. WhatsApp</p>
                    <p class="font-bold text-gray-900">{{ $complaint->phone ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium mb-1">Nomor Pesanan</p>
                    <p class="font-bold text-gray-900">{{ $complaint->order_number ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium mb-1">Jenis Keluhan</p>
                    <p class="font-bold text-gray-900 bg-gray-50 inline-block px-3 py-1 rounded-lg">{{ $complaint->complaint_type }}</p>
                </div>
            </div>

            <hr class="border-gray-100 mb-8">

            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i data-lucide="message-square" class="text-gray-400 w-5 h-5"></i> Detail Keluhan
            </h3>
            <div class="bg-gray-50/50 p-6 rounded-2xl border border-gray-100">
                <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $complaint->description }}</p>
            </div>
        </div>

    </div>

    <!-- Response Form -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm sticky top-8">
            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                <i data-lucide="pencil" class="text-blue-500 w-5 h-5"></i> Tanggapan Admin
            </h3>
            
            <form action="{{ route('admin.complaints.respond', $complaint) }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')

                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Update Status</label>
                    <div class="relative">
                        <select id="status" name="status" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white text-sm appearance-none font-medium">
                            <option value="pending" {{ $complaint->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="responded" {{ $complaint->status == 'responded' ? 'selected' : '' }}>Ditanggapi (Sedang diproses)</option>
                            <option value="resolved" {{ $complaint->status == 'resolved' ? 'selected' : '' }}>Selesai (Resolved)</option>
                        </select>
                        <i data-lucide="chevron-down" class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                    </div>
                </div>

                <div>
                    <label for="admin_response" class="block text-sm font-semibold text-gray-700 mb-2">Isi Tanggapan</label>
                    <textarea id="admin_response" name="admin_response" rows="8" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white text-sm resize-none" placeholder="Tulis catatan atau pesan tanggapan di sini..." required>{{ old('admin_response', $complaint->admin_response) }}</textarea>
                    <p class="text-xs text-gray-400 mt-2">*Tanggapan ini direkam ke sistem untuk keperluan historis.</p>
                </div>

                <button type="submit" class="w-full py-3.5 bg-blue-600 text-white font-bold rounded-xl shadow-lg shadow-blue-200 hover:bg-blue-700 hover:-translate-y-0.5 transition-all">
                    Simpan Tanggapan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
