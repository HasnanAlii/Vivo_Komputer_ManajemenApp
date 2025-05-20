<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Struk Service') }}
        </h2>
    </x-slot>

    <style>
        @media print {
            /* Sembunyikan semua kecuali #print-area */
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
            }
                textarea {
                    border: none;
                    outline: none;
                    resize: none;
                    overflow: hidden;
                    font-family: inherit;
                    font-size: 14px;
                }
        }
    </style>

  <div class="py-6">
    <div class="max-w-md mx-auto bg-white p-8 shadow-lg rounded-lg border" id="print-area">
        <!-- Isi struk -->

        <div class="flex items-center justify-between border-b pb-4 mb-4">
            <div class="w-1/2">
                <h3 class="font-semibold text-gray-700 mb-2 text-base">Informasi Service</h3>
                <p class="text-sm text-gray-600"><span class="font-medium">Nama:</span> {{ $service->customer->nama }}</p>
                <p class="text-sm text-gray-600"><span class="font-medium">Perangkat:</span> {{ $service->jenisPerangkat }}</p>
                <p class="text-sm text-gray-600"><span class="font-medium">Kerusakan:</span> {{ $service->kerusakan ?? '-' }}</p>
                
                <p class="text-sm text-gray-600">
                    <span class="font-medium">Status:</span> 
                    @if ($service->status)
                        <span class="text-green-600">Selesai</span>
                    @else
                        <span class="text-yellow-600">Proses</span>
                    @endif
                </p>
            </div>
            <div class="">
                <p class="text-xs text-gray-500">Nomor Faktur:</p>
                <p class="text-lg font-bold text-gray-900">{{ $service->nomorFaktur }}</p>
                <p class="text-sm text-gray-600"><span class="font-medium">Kelengkapan:</span> {{ $service->kelengkapan ?? '-' }}</p>
                <p class="text-sm text-gray-600"><span class="font-medium">Kondisi Awal:</span> {{ $service->kondisi ?? '-' }}</p>
                <p class="text-sm text-gray-600"><span class="font-medium">Ciri-ciri:</span> {{ $service->ciriCiri ?? '-' }}</p>
                <p class="text-sm text-gray-600"><span class="font-medium">Tanggal Masuk:</span> {{ $service->created_at->format('d M Y') }}</p>
            </div>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="block text-sm font-medium text-gray-600 mb-1">Catatan Teknisi:</label>
            <textarea name="keterangan" id="keterangan" class="w-full border rounded px-3 py-2 text-sm text-gray-800 resize-none" rows="5">{{ old('keterangan', $service->keterangan) }}</textarea>
        </div>
    </div>
</div>

          
<div class="text-center mt-8 " >
    <button type="button" onclick="window.location='{{ route('service.index') }}'"
            class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded shadow transition">
        🔙
    </button>
    <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 ml-4 text-white font-semibold px-6 py-2 rounded shadow">
        🖨️ Cetak Label
    </button>
</div>
        </div>
    </div>
</x-app-layout>
