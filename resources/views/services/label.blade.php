<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Struk Service') }}
        </h2>
    </x-slot>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #print-area, #print-area * {
                visibility: visible;
            }

            #print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                font-size: 13px;
                line-height: 1.4;
                color: #000;
            }

            .no-print {
                display: none !important;
            }

            textarea {
                display: none;
            }

            .print-keterangan {
                display: block !important;
                white-space: pre-line;
                border: 1px solid #999;
                padding: 8px;
                margin-top: 4px;
                font-family: inherit;
                font-size: 13px;
            }
        }
    </style>

    <div class="py-6">
        <div class="max-w-md mx-auto bg-white p-8 shadow-lg rounded-lg border" id="print-area">
            <!-- Informasi Service -->
            <div class="flex items-start justify-between border-b pb-4 mb-4">
                <div class="w-1/2">
                    <h3 class="font-semibold text-black mb-2 text-base">Informasi Service</h3>
                    <p class="text-sm text-black"><strong>Nama:</strong> {{ $service->customer->nama }}</p>
                    <p class="text-sm text-black"><strong>Perangkat:</strong> {{ $service->jenisPerangkat }}</p>
                    <p class="text-sm text-black"><strong>Kerusakan:</strong> {{ $service->kerusakan ?? '-' }}</p>
                    <p class="text-sm text-black">
                        <strong>Status:</strong> 
                        {{ $service->status ? 'Selesai' : 'Proses' }}
                    </p>
                </div>
                <div class="w-1/2">
                     <h3 class="font-semibold text-black text-base">Nomor Faktur:</h3>
                    <p class="text-lg font-bold text-black">{{ $service->nomorFaktur }}</p>
                    <p class="text-sm text-black"><strong>Kelengkapan:</strong> {{ $service->kelengkapan ?? '-' }}</p>
                    <p class="text-sm text-black"><strong>Kondisi Awal:</strong> {{ $service->kondisi ?? '-' }}</p>
                    <p class="text-sm text-black"><strong>Ciri-ciri:</strong> {{ $service->ciriCiri ?? '-' }}</p>
                    <p class="text-sm text-black"><strong>Tanggal Masuk:</strong> {{ $service->created_at->format('d M Y') }}</p>
                </div>
            </div>

            <!-- Catatan Teknisi -->
            <div class="mb-3">
                <label class="block text-sm font-medium text-black mb-1">Catatan Teknisi:</label>

                {{-- Tampilan untuk layar --}}
                <textarea name="keterangan" class="w-full border rounded px-3 py-2 text-sm text-black resize-none no-print"
                    rows="5">{{ old('keterangan', $service->keterangan) }}</textarea>

                {{-- Tampilan untuk cetak --}}
                <div class="print-keterangan hidden">
                    {{ old('keterangan', $service->keterangan) }}
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="text-center mt-8 no-print">
            <button type="button" onclick="window.location='{{ route('service.index') }}'"
                class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded shadow transition">
                🔙
            </button>
            <button onclick="window.print()"
                class="bg-blue-600 hover:bg-blue-700 ml-4 text-white font-semibold px-6 py-2 rounded shadow">
                🖨️ Cetak Label
            </button>
        </div>
    </div>
</x-app-layout>
