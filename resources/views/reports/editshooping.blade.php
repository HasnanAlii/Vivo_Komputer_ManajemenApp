<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <button type="button" onclick="window.location='{{ route('reports.shopping') }}'"
                class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded shadow transition">
                🔙
            </button>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight flex items-center space-x-2">
                <span>Edit Data Belanja Toko</span>
            </h2>
        </div>
    </x-slot>

                <div class="py-10 max-w-lg mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white shadow-xl sm:rounded-lg p-6">
                    <form action="{{ route('reports.updates', $shopping->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

            <div>
                <label for="sisaCicilan" class="block text-sm font-medium text-gray-700 mb-1">Sisa Cicilan (Rp)</label>
                <input type="text" name="sisaCicilan" id="sisaCicilan"
                    value="{{ old('sisaCicilan', number_format($shopping->pembayaran()->latest()->first()?->sisaCicilan ?? $shopping->totalbelanja, 0, ',', '.')) }}"
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 format-ribuan"
                    required>
                @error('sisaCicilan') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>


                <div>
                    <label for="bayar" class="block text-sm font-medium text-gray-700 mb-1">Bayar (Rp)</label>
                    <input type="text" name="bayar" id="bayar"
                        value="{{ old('bayar') }}"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 format-ribuan">
                    @error('bayar') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Submit --}}
                        <div class="pt-6 flex justify-center">
                        <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded shadow">
                            💾 Update Data
                        </button>
                    </div>

            </form>

        </div>
    </div>

    <script>
        document.querySelectorAll('.format-ribuan').forEach(function(input) {
            input.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\./g, '').replace(/[^0-9]/g, '');
                e.target.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            });
        });
    </script>
</x-app-layout>
