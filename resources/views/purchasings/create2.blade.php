<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight flex items-center gap-2">
            <button type="button" onclick="window.location='{{ route('purchasing.menu') }}'"
                class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded shadow transition">
                🔙
            </button>
            🛒 {{ __('Halaman Pembelian Barang') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-md rounded-xl p-8 space-y-6">
                <form action="{{ route('purchasing.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Customer Info -->
           <div class="mb-6">
            <label for="customerSearch" class="block text-sm font-medium text-gray-700 mb-1">Cari Customer</label>
            <select name="idCustomer" class="select-customer w-full">
                <option value="">-- Pilih Customer --</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->idCustomer }}">{{ $customer->nama }}</option>
                @endforeach
            </select>
        </div>


                    <!-- Product Info -->
                    <div>
                        <h3
                            class="text-xl font-semibold text-green-700 mb-4 border-b pb-2 py-3 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M20.25 8.511l-8.25 4.74-8.25-4.74M12 3l9 5.25v7.5l-9 5.25-9-5.25v-7.5L12 3z" />
                            </svg>
                            Data Produk
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <input type="text" name="namaBarang" placeholder="Nama Barang" class="input" required>
                            <input type="text" name="type" placeholder="Type" class="input" required>
                            <input type="text" name="spek" placeholder="Spesifikasi" class="input" required>

                            <input type="text" name="serialNumber" placeholder="Serial Number" class="input">

                            <select name="idCategory" class="input" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->idCategory }}">{{ $category->namaKategori }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                            <input type="number" name="jumlah" placeholder="Jumlah" class="input" required min="1">
                            <input type="number" name="hargaBeli" placeholder="Harga Beli /pcs" class="input" required
                                min="0">
                            <input type="number" name="hargaJual" placeholder="Harga Jual /pcs" class="input" required
                                min="0">
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="pt-6 flex justify-end space-x-4">
                        <button type="submit"
                            class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                            💾 Simpan Transaksi
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    @push('styles')
        <style>
            .input {
                @apply w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400;
            }
        </style>
    @endpush

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
