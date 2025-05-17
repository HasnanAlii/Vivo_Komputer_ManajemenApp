@props([
    'label' => '',
    'name',
    'type' => 'text',
    'value' => '',
    'disabled' => false,
])

<div class="mb-4">
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">
            {{ $label }}
        </label>
    @endif
    <input 
        type="{{ $type }}" 
        name="{{ $name }}" 
        id="{{ $name }}" 
        value="{{ old($name, $value) }}"
        @disabled($disabled)
        {{ $attributes->merge([
            'class' => 'w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
        ]) }}
    >
</div>
