<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight flex items-center gap-2">
            ➕📦 {{ __('Tambah Barang') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg p-6">
                <form action="{{ route('purchasing.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="nomorFaktur" class="block text-gray-700 font-medium mb-2">Nomor Faktur</label>
                        <input type="number" id="nomorFaktur" name="nomorFaktur" 
                               value="{{ old('nomorFaktur') }}" 
                               class="w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label for="jumlah" class="block text-gray-700 font-medium mb-2">Jumlah</label>
                        <input type="number" id="jumlah" name="jumlah" 
                               value="{{ old('jumlah') }}" 
                               class="w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label for="hargaBeli" class="block text-gray-700 font-medium mb-2">Harga Beli</label>
                        <input type="number" id="hargaBeli" name="hargaBeli" 
                               value="{{ old('hargaBeli') }}" 
                               class="w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label for="hargaJual" class="block text-gray-700 font-medium mb-2">Harga Jual</label>
                        <input type="number" id="hargaJual" name="hargaJual" 
                               value="{{ old('hargaJual') }}" 
                               class="w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label for="keuntungan" class="block text-gray-700 font-medium mb-2">Keuntungan</label>
                        <input type="number" id="keuntungan" name="keuntungan" 
                               value="{{ old('keuntungan') }}" 
                               class="w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label for="tanggal" class="block text-gray-700 font-medium mb-2">Tanggal</label>
                        <input type="date" id="tanggal" name="tanggal" 
                               value="{{ old('tanggal') }}" 
                               class="w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label for="idCustomer" class="block text-gray-700 font-medium mb-2">Nama Customer</label>
                        <input type="text" id="idCustomer" name="idCustomer" 
                               value="{{ old('idCustomer') }}" 
                               class="w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label for="idProduct" class="block text-gray-700 font-medium mb-2">Nama Produk</label>
                        <input type="text" id="idProduct" name="idProduct" 
                               value="{{ old('idProduct') }}" 
                               class="w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label for="idFinance" class="block text-gray-700 font-medium mb-2">ID Finance (opsional)</label>
                        <input type="number" id="idFinance" name="idFinance" 
                               value="{{ old('idFinance') }}" 
                               class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
