<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('categories.index') }}" 
               class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded shadow transition">
                🔙
            </a>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Tambah Kategori
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-6">
                @if ($errors->any())
                    <div class="mb-4 text-red-600">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('categories.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="kodeKategori" class="block font-medium text-gray-700">Kode Kategori</label>
                        <input type="text" name="kodeKategori" id="kodeKategori" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2
                                   focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            value="{{ old('kodeKategori') }}">
                    </div>

                    <div>
                        <label for="namaKategori" class="block font-medium text-gray-700">Nama Kategori</label>
                        <input type="text" name="namaKategori" id="namaKategori" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2
                                   focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            value="{{ old('namaKategori') }}">
                    </div>

                    <div class="flex space-x-4 justify-end">
                        <a href="{{ route('categories.index') }}"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded shadow font-semibold transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow font-semibold transition">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
