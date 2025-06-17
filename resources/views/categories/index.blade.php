<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <button type="button" onclick="window.location='{{ route('dashboard') }}'"
                class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded shadow transition">
                🔙 
            </button>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Daftar Kategori
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-6 overflow-x-auto">
                <div class="mb-4 flex justify-end">
                    <a href="{{ route('categories.create') }}" 
                    class="bg-blue-500 hover:bg-blue-600 text-white font-medium px-4 py-2 rounded shadow">
                        + Tambah Kategori
                    </a>
                </div>

                <table class="min-w-full table-auto border border-gray-200 text-gray-800">
                    <thead class="bg-gray-100 text-left text-sm font-semibold text-gray-700">
                        <tr>
                            <th class="p-3 border text-center">ID</th>
                            <th class="p-3 border text-center">Kode Kategori</th>
                            <th class="p-3 border text-center">Nama Kategori</th>
                            <th class="p-3 border text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse ($categories as $index => $category)
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 border text-center">{{ $index + 1 }}</td>
                                <td class="p-3 border">{{ $category->kodeKategori }}</td>
                                <td class="p-3 border">{{ $category->namaKategori }}</td>
                                <td class="p-3 border text-center space-x-2">
                                    <a href="{{ route('categories.edit', $category->idCategory) }}"
                                       class="inline-flex items-center px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded shadow transition">
                                        ✏️ Edit
                                    </a>
                                    <form action="{{ route('categories.destroy', $category->idCategory) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin ingin menghapus kategori ini?')"
                                            class="inline-flex items-center px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded shadow transition">
                                            🗑 Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-4 text-center text-gray-500 italic">
                                    Tidak ada data kategori.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
