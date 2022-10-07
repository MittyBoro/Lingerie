@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        <li class="prev {{ ($paginator->onFirstPage()) ? ' disabled' : '' }}">
            <a href="{{ $paginator->previousPageUrl() }}">
                @svg('images/svg/arrow.svg')
                <span>Назад</span>
            </a>
        </li>
        {{-- Pagination Elements --}}
        @foreach (paginator_elements($elements, $paginator->currentPage()) as $k => $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="dots" aria-disabled="true"><span>{{ $element }}</span></li>
            @endif


            {{-- Array Of Links --}}
            @if (is_array($element))
                @php

                    // if ( $k === 4 && isset($elements[3]) )
                    //     $element = array_slice($element, -1, 2, true);
                @endphp
                @foreach ($element as $page => $url)
                    <li class="{{ $page == $paginator->currentPage() ? ' active' : '' }} page-{{ $page }}">
                        <a href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach
            @endif
        @endforeach

        <li class="next {{ !$paginator->hasMorePages() ? ' disabled' : '' }}">
            <a href="{{ $paginator->nextPageUrl() }}" >
                <span>Далее</span>
                @svg('images/svg/arrow.svg')
            </a>
        </li>
    </ul>
@endif
