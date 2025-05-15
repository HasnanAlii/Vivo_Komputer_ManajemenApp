@props(['title', 'route', 'icon'])

<div class="bg-blue-100 hover:bg-blue-200 transition rounded-xl p-6 shadow flex flex-col justify-between h-full">
    <div>
        <div class="flex items-center justify-between mb-4">
            
            <h2 class="text-xl font-semibold text-blue-800">{{ $title }}</h2>
            <x-dynamic-component :component="'heroicon-o-' . $icon" class="w-6 h-6 text-blue-500" />
        </div>
        <p class="text-sm text-gray-700">Klik untuk masuk ke halaman {{ strtolower($title) }}.</p>
    </div>
    <div class="mt-6 text-right">
        <button onclick="window.location.href='{{ $route }}'"
            class="px-4 py-2 bg-white text-blue-700 border border-blue-400 rounded-full hover:bg-blue-50 transition shadow-sm">
            Lihat →
        </button>
    </div>
</div>
