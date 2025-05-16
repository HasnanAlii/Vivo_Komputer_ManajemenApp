<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Update Service</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-6">

                <!-- FORM UPDATE SERVICE -->
                <!-- FORM UPDATE SERVICE -->
<form action="{{ route('service.update', $service->idService) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div>
            <label class="block text-gray-700 font-semibold mb-1">Kerusakan</label>
            <input type="text" name="kerusakan" value="{{ $service->kerusakan }}"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300" required>
        </div>
        <div>
            <label class="block text-gray-700 font-semibold mb-1">Status Service</label>
            <select name="status"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
                <option value="0" {{ !$service->status ? 'selected' : '' }}>Belum Selesai</option>
                <option value="1" {{ $service->status ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>
    </div>

    <div class="mb-6">
        <label class="block text-gray-700 font-semibold mb-1">Total Biaya (Rp)</label>
        <input type="number" name="totalBiaya" value="{{ $service->totalBiaya }}"
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400" required>
    </div>
    
<div class="mb-6">
    <label class="block text-gray-700 font-semibold mb-1">Pilih Sparepart</label>
    <select id="select-sparepart" name="idProduct"
        class="w-full border rounded-lg select2">
        <option value="">-- Pilih Sparepart --</option>
        @foreach($products as $product)
            <option value="{{ $product->idProduct }}"
                {{ $service->idProduct == $product->idProduct ? 'selected' : '' }}>
                {{ $product->namaBarang }}
            </option>
        @endforeach
    </select>
</div>


    <div class="flex justify-end">
        <button type="submit"
            class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
            💾 Update Service
        </button>
    </div>
</form>



            </div>
        </div>
    </div>
</x-app-layout>
