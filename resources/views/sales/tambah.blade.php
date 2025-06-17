<x-app-layout>
<div class="max-w-md mx-auto bg-white rounded-xl shadow-md p-6 mt-10">
    <h2 class="text-xl font-bold mb-4 text-blue-700">👤 Tambah Customer</h2>

    <form action="{{ route('sales.addcustomer') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
            <input type="text" id="nama" name="nama" maxlength="50" placeholder="Nama Customer" 
                class="w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" />
        </div>

        <div class="mb-4">
            <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
            <textarea id="alamat" name="alamat" maxlength="255" placeholder="Alamat Customer" rows="3"
                class="w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 resize-none"></textarea>
        </div>

        <div class="mb-4">
            <label for="noTelp" class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
            <input type="text" id="noTelp" name="noTelp" maxlength="255" placeholder="No. Telepon Customer" 
                class="w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" />
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('sales.index') }}" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-700">
                Batal
            </a>
            <button type="submit" class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white font-semibold">
                Simpan
            </button>
        </div>
    </form>
</div>
</x-app-layout>