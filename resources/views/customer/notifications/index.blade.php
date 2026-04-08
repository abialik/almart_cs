@extends('layouts.shop')

@section('title', 'Kotak Masuk — Almart')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-6">
        
        <div class="flex items-center justify-between mb-10">
            <div>
                <h2 class="text-3xl font-black text-gray-900 tracking-tighter">Kotak Masuk</h2>
                <p class="text-sm text-gray-500 mt-1">Pantau perkembangan pesanan dan informasi terbaru Anda.</p>
            </div>
            @if(auth()->user()->unreadNotifications->count() > 0)
                <form action="{{ route('customer.inbox.mark-all-read') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-xs font-bold text-rose-500 hover:text-rose-600 transition flex items-center gap-2 bg-rose-50 px-4 py-2 rounded-xl">
                        <i data-lucide="check-check" class="w-4 h-4"></i> Tandai Semua Dibaca
                    </button>
                </form>
            @endif
        </div>

        <div class="space-y-4">
            @forelse($notifications as $notification)
                <a href="{{ route('customer.inbox.show', $notification->id) }}" 
                   class="block bg-white rounded-2xl border {{ $notification->read_at ? 'border-gray-100' : 'border-rose-100 bg-rose-50/30' }} p-6 hover:shadow-lg transition duration-300 relative group">
                    
                    @if(!$notification->read_at)
                        <div class="absolute top-6 right-6 w-2 h-2 bg-rose-500 rounded-full"></div>
                    @endif

                    <div class="flex gap-5">
                        <div class="w-12 h-12 rounded-xl {{ $notification->read_at ? 'bg-gray-100 text-gray-400' : 'bg-rose-100 text-rose-500' }} flex items-center justify-center shrink-0">
                            <i data-lucide="{{ $notification->read_at ? 'mail-open' : 'mail' }}" class="w-6 h-6"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-1">
                                <h3 class="font-bold {{ $notification->read_at ? 'text-gray-700' : 'text-gray-900' }}">
                                    Update Pesanan #{{ $notification->data['order_code'] ?? '---' }}
                                </h3>
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-sm {{ $notification->read_at ? 'text-gray-500' : 'text-gray-600 font-medium' }} leading-relaxed">
                                {{ $notification->data['message'] }}
                            </p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="bg-white rounded-3xl p-16 text-center border border-gray-100 shadow-sm">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i data-lucide="inbox" class="w-10 h-10 text-gray-200"></i>
                    </div>
                    <h3 class="text-gray-900 font-black text-xl mb-1">Pesan masih kosong</h3>
                    <p class="text-gray-400 text-sm">Belum ada notifikasi baru untuk Anda saat ini.</p>
                </div>
            @endforelse

            <div class="mt-8">
                {{ $notifications->links() }}
            </div>
        </div>

    </div>
</div>
@endsection
