@auth
<nav class="tp-reader-nav" aria-label="Menu bacaan">
    <a href="{{ route('library.index', ['shelf' => 'saved']) }}">Pustaka Saya</a>
    <a href="{{ route('reading.bookmarks') }}">Penanda Bacaan</a>
    <a href="{{ route('reading.history') }}">Riwayat Bacaan</a>
    <a href="{{ route('recommendations.index') }}">Rekomendasi</a>
</nav>
@endauth
