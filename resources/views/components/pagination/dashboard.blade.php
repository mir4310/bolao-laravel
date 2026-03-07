@if ($paginator->hasPages())
    <div class="flex flex-col md:flex-row items-center justify-between mt-6">
        {{-- Total de registros --}}
        <div class="text-sm text-gray-600 mb-2 md:mb-0">
            Mostrando 
            <span class="font-medium">{{ $paginator->firstItem() }}</span> 
            até 
            <span class="font-medium">{{ $paginator->lastItem() }}</span> 
            de 
            <span class="font-medium">{{ $paginator->total() }}</span> 
            usuários
        </div>

        {{-- Links de paginação --}}
        <ul class="inline-flex items-center space-x-1">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="px-3 py-2 rounded-md bg-gray-200 text-gray-500 cursor-not-allowed">«</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-2 rounded-md bg-white text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition">«</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li>
                        <span class="px-3 py-2 rounded-md bg-white text-gray-500">{{ $element }}</span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span class="px-3 py-2 rounded-md bg-blue-600 text-white font-semibold">{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}" class="px-3 py-2 rounded-md bg-white text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-2 rounded-md bg-white text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition">»</a>
                </li>
            @else
                <li>
                    <span class="px-3 py-2 rounded-md bg-gray-200 text-gray-500 cursor-not-allowed">»</span>
                </li>
            @endif
        </ul>
    </div>
@endif