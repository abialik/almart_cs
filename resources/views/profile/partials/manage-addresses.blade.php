<section class="mt-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-xl font-bold text-gray-900">Alamat Saya</h3>
            <p class="text-sm text-gray-500 mt-1">Kelola alamat pengiriman kamu untuk checkout yang lebih cepat.</p>
        </div>
        <button type="button" onclick="toggleAddressForm()" class="px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white text-sm font-bold rounded-xl transition shadow-md hover:shadow-lg flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Alamat
        </button>
    </div>

    {{-- Form Tambah Alamat (Hidden by default) --}}
    <div id="addressFormSection" class="hidden mb-8 bg-gray-50 rounded-2xl p-6 border border-gray-100">
        <h4 id="formTitle" class="text-sm font-bold text-gray-800 mb-4 uppercase tracking-wider">Tambah Alamat Baru</h4>
        <form id="addressForm" action="{{ route('addresses.store') }}" method="POST">
            @csrf
            <div id="methodField"></div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase">Label Alamat (ex: Rumah, Kantor)</label>
                    <input type="text" name="label" id="label" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-pink-400 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase">Nama Lengkap</label>
                    <input type="text" name="full_name" id="full_name" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-pink-400 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase">Nomor HP</label>
                    <input type="text" name="phone" id="phone" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-pink-400 focus:outline-none">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase">Alamat Lengkap</label>
                    <textarea name="address" id="address" required rows="2" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-pink-400 focus:outline-none"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase">Kota</label>
                    <input type="text" name="city" id="city" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-pink-400 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase">Provinsi</label>
                    <input type="text" name="province" id="province" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-pink-400 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase">Kode Pos</label>
                    <input type="text" name="post_code" id="post_code" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-pink-400 focus:outline-none">
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="toggleAddressForm()" class="px-5 py-2 text-sm font-bold text-gray-500 hover:text-gray-700 transition">Batal</button>
                <button type="submit" class="px-6 py-2 bg-gray-900 text-white text-sm font-bold rounded-xl hover:bg-black transition shadow-md">Simpan Alamat</button>
            </div>
        </form>
    </div>

    {{-- Daftar Alamat --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse(auth()->user()->addresses as $addr)
            <div class="relative p-5 border-2 {{ $addr->is_default ? 'border-pink-500 bg-pink-50/30' : 'border-gray-100' }} rounded-2xl group transition-all hover:shadow-md">
                <div class="flex justify-between items-start mb-3">
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-0.5 bg-white border border-gray-200 text-[10px] font-bold text-gray-500 rounded uppercase tracking-wider">{{ $addr->label }}</span>
                        @if($addr->is_default)
                            <span class="px-2 py-0.5 bg-pink-500 text-[10px] font-bold text-white rounded uppercase tracking-wider">Utama</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button onclick="editAddress({{ json_encode($addr) }})" class="p-1.5 bg-white border border-gray-200 text-gray-400 hover:text-pink-500 rounded-lg transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </button>
                        @if(!$addr->is_default)
                            <form action="{{ route('addresses.destroy', $addr->id) }}" method="POST" onsubmit="return confirm('Hapus alamat ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-1.5 bg-white border border-gray-200 text-gray-400 hover:text-red-500 rounded-lg transition shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <p class="font-bold text-gray-900 mb-1">{{ $addr->full_name }}</p>
                <p class="text-xs text-gray-500 leading-relaxed mb-3">{{ $addr->address }}, {{ $addr->city }}, {{ $addr->province }} {{ $addr->post_code }}</p>
                <p class="text-[11px] font-bold text-gray-400 tracking-wide">{{ $addr->phone }}</p>

                @if(!$addr->is_default)
                    <form action="{{ route('addresses.set-default', $addr->id) }}" method="POST" class="mt-4">
                        @csrf @method('PATCH')
                        <button type="submit" class="text-xs font-bold text-pink-500 hover:text-pink-600 transition">Set Sebagai Utama</button>
                    </form>
                @endif
            </div>
        @empty
            <div class="col-span-full py-12 bg-gray-50 rounded-2xl border border-dashed border-gray-200 flex flex-col items-center justify-center text-center">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-sm mb-4">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <p class="text-gray-500 font-medium">Belum ada alamat tersimpan.</p>
                <p class="text-xs text-gray-400 mt-1">Tambah alamat untuk memudahkan checkout pesananmu.</p>
            </div>
        @endforelse
    </div>
</section>

<script>
    function toggleAddressForm() {
        const section = document.getElementById('addressFormSection');
        const form = document.getElementById('addressForm');
        const methodField = document.getElementById('methodField');
        const title = document.getElementById('formTitle');

        if (section.classList.contains('hidden')) {
            section.classList.remove('hidden');
            form.reset();
            form.action = "{{ route('addresses.store') }}";
            methodField.innerHTML = '';
            title.innerText = 'Tambah Alamat Baru';
            section.scrollIntoView({ behavior: 'smooth' });
        } else {
            section.classList.add('hidden');
        }
    }

    function editAddress(addr) {
        const section = document.getElementById('addressFormSection');
        const form = document.getElementById('addressForm');
        const methodField = document.getElementById('methodField');
        const title = document.getElementById('formTitle');

        section.classList.remove('hidden');
        title.innerText = 'Edit Alamat';
        form.action = `/addresses/${addr.id}`;
        methodField.innerHTML = '<input type="hidden" name="_method" value="PATCH">';
        
        document.getElementById('label').value = addr.label;
        document.getElementById('full_name').value = addr.full_name;
        document.getElementById('phone').value = addr.phone;
        document.getElementById('address').value = addr.address;
        document.getElementById('city').value = addr.city;
        document.getElementById('province').value = addr.province;
        document.getElementById('post_code').value = addr.post_code;

        section.scrollIntoView({ behavior: 'smooth' });
    }
</script>
