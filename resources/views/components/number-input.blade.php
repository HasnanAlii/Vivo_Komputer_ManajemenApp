@props(['label', 'name'])

<div class="mb-4">
    <label for="{{ $name }}" class="block mb-1 font-medium">{{ $label }}</label>
    <input type="text" name="{{ $name }}" id="{{ $name }}" required min="0"
        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300 format-ribuan">
</div>
