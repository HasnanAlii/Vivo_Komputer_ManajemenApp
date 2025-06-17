<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight flex items-center gap-2">
            <button type="button" onclick="window.location='{{ route('purchasing.index') }}'"
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
                <form action="{{ route('purchasing.storee') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Customer Info -->
                    <div class="mb-6">
                        <label for="customerSearch" class="block text-sm font-medium text-gray-700 mb-1">Cari Customer</label>
                        <select name="idCustomer" class="select-customer w-full">
                            <option value="">-- Pilih Customer --</option>
                            @foreach ($customers as $customer)
                            <option value="{{ $customer->idCustomer }}">{{ $customer->noTelp }} - {{ $customer->nama }}</option>
                            @endforeach
                        </select>
            
                    </div>
                    <a href="{{ route('purchasing.create') }}" class="mt-2 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 ">
                       Pelanggan Baru
                   </a>
               <!-- Input untuk upload bukti transaksi -->
            <div class="md:col-span-3 mt-5">
                <label class="block text-sm font-medium text-gray-700 mb-1">Upload Bukti Transaksi</label>
                <input type="file" name="buktiTransaksi" accept="image/*" class="input file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
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
                    <div>
                    <label class="block font-medium text-gray-700 mb-1">Nama Barang / Jenis Perangkat</label>
                    <input type="text" name="namaBarang" class="border px-3 py-2 rounded w-full mb-2"required>
                    </div>
                    <div>
                    <label class="block font-medium text-gray-700 mb-1">Type</label>
                    <input type="text" name="type" class="border px-3 py-2 rounded w-full mb-2">
                    </div> 
                    <div>
                     <label class="block font-medium text-gray-700 mb-1">Spesifikasi</label>
                     <input type="text" name="spek" class="border px-3 py-2 rounded w-full mb-2"  required>
                    </div> 
                    <div>
                    <label class="block font-medium text-gray-700 mb-1">Serial Number</label>
                    <input type="text" name="serialNumber" class="border px-3 py-2 rounded w-full mb-2"  required>
                    </div>
                    <div > 
                    <label class="block font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="idCategory" class="input" required>
                        <option value="">Pilih Kategori </option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->idCategory }}">{{ $category->namaKategori }}</option>
                        @endforeach
                    </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">

                    <div>
  <label class="block font-medium text-gray-700 mb-1">Jumlah</label>
  <input type="text" name="jumlah" class="border px-3 py-2 rounded w-full mb-2 format-ribuan" required>
</div>
<div>
  <label class="block font-medium text-gray-700 mb-1">Harga Beli</label>
  <input type="text" name="hargaBeli" class="border px-3 py-2 rounded w-full mb-2 format-ribuan" required>
</div>
<div>
  <label class="block font-medium text-gray-700 mb-1">Harga Jual</label>
  <input type="text" name="hargaJual" class="border px-3 py-2 rounded w-full mb-2 format-ribuan" required>
</div>

<script>
  document.querySelectorAll('.format-ribuan').forEach(function(input) {
    input.addEventListener('input', function(e) {
      // Hapus semua titik dulu
      let value = e.target.value.replace(/\./g, '').replace(/[^0-9]/g, '');
      // Format angka dengan pemisah ribuan
      e.target.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    });
  });
</script>

         
                     </div>
                    </div>

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
