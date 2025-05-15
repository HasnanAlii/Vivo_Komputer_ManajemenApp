<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Halaman Edit Stok Barang') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 my-10">
            <div class="bg-white p-8 rounded-lg shadow-lg">
                 <h2 class="text-3xl font-bold mb-6 text-blue-700">Edit Produk</h2>


                <form action="{{ route('product.update', $product->idProduct) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block mb-1 text-gray-700 font-semibold">Nama Barang</label>
                            <input type="text" name="namaBarang" value="{{ old('namaBarang', $product->namaBarang) }}"
                                placeholder="Masukkan nama produk"
                                required
                                class="w-full border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm px-4 py-2">
                        </div>

                        <div>
                            <label class="block mb-1 text-gray-700 font-semibold">Jumlah</label>
                            <input type="number" name="jumlah" value="{{ old('jumlah', $product->jumlah) }}"
                                placeholder="Masukkan jumlah stok"
                                required
                                class="w-full border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm px-4 py-2">
                        </div>

                        <div>
                            <label class="block mb-1 text-gray-700 font-semibold">Harga Jual</label>
                            <input type="number" name="hargaJual" value="{{ old('hargaJual', $product->hargaJual) }}"
                                placeholder="Masukkan harga jual"
                                required
                                class="w-full border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm px-4 py-2">
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-3">
                        <button type="button" onclick="window.location='{{ route('product.index') }}'"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded shadow transition">
                            🔙 Batal
                        </button>

                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded shadow transition">
                            💾 Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
