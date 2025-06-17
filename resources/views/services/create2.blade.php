<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Service') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <form action="{{ route('service.storee') }}" method="POST">
                    @csrf

                    {{-- Data Customer --}}
                    <div class="mb-6 border-b pb-4">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 10a4 4 0 100-8 4 4 0 000 8zm0 2c-3.333 0-10 1.667-10 5v1h20v-1c0-3.333-6.667-5-10-5z"/>
                            </svg>
                            <h3 class="text-blue-700 font-bold">Data Customer</h3>
                        </div>
                        <div class="mb-6">
                            <label for="customerSearch" class="block text-sm font-medium text-gray-700 mb-1">Cari Customer</label>
                            <select name="idCustomer" class="select-customer w-full">
                                <option value="">-- Pilih Customer --</option>
                                @foreach ($customers as $customer)
                               <option value="{{ $customer->idCustomer }}">{{ $customer->noTelp }} - {{ $customer->nama }}</option>

                                @endforeach
                            </select>
                        </div>
                    <a href="{{ route('service.create') }}" class="mt-2 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 ">
                       Pelanggan Baru
                   </a>
                    </div>
                    

                    {{-- Data Produk / Service --}}
                                 <div class="mb-3">
                            <div class="flex items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <!-- Ikon kombinasi kunci inggris + gear -->
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <h3 class="text-green-500 font-bold">Data Service</h3>
                            </div>
                        </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                            <div>
                            <label class="block font-medium text-gray-700 mb-1">Nama Barang / Jenis Perangkat</label>
                            <input type="text" name="jenisPerangkat" class="border px-3 py-2 rounded w-full mb-2"required>
                        </div>
                         <div>
                            <label class="block font-medium text-gray-700 mb-1">Kerusakan (dapat diisi nanti)</label>
                            <input type="text" name="kerusakan" class="border px-3 py-2 rounded w-full mb-2">
                        </div> <div>
                            <label class="block font-medium text-gray-700 mb-1">Kondisi awal</label>
                            <input type="text" name="kondisi" class="border px-3 py-2 rounded w-full mb-2"  required>
                        </div> <div>
                            <label class="block font-medium text-gray-700 mb-1">Kelengkapan</label>
                            <input type="text" name="kelengkapan" class="border px-3 py-2 rounded w-full mb-2"  required>
                        </div>
                        
                            {{-- <input type="text" name="keterangan" class="border px-3 py-2 rounded w-full mb-2" placeholder="Kelengkapan" required> --}}
                            {{-- <input type="text" name="ciriCiri" class="border px-3 py-2 rounded w-full mb-2" placeholder="Ciri-ciri barang" required> --}}
                        </div>
                        <div class="mb-3">
                            <label for="ciriCiri" class="block text-sm font-medium text-gray-600 mb-1">Ciri-ciri Barang:</label>
                            <textarea name="ciriCiri" id="ciriCiri" class="w-full border rounded px-3 py-2 text-sm text-gray-800 resize-none" rows="5"></textarea>
                        </div>
                        
                        
                        {{-- Tombol Submit --}}
                        <div class="text-center pt-5 ">
                            <button type="button" onclick="window.location='{{ route('service.index') }}'"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded shadow transition">
                            🔙
                        </button>
                        <button type="submit" class="bg-blue-600 justify-center ml-4 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded inline-flex ">
                            
                            💾 Simpan 
                        </button>
                          
                        </div>
                    </form>
                    </div>
            </div>
        </div>
    </div>
      @push('scripts')
        <script>
            function fillCustomerData(select) {
                const selectedOption = select.options[select.selectedIndex];
                if (!selectedOption.value) return;

                const namaInput = document.getElementById('nama');
                const noTelpInput = document.getElementById('noTelp');
                const alamatInput = document.getElementById('alamat');
                const noKtpInput = document.getElementById('noKtp');

                if (namaInput) namaInput.value = selectedOption.dataset.nama || '';
                if (noTelpInput) noTelpInput.value = selectedOption.dataset['noTelp'] || '';
                if (alamatInput) alamatInput.value = selectedOption.dataset['alamat'] || '';
                if (noKtpInput) noKtpInput.value = selectedOption.dataset['noKtp'] || '';
            }
        </script>
    @endpush
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('.select-customer').select2({
            placeholder: "-- Pilih Customer --",
            allowClear: true
        });
    });
</script>
</x-app-layout>
