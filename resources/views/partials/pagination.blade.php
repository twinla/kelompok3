@if ($paginator->hasPages())
    @php
        $currentPage = $paginator->currentPage();
        $lastPage = $paginator->lastPage();
        $startPage = max(1, $currentPage - 2);
        $endPage = min($lastPage, $currentPage + 2);
    @endphp

    <div class="tp-pagination-wrap">
        <nav class="tp-pagination-nav" aria-label="Pagination">
            @if ($paginator->onFirstPage())
                <span class="tp-page-link tp-page-direction is-disabled" aria-disabled="true">← Previous</span>
            @else
                <a class="tp-page-link tp-page-direction" href="{{ $paginator->previousPageUrl() }}" rel="prev">← Previous</a>
            @endif

            @if ($startPage > 1)
                <a class="tp-page-link" href="{{ $paginator->url(1) }}" aria-label="Go to page 1">1</a>
                @if ($startPage > 2)
                    <span class="tp-page-ellipsis" aria-hidden="true">…</span>
                @endif
            @endif

            @for ($page = $startPage; $page <= $endPage; $page++)
                @if ($page === $currentPage)
                    <span class="tp-page-link is-current" aria-current="page" aria-label="Current page, {{ $page }}">{{ $page }}</span>
                @else
                    <a class="tp-page-link" href="{{ $paginator->url($page) }}" aria-label="Go to page {{ $page }}">{{ $page }}</a>
                @endif
            @endfor

            @if ($endPage < $lastPage)
                @if ($endPage < $lastPage - 1)
                    <span class="tp-page-ellipsis" aria-hidden="true">…</span>
                @endif
                <a class="tp-page-link" href="{{ $paginator->url($lastPage) }}" aria-label="Go to page {{ $lastPage }}">{{ $lastPage }}</a>
            @endif

            @if ($paginator->hasMorePages())
                <a class="tp-page-link tp-page-direction" href="{{ $paginator->nextPageUrl() }}" rel="next">Next →</a>
            @else
                <span class="tp-page-link tp-page-direction is-disabled" aria-disabled="true">Next →</span>
            @endif
        </nav>
    </div>
@endif
