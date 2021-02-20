@if ($paginator->hasPages())
    <ul class="pagination mt-4 mb-0 float-left">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item page-prev disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <span class="page-link" href="#" tabindex="-1" aria-hidden="true">{{ __('content.prev') }}</span>
            </li>
        @else
            <li class="page-item page-prev">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">{{ __('content.prev') }}</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item page-next">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">{{ __('content.next') }}</a>
            </li>
        @else
            <li class="page-item page-next disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                <span class="page-link" aria-hidden="true">{{ __('content.next') }}</span>
            </li>
        @endif
    </ul>
@endif
