@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center space-x-1">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1 rounded bg-white text-gray-500 cursor-not-allowed">&lsaquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1 rounded bg-white text-gray-700 hover:bg-gray-200">&lsaquo;</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-3 py-1 rounded bg-white text-gray-500 cursor-default">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page" class="px-3 py-1 rounded bg-gray-200 text-gray-900 font-semibold">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1 rounded bg-white text-gray-700 hover:bg-gray-200">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1 rounded bg-white text-gray-700 hover:bg-gray-200">&rsaquo;</a>
        @else
            <span class="px-3 py-1 rounded bg-white text-gray-500 cursor-not-allowed">&rsaquo;</span>
        @endif
    </nav>
@endif
