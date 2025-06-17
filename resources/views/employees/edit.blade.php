<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('employees.index') }}" 
               class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded shadow transition">
                🔙
            </a>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Edit Karyawan
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

                <form action="{{ route('employees.update', $employee->idEmployee) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="nama" class="block font-medium text-gray-700">Nama</label>
                        <input type="text" name="nama" id="nama" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2
                                   focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            value="{{ old('nama', $employee->nama) }}">
                    </div>

                    <div>
                        <label for="jabatan" class="block font-medium text-gray-700">Jabatan</label>
                        <input type="text" name="jabatan" id="jabatan"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2
                                   focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            value="{{ old('jabatan', $employee->jabatan) }}">
                    </div>

                    <div class="flex space-x-4 justify-end">
                        <a href="{{ route('employees.index') }}"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded shadow font-semibold transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow font-semibold transition">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
