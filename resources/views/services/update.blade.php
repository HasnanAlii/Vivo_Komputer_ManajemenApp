<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ✏️ Update Data Service
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-2xl p-8">
                <form action="{{ route('service.update', $service->idService) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Kerusakan -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">🔧 Kerusakan</label>
                            <input type="text" name="kerusakan" value="{{ old('kerusakan', $service->kerusakan) }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                                placeholder="Contoh: Tidak bisa nyala" required>
                        </div>

                        <!-- Status Service -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">📋 Status Service</label>
                            <select name="status"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                                <option value="0" {{ !$service->status ? 'selected' : '' }}>🔄 Belum Selesai</option>
                                <option value="1" {{ $service->status ? 'selected' : '' }}>✅ Selesai</option>
                            </select>
                        </div>
                    </div>

                    <!-- Biaya Jasa -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">💰 Biaya Jasa (Rp)</label>
                        <input type="number" name="biayaJasa" value="{{ old('biayaJasa', $service->biayaJasa) }}"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400"
                            placeholder="Contoh: 50000" min="0">
                    </div>

                    <!-- Pilih Sparepart -->
                    <div class="mb-8">
                        <label class="block text-gray-700 font-semibold mb-2 ">🧩 Pilih Sparepart</label>
                        <select id="select-sparepart" name="idProduct[]" multiple
                            class="w-full border rounded-lg select2 focus:ring-2 focus:ring-blue-400 ">
                            @php
                                $selectedProducts = explode(',', $service->idProduct ?? '');
                            @endphp
                            @foreach($products as $product)
                                <option value="{{ $product->idProduct }}"
                                    {{ in_array($product->idProduct, $selectedProducts) ? 'selected' : '' }}>
                                    {{ $product->namaBarang }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-all shadow-md">
                            💾 Simpan Perubahan
                        </button>
                    </div>
                </form>

                <!-- Select2 Script -->
                <script>
                    $(document).ready(function () {
                        $('#select-sparepart').select2({
                            placeholder: "-- Pilih Sparepart --",
                            allowClear: true,
                            width: '100%'
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</x-app-layout>
