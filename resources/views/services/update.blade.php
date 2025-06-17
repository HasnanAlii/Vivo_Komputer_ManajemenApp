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
                                required>
                        </div>
             

                     <div>
                    <label class="block text-gray-700 font-semibold mb-2">👨‍🔧 Ditangani Oleh</label>
                    <select name="idEmployee"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="">-- Pilih Teknisi --</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->idEmployee }}"
                                {{ $service->idEmployee == $employee->idEmployee ? 'selected' : '' }}>
                                {{ $employee->nama }}
                            </option>
                        @endforeach
                    </select>
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
                       <div>
                            <label class="block font-medium text-gray-700 mb-1">Jasa yang digunakan</label>
                            <input type="text" name="jasa" class="border px-3 py-2 rounded w-full" required>
                        </div>
                    <!-- Biaya Jasa -->
                    <div class="mb-6">
                       <label class="block text-gray-700 font-semibold mb-2">Catatan Teknisi</label>
                        <textarea name="keterangan" rows="3"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">{{ old('keterangan', $service->keterangan) }}</textarea>
                        <label class="block text-gray-700 font-semibold mb-2">💰 Biaya Jasa (Rp)</label>
                         <input type="text" name="biayaJasa" 
         value="{{ old('biayaJasa', number_format($service->biayaJasa, 0, ',', '.')) }}"
         class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 format-ribuan"
         required>
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


                    <!-- Pilih Sparepart -->
                    <div class="mb-8">
                        <label class="block text-gray-700 font-semibold mb-2 ">🧩 Pilih Sparepart</label>
                        <select id="select-sparepart" name="idProduct[]" multiple
                            class="w-full border rounded-lg select2 focus:ring-2 focus:ring-blue-400 h-60">
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
                    <div class="flex justify-end gap-5">
                        <button type="button" onclick="window.location='{{ route('service.index') }}'"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded shadow transition">
                    🔙
                           </button>
          
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
