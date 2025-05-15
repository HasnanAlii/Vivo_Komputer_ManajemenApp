<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight flex items-center gap-2">
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
                <form action="{{ route('purchasing.store') }}" method="POST">
                    @csrf

                    <!-- Customer Info -->
                    <div>
                        <h3 class="text-xl font-semibold text-blue-700 mb-4 border-b pb-2 flex items-center">
                            <svg class="h-5 w-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1117.805 5.12 9 9 0 015.12 17.804z" />
                            </svg>
                            Data Customer
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <input type="text" name="nama" placeholder="Nama Customer" class="input" required>
                            <input type="text" name="noTelp" placeholder="No Telepon" class="input">
                            <input type="text" name="alamat" placeholder="Alamat" class="input">
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div>
                        <h3 class="text-xl font-semibold text-green-700 mb-4 border-b pb-2  py-3 flex items-center">
                            <svg class="h-5 w-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
                            </svg>
                            Data Produk
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <input type="text" name="namaBarang" placeholder="Nama Barang" class="input" required>
                            <input type="text" name="kategori" placeholder="Kategori" class="input">
                            <input type="text" name="kodeBarang" placeholder="Kode Barang" class="input">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                            <input type="number" name="jumlah" placeholder="Jumlah" class="input" required min="1">
                            <input type="number" name="hargaBeli" placeholder="Harga Beli /pcs" class="input" required min="0">
                            <input type="number" name="hargaJual" placeholder="Harga Jual /pcs" class="input" required min="0">
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="pt-6 flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
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
</x-app-layout>
