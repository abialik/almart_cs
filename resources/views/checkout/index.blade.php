@extends('layouts.shop')

@section('title', 'Checkout — Almart')

@section('content')

{{-- ===== PAGE HEADER ===== --}}
<div class="bg-gradient-to-r from-pink-500 to-red-400 py-6">
    <div class="max-w-6xl mx-auto px-6 flex justify-between items-center text-white">
        <h2 class="text-xl font-semibold">Checkout</h2>
        <p class="text-sm">
            <a href="{{ route('shop.home') }}" class="hover:underline">Home</a>
            &rsaquo; Checkout
        </p>
    </div>
</div>

<div class="max-w-6xl mx-auto px-6 py-12">

    @if(session('error'))
        <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl text-sm">
            <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-.75-4.75a.75.75 0 001.5 0V9.25a.75.75 0 00-1.5 0v4zm.75-7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('customer.checkout.store') }}" method="POST" id="checkoutForm">
        @csrf
        @foreach($selectedItemIds as $itemId)
            <input type="hidden" name="items[]" value="{{ $itemId }}">
        @endforeach

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">

            {{-- ========== LEFT: ORDER SUMMARY ========== --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

                {{-- Header --}}
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-gray-900">Order Summary</h3>
                    <a href="{{ route('customer.cart.index') }}"
                       class="text-xs text-pink-500 hover:underline flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path d="M15 19l-7-7 7-7"/>
                        </svg>
                        Edit Cart
                    </a>
                </div>

                {{-- Items --}}
                <div class="divide-y divide-gray-100 space-y-1">
                    @foreach($cartItems as $item)
                        @php $lineTotal = $item->product->price * $item->qty; @endphp
                        <div class="flex items-center gap-4 py-4">
                            {{-- Product Image --}}
                            <div class="w-16 h-16 bg-gray-50 rounded-xl border border-gray-100 flex items-center justify-center shrink-0">
                                <img src="{{ asset($item->product->image) }}"
                                     class="max-h-12 max-w-12 object-contain"
                                     alt="{{ $item->product->name }}">
                            </div>

                            {{-- Product Info --}}
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-800 text-sm leading-tight truncate">
                                    {{ $item->product->name }}
                                </p>
                                <div class="flex items-center gap-1 mt-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-3 h-3 {{ $i <= round($item->product->rating ?? 0) ? 'text-yellow-400' : 'text-gray-200' }}"
                                             fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <p class="text-xs text-gray-400 mt-1">
                                    Rp {{ number_format($item->product->price) }} × {{ $item->qty }}
                                </p>
                            </div>

                            {{-- Line Total --}}
                            <div class="text-right shrink-0">
                                <p class="font-bold text-pink-600 text-sm">
                                    Rp {{ number_format($lineTotal) }}
                                </p>
                                @if(($item->product->discount ?? 0) > 0)
                                    <p class="text-xs text-gray-400 line-through">
                                        Rp {{ number_format($item->product->price / (1 - $item->product->discount / 100)) }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Totals --}}
                <div class="mt-4 border-t border-dashed border-gray-200 pt-4 space-y-3 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>Sub-Total</span>
                        <span class="font-medium">Rp {{ number_format($subtotal) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Delivery Charges</span>
                        <span class="font-medium {{ $shippingFee == 0 ? 'text-green-600' : '' }}">
                            {{ $shippingFee == 0 ? 'Free' : 'Rp ' . number_format($shippingFee) }}
                        </span>
                    </div>
                    <div class="flex justify-between border-t border-gray-200 pt-3 font-bold text-gray-900 text-base">
                        <span>Total Amount</span>
                        <span class="text-pink-600">Rp {{ number_format($total) }}</span>
                    </div>
                </div>

            </div>

            {{-- ========== RIGHT: BILLING + PAYMENT ========== --}}
            <div class="space-y-6">

                {{-- Shipping Method --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-5">Metode Pengambilan</h3>
                    <div class="grid grid-cols-2 gap-3">
                        {{-- Delivery Card --}}
                        <label class="shipping-method-card group flex items-center gap-3 p-4 border-2 rounded-xl cursor-pointer transition-all border-pink-500 bg-pink-50" for="ship_delivery">
                            <input type="radio" name="shipping_type" id="ship_delivery" value="delivery" class="hidden shipping-method-input" checked>
                            <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                                <span class="text-xl">🚚</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-800 text-sm leading-tight">Home Delivery</p>
                                <p class="text-gray-400 text-[10px] mt-0.5">Antar ke rumah</p>
                            </div>
                            <svg class="w-5 h-5 text-pink-500 shrink-0 check-icon" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </label>

                        {{-- Pick-up Card --}}
                        <label class="shipping-method-card group flex items-center gap-3 p-4 border-2 rounded-xl cursor-pointer transition-all border-gray-200 hover:border-pink-300 hover:bg-pink-50/40" for="ship_pickup">
                            <input type="radio" name="shipping_type" id="ship_pickup" value="pickup" class="hidden shipping-method-input">
                            <div class="w-10 h-10 rounded-lg bg-orange-50 flex items-center justify-center shrink-0">
                                <span class="text-xl">📦</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-800 text-sm leading-tight">Ambil di Toko</p>
                                <p class="text-gray-400 text-[10px] mt-0.5">Gratis biaya kirim</p>
                            </div>
                            <svg class="w-5 h-5 text-pink-500 shrink-0 check-icon hidden" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </label>
                    </div>
                </div>

                {{-- Billing Details --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-lg font-bold text-gray-900">Billing Details</h3>
                        @if($addresses->isNotEmpty())
                            <button type="button" id="btnAddNewAddress" 
                                    class="text-xs font-bold text-pink-500 hover:text-pink-600 transition truncate flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                </svg>
                                Tambah Alamat Baru
                            </button>
                        @endif
                    </div>

                    <div class="space-y-6">

                        {{-- ADDRESS SELECTION CARDS --}}
                        @if($addresses->isNotEmpty())
                            <div class="grid grid-cols-1 gap-3" id="addressSelectionArea">
                                <input type="hidden" name="address_id" id="selectedAddressId" value="{{ $addresses->first()->id }}">
                                
                                @foreach($addresses as $addr)
                                    <label class="address-card group relative flex flex-col p-4 border-2 rounded-xl cursor-pointer transition-all {{ $loop->first ? 'border-pink-500 bg-pink-50' : 'border-gray-100 hover:border-pink-200 hover:bg-pink-50/30' }}" 
                                            data-address-id="{{ $addr->id }}">
                                        
                                        <div class="flex justify-between items-start mb-2">
                                            <span class="px-2 py-0.5 bg-gray-100 text-[10px] font-bold text-gray-500 rounded uppercase tracking-wider">{{ $addr->label }}</span>
                                            <svg class="w-5 h-5 text-pink-500 check-icon {{ $loop->first ? 'block' : 'hidden' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>

                                        <p class="font-bold text-gray-900 text-sm mb-1">{{ $addr->full_name }}</p>
                                        <p class="text-xs text-gray-500 leading-relaxed">{{ $addr->address }}, {{ $addr->city }}, {{ $addr->province }} {{ $addr->post_code }}</p>
                                        <p class="text-[11px] text-gray-400 mt-2 font-medium">{{ $addr->phone }}</p>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <input type="hidden" name="address_id" value="">
                        @endif

                        {{-- NEW ADDRESS FORM --}}
                        <div id="newAddressForm" class="{{ $addresses->isNotEmpty() ? 'hidden border-t border-gray-100 pt-6' : '' }} space-y-4">
                            @if($addresses->isNotEmpty())
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-sm font-bold text-gray-800">Alamat Baru</h4>
                                    <button type="button" id="btnCancelNewAddress" class="text-xs text-gray-400 hover:text-gray-600 transition">Batal</button>
                                </div>
                            @endif

                            {{-- Full Name --}}
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="full_name"
                                       value="{{ old('full_name', auth()->user()->name) }}"
                                       placeholder="Enter your full name"
                                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition {{ $errors->has('full_name') ? 'border-red-400 bg-red-50' : 'bg-gray-50 focus:bg-white' }}">
                                @error('full_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Address --}}
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">
                                    Address <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="address"
                                       value="{{ old('address') }}"
                                       placeholder="Address Line 1"
                                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition {{ $errors->has('address') ? 'border-red-400 bg-red-50' : 'bg-gray-50 focus:bg-white' }}">
                                @error('address')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- City & Post Code --}}
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">
                                        City <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="city"
                                           value="{{ old('city') }}"
                                           placeholder="City"
                                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition {{ $errors->has('city') ? 'border-red-400 bg-red-50' : 'bg-gray-50 focus:bg-white' }}">
                                    @error('city')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">
                                        Post Code <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="post_code"
                                           value="{{ old('post_code') }}"
                                           placeholder="Post Code"
                                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition {{ $errors->has('post_code') ? 'border-red-400 bg-red-50' : 'bg-gray-50 focus:bg-white' }}">
                                    @error('post_code')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Province & Phone --}}
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">
                                        Province <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="province"
                                           value="{{ old('province') }}"
                                           placeholder="Province"
                                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition {{ $errors->has('province') ? 'border-red-400 bg-red-50' : 'bg-gray-50 focus:bg-white' }}">
                                    @error('province')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">
                                        Phone <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="phone"
                                           value="{{ old('phone', auth()->user()->phone ?? '') }}"
                                           placeholder="Phone number"
                                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition {{ $errors->has('phone') ? 'border-red-400 bg-red-50' : 'bg-gray-50 focus:bg-white' }}">
                                    @error('phone')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Payment Method --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-5">Payment Method</h3>

                    @error('payment_method')
                        <p class="text-red-500 text-xs mb-3">{{ $message }}</p>
                    @enderror

                    <div class="grid grid-cols-2 gap-3">

                        {{-- Transfer Bank --}}
                        <label class="payment-method-card group flex items-center gap-3 p-4 border-2 rounded-xl cursor-pointer transition-all {{ old('payment_method') == 'transfer' ? 'border-pink-500 bg-pink-50' : 'border-gray-200 hover:border-pink-300 hover:bg-pink-50/40' }}" for="method_transfer">
                            <input type="radio" name="payment_method" id="method_transfer" value="transfer" class="hidden payment-method-input" {{ old('payment_method') == 'transfer' ? 'checked' : '' }}>
                            <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M3 10h18M3 7l9-4 9 4M4 10h1v11H4V10zm6 0h1v11h-1V10zm5 0h1v11h-1V10zm5 0h1v11h-1V10z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-800 text-sm leading-tight">Transfer Bank</p>
                                <p class="text-gray-400 text-xs mt-0.5">BCA, Mandiri, BNI</p>
                            </div>
                            <svg class="w-5 h-5 text-pink-500 shrink-0 check-icon {{ old('payment_method') == 'transfer' ? 'block' : 'hidden' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </label>

                        {{-- E-Wallet --}}
                        <label class="payment-method-card group flex items-center gap-3 p-4 border-2 rounded-xl cursor-pointer transition-all {{ old('payment_method') == 'ewallet' ? 'border-pink-500 bg-pink-50' : 'border-gray-200 hover:border-pink-300 hover:bg-pink-50/40' }}" for="method_ewallet">
                            <input type="radio" name="payment_method" id="method_ewallet" value="ewallet" class="hidden payment-method-input" {{ old('payment_method') == 'ewallet' ? 'checked' : '' }}>
                            <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-800 text-sm leading-tight">E-Wallet</p>
                                <p class="text-gray-400 text-xs mt-0.5">GoPay, OVO, Dana</p>
                            </div>
                            <svg class="w-5 h-5 text-pink-500 shrink-0 check-icon {{ old('payment_method') == 'ewallet' ? 'block' : 'hidden' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </label>

                        {{-- QRIS --}}
                        <label class="payment-method-card group flex items-center gap-3 p-4 border-2 rounded-xl cursor-pointer transition-all {{ old('payment_method') == 'qris' ? 'border-pink-500 bg-pink-50' : 'border-gray-200 hover:border-pink-300 hover:bg-pink-50/40' }}" for="method_qris">
                            <input type="radio" name="payment_method" id="method_qris" value="qris" class="hidden payment-method-input" {{ old('payment_method') == 'qris' ? 'checked' : '' }}>
                            <div class="w-10 h-10 rounded-lg bg-orange-50 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-800 text-sm leading-tight">QRIS</p>
                                <p class="text-gray-400 text-xs mt-0.5">Scan & Pay</p>
                            </div>
                            <svg class="w-5 h-5 text-pink-500 shrink-0 check-icon {{ old('payment_method') == 'qris' ? 'block' : 'hidden' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </label>

                        {{-- COD --}}
                        <label class="payment-method-card group flex items-center gap-3 p-4 border-2 rounded-xl cursor-pointer transition-all {{ old('payment_method') == 'cod' ? 'border-pink-500 bg-pink-50' : 'border-gray-200 hover:border-pink-300 hover:bg-pink-50/40' }}" for="method_cod">
                            <input type="radio" name="payment_method" id="method_cod" value="cod" class="hidden payment-method-input" {{ old('payment_method') == 'cod' ? 'checked' : '' }}>
                            <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 0M13 16l2 0m0 0l.5-4.5M15 16h4l1-5H13.5M3 6l1-2h8l1 2"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-800 text-sm leading-tight">COD</p>
                                <p class="text-gray-400 text-xs mt-0.5">Bayar di tempat</p>
                            </div>
                            <svg class="w-5 h-5 text-pink-500 shrink-0 check-icon {{ old('payment_method') == 'cod' ? 'block' : 'hidden' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </label>

                    </div>
                </div>

            </div>
        </div>

        {{-- ========== PLACE ORDER BUTTON ========== --}}
        <div class="mt-10">
            <button type="submit" id="btnPlaceOrder"
                    class="w-full py-4 bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600
                           text-white font-bold text-lg rounded-2xl shadow-lg hover:shadow-xl
                           transform hover:-translate-y-0.5 transition-all duration-200
                           flex items-center justify-center gap-3">
                <span id="btnText" class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Place Order
                </span>
            </button>
        </div>

    </form>

</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Address method selection
    const addressCards = document.querySelectorAll('.address-card');
    const selectedAddressInput = document.getElementById('selectedAddressId');
    const newAddressForm = document.getElementById('newAddressForm');
    const addressSelectionArea = document.getElementById('addressSelectionArea');
    const btnAddNewAddress = document.getElementById('btnAddNewAddress');
    const btnCancelNewAddress = document.getElementById('btnCancelNewAddress');

    addressCards.forEach(card => {
        card.addEventListener('click', () => {
            // Reset all address cards
            addressCards.forEach(c => {
                c.classList.remove('border-pink-500', 'bg-pink-50');
                c.classList.add('border-gray-100');
                c.querySelector('.check-icon').classList.add('hidden');
                c.querySelector('.check-icon').classList.remove('block');
            });
            // Activate clicked
            card.classList.add('border-pink-500', 'bg-pink-50');
            card.classList.remove('border-gray-100');
            card.querySelector('.check-icon').classList.remove('hidden');
            card.querySelector('.check-icon').classList.add('block');
            
            selectedAddressInput.value = card.dataset.addressId;
        });
    });

    if (btnAddNewAddress) {
        btnAddNewAddress.addEventListener('click', () => {
            newAddressForm.classList.remove('hidden');
            if (addressSelectionArea) addressSelectionArea.classList.add('hidden');
            btnAddNewAddress.classList.add('hidden');
            selectedAddressInput.value = ''; // Clear selected address
        });
    }

    if (btnCancelNewAddress) {
        btnCancelNewAddress.addEventListener('click', () => {
            newAddressForm.classList.add('hidden');
            if (addressSelectionArea) addressSelectionArea.classList.remove('hidden');
            btnAddNewAddress.classList.remove('hidden');
            
            // Restore first address as selected
            const firstCard = addressCards[0];
            if (firstCard) firstCard.click();
        });
    }

    // Payment method selection
    const paymentCards = document.querySelectorAll('.payment-method-card');
    paymentCards.forEach(card => {
        card.addEventListener('click', () => {
            // Reset all
            paymentCards.forEach(c => {
                c.classList.remove('border-pink-500', 'bg-pink-50');
                c.classList.add('border-gray-200');
                c.querySelector('.check-icon').classList.add('hidden');
                c.querySelector('.check-icon').classList.remove('block');
            });
            // Activate clicked
            card.classList.add('border-pink-500', 'bg-pink-50');
            card.classList.remove('border-gray-200');
            card.querySelector('.check-icon').classList.remove('hidden');
            card.querySelector('.check-icon').classList.add('block');
            
            const radio = card.querySelector('input[type="radio"]');
            if (radio) radio.checked = true;
        });
    });

    // Shipping method selection
    const shippingCards = document.querySelectorAll('.shipping-method-card');
    const shippingInputs = document.querySelectorAll('.shipping-method-input');
    // Find billing title robustly
    const billingTitle = Array.from(document.querySelectorAll('h3')).find(el => el.textContent.trim() === 'Billing Details');
    
    shippingCards.forEach(card => {
        card.addEventListener('click', () => {
            // Reset all
            shippingCards.forEach(c => {
                c.classList.remove('border-pink-500', 'bg-pink-50');
                c.classList.add('border-gray-200');
                c.querySelector('.check-icon').classList.add('hidden');
                c.querySelector('.check-icon').classList.remove('block');
            });
            // Activate clicked
            card.classList.add('border-pink-500', 'bg-pink-50');
            card.classList.remove('border-gray-200');
            card.querySelector('.check-icon').classList.remove('hidden');
            card.querySelector('.check-icon').classList.add('block');
            
            const radio = card.querySelector('input[type="radio"]');
            if (radio) {
                radio.checked = true;
                // Update UI based on selection if needed
                const pickupInfo = document.getElementById('pickupInfoMessage');
                if (radio.value === 'pickup') {
                    if (!pickupInfo) {
                        const msg = document.createElement('div');
                        msg.id = 'pickupInfoMessage';
                        msg.className = 'mt-4 p-4 bg-orange-50 border border-orange-100 rounded-xl text-xs text-orange-700 leading-relaxed animate-fade-in';
                        msg.innerHTML = '<strong>Informasi Pick-up:</strong> Silakan lengkapi identitas pengambil di bawah. Pesanan dapat diambil di toko setelah status berubah menjadi "Siap Diambil".';
                        card.closest('.bg-white').appendChild(msg);
                    }
                } else {
                    if (pickupInfo) pickupInfo.remove();
                }
            }
        });
    });

    // Prevent double submission
    const checkoutForm = document.getElementById('checkoutForm');
    const btnPlaceOrder = document.getElementById('btnPlaceOrder');
    const btnText = document.getElementById('btnText');

    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function() {
            if (btnPlaceOrder) {
                btnPlaceOrder.disabled = true;
                btnPlaceOrder.classList.add('opacity-75', 'cursor-not-allowed');
                if (btnText) {
                    btnText.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Processing...';
                }
            }
        });
    }
});
</script>

@endsection
