@props(['color' => 'blue'])

<div class="flex justify-end space-x-3">
    <button type="button" {{ $attributes->merge(['class' => 'px-4 py-2 rounded border border-gray-300 hover:bg-gray-100']) }}>
        Batal
    </button>
    <button type="submit" class="px-4 py-2 bg-{{ $color }}-600 hover:bg-{{ $color }}-700 text-white rounded">
        Simpan
    </button>
</div>
