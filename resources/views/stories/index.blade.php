@extends('layouts.app')

@section('title', 'Discover Stories')

@section('content')
<section class="tp-top-area">
    <div class="tp-top-search">
        <form action="{{ route('stories.index') }}" method="GET" class="search-form">
            <input type="search" name="q" placeholder="Search titles, authors, or genres..." value="{{ request('q') }}" aria-label="Search stories">
            <input type="hidden" name="per_page" value="{{ $perPage }}">
            <button type="submit">Search →</button>
        </form>
    </div>
</section>

<section class="hero">
    <div class="hero-content">
        <div class="eyebrow">YOUR NEXT FAVORITE STORY AWAITS</div>
        <h1>Every story has<br>a world <em>to explore.</em></h1>
        <p>Find your next escape through new stories, meet authors, and let your imagination wander.</p>
        <div class="hero-actions">
            <a href="#discover" class="btn btn-gold">Explore Stories →</a>
            <a href="{{ route('stories.random') }}" class="btn btn-outline">⇄ Surprise Me</a>
            <a href="{{ route('recommendations.index') }}" class="btn btn-outline">For You</a>
        </div>
    </div>
    <div class="hero-decoration"><div class="hero-circle"><span>TALEPAD</span><strong>Stories<br>Beyond<br>Imagination.</strong><small>EST. 2026</small></div></div>
</section>

<section class="discover-section" id="discover">
    <div class="section-heading">
        <div><div class="eyebrow">THE READING ROOM</div><h2>{{ request('q') ? 'Search results' : 'Discover your next read.' }}</h2></div>
        @auth <a href="{{ route('stories.create') }}" class="btn btn-dark">+ Publish Story</a>
        @else <a href="{{ route('login') }}" class="btn btn-dark">Log In to Publish</a> @endauth
    </div>

    <form action="{{ route('stories.index') }}" method="GET" class="tp-discovery-filters">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Search title, author, genre..." aria-label="Search">
        <input type="hidden" name="per_page" value="{{ $perPage }}">
        <select name="genre" aria-label="Filter genre">
            <option value="">All genres</option>
            @foreach($genres as $genreOption)
                <option value="{{ $genreOption }}" @selected(request('genre') === $genreOption)>{{ $genreOption }}</option>
            @endforeach
        </select>
        <select name="sort" aria-label="Sort stories">
            <option value="latest" @selected($sort === 'latest')>Latest</option>
            <option value="popular" @selected($sort === 'popular')>Most liked</option>
            <option value="top_rated" @selected($sort === 'top_rated')>Top rated</option>
            <option value="title" @selected($sort === 'title')>Title A–Z</option>
        </select>
        <button type="submit" class="btn btn-dark">Apply</button>
        <a href="{{ route('stories.index') }}" class="tp-filter-reset">Reset</a>
    </form>

    <div class="story-grid">
        @forelse($stories as $story)
            <article class="story-card">
                <a href="{{ route('stories.show', $story) }}" class="cover-link">
                    @if($story->cover) <img src="{{ asset('storage/' . $story->cover) }}" alt="{{ $story->title }}" class="story-cover">
                    @else <div class="cover-placeholder"><span>{{ $story->genre }}</span><strong>{{ $story->title }}</strong><small>TALEPAD EDITION</small></div> @endif
                </a>
                <div class="story-info">
                    <span class="genre">{{ $story->genre }}</span>
                    <h3><a href="{{ route('stories.show', $story) }}">{{ $story->title }}</a></h3>
                    <p>by @if($story->user)<a href="{{ route('authors.show', $story->user) }}">{{ $story->author }}</a>@else{{ $story->author }}@endif</p>
                    <div class="tp-card-stats"><span>♥ {{ $story->likes_count }}</span><span>★ {{ $story->ratings_avg_rating ? number_format($story->ratings_avg_rating, 1) : 'New' }}</span></div>
                    <div class="story-bottom"><a href="{{ route('stories.show', $story) }}">Read Story →</a></div>
                </div>
            </article>
        @empty
            <div class="empty-state"><div class="empty-icon">✦</div><h3>No stories found.</h3><p>Try changing the keyword, genre, or sorting option.</p></div>
        @endforelse
    </div>
    <section class="tp-discovery-pagination" aria-label="Story list pagination">
        <div class="tp-discovery-pagination-top">
            <p class="tp-pagination-summary">
                Showing <strong>{{ $stories->firstItem() ?? 0 }}–{{ $stories->lastItem() ?? 0 }}</strong>
                of <strong>{{ $stories->total() }}</strong> stories
            </p>

            <form action="{{ route('stories.index') }}" method="GET" class="tp-per-page-control">
                @if (request()->filled('q'))
                    <input type="hidden" name="q" value="{{ request('q') }}">
                @endif
                @if (request()->filled('genre'))
                    <input type="hidden" name="genre" value="{{ request('genre') }}">
                @endif
                <input type="hidden" name="sort" value="{{ $sort }}">
                <label for="tp-per-page">Show</label>
                <select id="tp-per-page" name="per_page" aria-label="Stories per page">
                    @foreach ([5, 10, 20, 40] as $pageSize)
                        <option value="{{ $pageSize }}" @selected($perPage === $pageSize)>{{ $pageSize }}</option>
                    @endforeach
                </select>
                <span>per page</span>
                <button type="submit" class="tp-per-page-apply">Apply</button>
            </form>
        </div>

        @include('partials.pagination', ['paginator' => $stories])
    </section>
</section>
@endsection
