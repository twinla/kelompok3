@auth
<nav class="tp-reader-nav" aria-label="Your reading tools">
    <a href="{{ route('library.index', ['shelf' => 'saved']) }}">My Library</a>
    <a href="{{ route('reading.bookmarks') }}">Bookmarks</a>
    <a href="{{ route('reading.history') }}">Reading History</a>
    <a href="{{ route('recommendations.index') }}">Recommendations</a>
</nav>
@endauth
