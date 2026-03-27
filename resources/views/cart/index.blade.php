@extends('layouts.shop')

@section('title', 'Cart')

@section('content')

<div class="bg-gradient-to-r from-pink-500 to-red-400 py-6">
    <div class="max-w-6xl mx-auto px-6 flex justify-between items-center text-white">
        <h2 class="text-xl font-semibold">Keranjang Belanja</h2>
        <p class="text-sm">Home / Cart</p>
    </div>
</div>

<div class="max-w-6xl mx-auto px-6 py-16">

    @if($cartItems->isNotEmpty())
        {{-- ===== FILTERS & ACTIONS ===== --}}
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
            {{-- Select All & Search --}}
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 flex-1">
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="checkbox" id="selectAll" class="w-5 h-5 rounded border-gray-300 text-pink-500 focus:ring-pink-500 transition cursor-pointer">
                    <span class="text-sm font-bold text-gray-700 group-hover:text-pink-500 transition">Pilih Semua</span>
                </label>
                
                <div class="relative max-w-xs w-full">
                    <input type="text" id="cartSearch" 
                           placeholder="Cari produk..." 
                           class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-pink-400 focus:border-transparent outline-none transition shadow-sm">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            {{-- Categories --}}
            <div class="flex items-center gap-2 overflow-x-auto pb-2 md:pb-0 scrollbar-hide" id="categoryFilters">
                <button type="button" data-category="all" 
                        class="category-btn active px-4 py-2 bg-pink-500 text-white rounded-xl text-xs font-bold shadow-md transition whitespace-nowrap">
                    Semua
                </button>
                @php
                    $categories = $cartItems->map(fn($item) => $item->product->category)->unique('id');
                @endphp
                @foreach($categories as $cat)
                    <button type="button" data-category="{{ $cat->id }}" 
                            class="category-btn px-4 py-2 bg-white border border-gray-100 text-gray-500 rounded-xl text-xs font-bold hover:border-pink-200 hover:text-pink-500 shadow-sm transition whitespace-nowrap">
                        {{ $cat->name }}
                    </button>
                @endforeach
            </div>
        </div>
    @endif

    <form action="{{ route('customer.checkout.index') }}" method="GET" id="checkoutForm">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <table class="w-full text-sm" id="cartTable">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wide">
                    <tr>
                        <th class="px-6 py-4 text-center w-12">#</th>
                        <th class="px-6 py-4 text-left">Produk</th>
                        <th class="px-6 py-4 text-left">Harga</th>
                        <th class="px-6 py-4 text-center">Jumlah</th>
                        <th class="px-6 py-4 text-left">Subtotal</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse($cartItems as $item)
                        @php
                            $subtotal = $item->product->price * $item->qty;
                        @endphp

                        <tr class="cart-item-row hover:bg-gray-50/50 transition" 
                            data-name="{{ strtolower($item->product->name) }}"
                            data-category="{{ $item->product->category_id }}"
                            data-price="{{ $item->product->price }}"
                            data-id="{{ $item->id }}">

                            {{-- CHECKBOX --}}
                            <td class="px-6 py-6 text-center">
                                <input type="checkbox" name="items[]" value="{{ $item->id }}" 
                                       class="item-checkbox w-5 h-5 rounded border-gray-300 text-pink-500 focus:ring-pink-500 transition cursor-pointer">
                            </td>

                            {{-- PRODUCT --}}
                            <td class="px-6 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center shrink-0">
                                        <img src="{{ asset($item->product->image) }}"
                                             class="max-h-14 object-contain">
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800 product-name">
                                            {{ $item->product->name }}
                                        </p>
                                        <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">
                                            {{ $item->product->category->name }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            {{-- PRICE --}}
                            <td class="px-6 py-6 text-gray-600 whitespace-nowrap">
                                Rp {{ number_format($item->product->price) }}
                            </td>

                            {{-- QUANTITY CONTROL --}}
                            <td class="px-6 py-6">
                                <div class="flex justify-center items-center gap-2">
                                    <button type="button" 
                                            onclick="updateQty('{{ $item->product_id }}', 'decrease')"
                                            class="w-8 h-8 bg-gray-50 hover:bg-gray-200 border border-gray-100 rounded-lg font-bold transition">
                                        -
                                    </button>
                                    
                                    <span class="w-8 text-center font-bold text-gray-700 item-qty" id="qty-{{ $item->product_id }}">
                                        {{ $item->qty }}
                                    </span>

                                    <button type="button" 
                                            onclick="updateQty('{{ $item->product_id }}', 'increase')"
                                            class="w-8 h-8 bg-gray-50 hover:bg-gray-200 border border-gray-100 rounded-lg font-bold transition">
                                        +
                                    </button>
                                </div>
                            </td>

                            {{-- TOTAL --}}
                            <td class="px-6 py-6 font-bold text-gray-800 whitespace-nowrap">
                                Rp <span class="row-subtotal" id="subtotal-{{ $item->product_id }}">{{ number_format($subtotal) }}</span>
                            </td>

                            {{-- REMOVE --}}
                            <td class="px-6 py-6 text-center">
                                <form method="POST" action="{{ route('customer.cart.remove', $item->product_id) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-gray-300 hover:text-red-500 transition text-lg p-2" title="Hapus Produk">
                                        🗑
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-20 text-gray-400">
                                <div class="mb-4">
                                    <svg class="w-16 h-16 mx-auto text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                </div>
                                <p class="text-base font-medium">Keranjang belanja kosong.</p>
                                <a href="{{ route('shop.home') }}" class="text-pink-500 hover:underline text-sm mt-2 inline-block">Mulai Belanja</a>
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- ===== HIDDEN QTY FORMS ===== --}}
        {{-- we use JS to submit quantity updates separately --}}
    </form>

    {{-- FOOTER SUMMARY --}}
    @if($cartItems->isNotEmpty())
        <div class="mt-10 bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="flex items-center gap-6">
                <a href="{{ route('shop.home') }}" class="text-gray-500 text-sm font-bold hover:text-pink-500 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                    Lanjut Belanja
                </a>
                <div class="h-8 w-px bg-gray-100 hidden md:block"></div>
                <div class="text-sm text-gray-500 font-bold">
                    <span id="selectedCount">0</span> Produk Terpilih
                </div>
            </div>

            <div class="text-center md:text-right w-full md:w-auto">
                <div class="mb-4">
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mb-1">Total Pesanan</p>
                    <p class="text-3xl font-extrabold text-gray-900">
                        Rp <span id="grandTotal">0</span>
                    </p>
                </div>

                <button type="submit" form="checkoutForm" id="checkoutBtn" disabled
                        class="w-full md:w-auto px-16 py-4 bg-gray-200 text-gray-400 font-extrabold rounded-2xl transition-all text-center cursor-not-allowed uppercase tracking-wider shadow-none">
                    Check Out Sekarang
                </button>
                <p id="checkoutTip" class="text-[10px] text-pink-500 font-bold mt-2 uppercase tracking-widest">Pilih minimal 1 produk untuk checkout</p>
            </div>
        </div>
    @endif

</div>

{{-- Hidden Forms for Qty Update (To keep the primary layout clean) --}}
@foreach($cartItems as $item)
    <form id="increase-form-{{ $item->product_id }}" action="{{ route('customer.cart.increase', $item->product_id) }}" method="POST" style="display:none;">
        @csrf @method('PATCH')
    </form>
    <form id="decrease-form-{{ $item->product_id }}" action="{{ route('customer.cart.decrease', $item->product_id) }}" method="POST" style="display:none;">
        @csrf @method('PATCH')
    </form>
@endforeach

<script>
    function updateQty(productId, action) {
        document.getElementById(`${action}-form-${productId}`).submit();
    }

    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('selectAll');
        const itemCheckboxes = document.querySelectorAll('.item-checkbox');
        const grandTotalDisplay = document.getElementById('grandTotal');
        const selectedCount = document.getElementById('selectedCount');
        const checkoutBtn = document.getElementById('checkoutBtn');
        const checkoutTip = document.getElementById('checkoutTip');
        const rows = document.querySelectorAll('.cart-item-row');
        
        const searchInput = document.getElementById('cartSearch');
        const categoryBtns = document.querySelectorAll('.category-btn');

        let activeCategory = 'all';
        let searchQuery = '';

        function calculateTotal() {
            let total = 0;
            let count = 0;

            itemCheckboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const row = checkbox.closest('.cart-item-row');
                    const price = parseFloat(row.dataset.price);
                    const qty = parseInt(row.querySelector('.item-qty').innerText);
                    total += price * qty;
                    count++;
                }
            });

            grandTotalDisplay.innerText = new Intl.NumberFormat('id-ID').format(total);
            selectedCount.innerText = count;

            if (count > 0) {
                checkoutBtn.disabled = false;
                checkoutBtn.classList.remove('bg-gray-200', 'text-gray-400', 'cursor-not-allowed');
                checkoutBtn.classList.add('bg-pink-500', 'hover:bg-pink-600', 'text-white', 'shadow-lg', 'hover:shadow-pink-200', 'cursor-pointer');
                checkoutTip.classList.add('hidden');
            } else {
                checkoutBtn.disabled = true;
                checkoutBtn.classList.add('bg-gray-200', 'text-gray-400', 'cursor-not-allowed');
                checkoutBtn.classList.remove('bg-pink-500', 'hover:bg-pink-600', 'text-white', 'shadow-lg', 'hover:shadow-pink-200', 'cursor-pointer');
                checkoutTip.classList.remove('hidden');
            }
        }

        function filterItems() {
            rows.forEach(row => {
                const name = row.dataset.name;
                const category = row.dataset.category;
                
                const matchesSearch = name.includes(searchQuery);
                const matchesCategory = activeCategory === 'all' || category === activeCategory;
                
                if (matchesSearch && matchesCategory) {
                    row.classList.remove('hidden');
                } else {
                    row.classList.add('hidden');
                    // auto-uncheck if hidden and search/filter is active? 
                    // optional choice: keep checked but hidden. Better keep checked but hidden.
                }
            });

            // Toggle Empty State for filter
            const visibleRows = document.querySelectorAll('.cart-item-row:not(.hidden)');
            const tbody = document.querySelector('#cartTable tbody');
            let emptyMsg = document.getElementById('filterEmptyMsg');

            if (visibleRows.length === 0 && rows.length > 0) {
                if (!emptyMsg) {
                    emptyMsg = document.createElement('tr');
                    emptyMsg.id = 'filterEmptyMsg';
                    emptyMsg.innerHTML = '<td colspan="6" class="text-center py-12 text-gray-400 italic">Produk tidak ditemukan dengan kriteria tersebut.</td>';
                    tbody.appendChild(emptyMsg);
                }
            } else if (emptyMsg) {
                emptyMsg.remove();
            }
        }

        // --- CHECKBOX EVENTS ---
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                itemCheckboxes.forEach(cb => {
                    // Only check visible ones or all? Standard is all.
                    cb.checked = this.checked;
                });
                calculateTotal();
            });
        }

        itemCheckboxes.forEach(cb => {
            cb.addEventListener('change', () => {
                calculateTotal();
                // If one is unchecked, uncheck "Select All"
                if (!cb.checked && selectAll) selectAll.checked = false;
                // If all are checked, check "Select All"
                const allChecked = Array.from(itemCheckboxes).every(c => c.checked);
                if (allChecked && selectAll) selectAll.checked = true;
            });
        });

        // --- FILTER EVENTS ---
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                searchQuery = e.target.value.toLowerCase();
                filterItems();
            });
        }

        categoryBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                categoryBtns.forEach(b => {
                    b.classList.remove('bg-pink-500', 'text-white', 'shadow-md', 'active');
                    b.classList.add('bg-white', 'text-gray-500', 'border-gray-100');
                });
                btn.classList.add('bg-pink-500', 'text-white', 'shadow-md', 'active');
                btn.classList.remove('bg-white', 'text-gray-500', 'border-gray-100');
                activeCategory = btn.dataset.category;
                filterItems();
            });
        });

        // Initial Calculation
        calculateTotal();
    });
</script>

@endsection