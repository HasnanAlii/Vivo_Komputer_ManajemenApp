<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <button type="button" onclick="window.location='{{ route('reports.customer') }}'"
                class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded shadow transition">
                🔙
            </button>Edit Customer</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">
                <form action="{{ route('reports.updatee', $customer->idCustomer) }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" name="nama" value="{{ $customer->nama }}" class="w-full border px-3 py-2 rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Alamat</label>
                        <textarea name="alamat" class="w-full border px-3 py-2 rounded">{{ $customer->alamat }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">No. Telepon</label>
                        <input type="text" name="noTelp" value="{{ $customer->noTelp }}" class="w-full border px-3 py-2 rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">No. KTP</label>
                        <input type="text" name="noKtp" value="{{ $customer->noKtp }}" class="w-full border px-3 py-2 rounded">
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
