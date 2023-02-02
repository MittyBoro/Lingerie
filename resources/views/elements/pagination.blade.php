@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        <li class="prev {{ ($paginator->onFirstPage()) ? ' disabled' : '' }}">
            <a href="{{ $paginator->previousPageUrl() }}">
                <img src="@vite_asset('images/icons/arrow-line-right.svg')" alt="" class="to-svg">
                <span>@lang('front.pagination.prev')</span>
            </a>
        </li>
        {{-- Pagination Elements --}}
        @foreach (paginator_elements($elements, $paginator->currentPage()) as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="dots" aria-disabled="true"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    <li class="{{ $page == $paginator->currentPage() ? ' active' : '' }} page-{{ $page }}">
                        <a href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach
            @endif
        @endforeach

        <li class="next {{ !$paginator->hasMorePages() ? ' disabled' : '' }}">
            <a href="{{ $paginator->nextPageUrl() }}" >
                <span>@lang('front.pagination.next')</span>
                <img src="@vite_asset('images/icons/arrow-line-right.svg')" alt="" class="to-svg">
            </a>
        </li>
    </ul>
@endif
