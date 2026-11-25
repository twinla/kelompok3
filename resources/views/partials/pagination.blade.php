@if ($paginator->hasPages())
    @php
        $currentPage = $paginator->currentPage();
        $lastPage = $paginator->lastPage();
        $startPage = max(1, $currentPage - 2);
        $endPage = min($lastPage, $currentPage + 2);
    @endphp

    <div class="tp-pagination-wrap">
        <nav class="tp-pagination-nav" aria-label="Navigasi halaman">
            @if ($paginator->onFirstPage())
                <span class="tp-page-link tp-page-direction is-disabled" aria-disabled="true">← Sebelumnya</span>
            @else
                <a class="tp-page-link tp-page-direction" href="{{ $paginator->previousPageUrl() }}" rel="prev">← Sebelumnya</a>
            @endif

            @if ($startPage > 1)
                <a class="tp-page-link" href="{{ $paginator->url(1) }}" aria-label="Buka halaman 1">1</a>
                @if ($startPage > 2)
                    <span class="tp-page-ellipsis" aria-hidden="true">…</span>
                @endif
            @endif

            @for ($page = $startPage; $page <= $endPage; $page++)
                @if ($page === $currentPage)
                    <span class="tp-page-link is-current" aria-current="page" aria-label="Halaman saat ini, {{ $page }}">{{ $page }}</span>
                @else
                    <a class="tp-page-link" href="{{ $paginator->url($page) }}" aria-label="Buka halaman {{ $page }}">{{ $page }}</a>
                @endif
            @endfor

            @if ($endPage < $lastPage)
                @if ($endPage < $lastPage - 1)
                    <span class="tp-page-ellipsis" aria-hidden="true">…</span>
                @endif
                <a class="tp-page-link" href="{{ $paginator->url($lastPage) }}" aria-label="Buka halaman {{ $lastPage }}">{{ $lastPage }}</a>
            @endif

            @if ($paginator->hasMorePages())
                <a class="tp-page-link tp-page-direction" href="{{ $paginator->nextPageUrl() }}" rel="next">Berikutnya →</a>
            @else
                <span class="tp-page-link tp-page-direction is-disabled" aria-disabled="true">Berikutnya →</span>
            @endif
        </nav>
    </div>
@endif
