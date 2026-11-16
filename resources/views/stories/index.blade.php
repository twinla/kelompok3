@extends('layouts.app')

@section('title', 'Discover Stories')

@section('content')
<section class="tp-top-area">
    <div class="tp-top-search">
        <form action="{{ route('stories.index') }}" method="GET" class="search-form">
            <input
                type="search"
                name="q"
                placeholder="Search titles, authors, or genres..."
                value="{{ request('q') }}"
                aria-label="Search titles, authors, or genres"
            >
            <button type="submit">Search →</button>
        </form>
        @if(request()->filled('q'))
            <a class="tp-clear-search" href="{{ route('stories.index') }}">Clear search</a>
        @endif
    </div>
</section>

@if(session('success'))
    <div class="tp-flash tp-flash-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="tp-flash tp-flash-error">{{ session('error') }}</div>
@endif

<section class="hero">
    <div class="hero-content">
        <div class="eyebrow">YOUR NEXT FAVORITE STORY AWAITS</div>
        <h1>Every story has<br>a world <em>to explore.</em></h1>
        <p>Find your next escape through thousands of possibilities. Discover stories, meet new authors, and let your imagination wander.</p>
        <div class="hero-actions">
            <a href="#discover" class="btn btn-gold">Explore Stories →</a>
            <a href="{{ route('stories.random') }}" class="btn btn-outline">⇄ Surprise Me</a>
        </div>
    </div>

    <div class="hero-decoration">
        <div class="hero-circle">
            <span>TALEPAD</span>
            <strong>Stories<br>Beyond<br>Imagination.</strong>
            <small>EST. 2026</small>
        </div>
    </div>
</section>

<section class="discover-section" id="discover">
    <div class="section-heading">
        <div>
            <div class="eyebrow">THE READING ROOM</div>
            <h2>{{ request('q') ? 'Search results' : 'Discover your next read.' }}</h2>
        </div>
        @auth
            <a href="{{ route('stories.create') }}" class="btn btn-dark">+ Publish Story</a>
        @else
            <a href="{{ route('login') }}" class="btn btn-dark">Log In to Publish</a>
        @endauth
    </div>

    <div class="story-grid">
        @forelse($stories as $story)
            <article class="story-card">
                <a href="{{ route('stories.show', $story) }}" class="cover-link">
                    @if($story->cover)
                        <img src="{{ asset('storage/' . $story->cover) }}" alt="{{ $story->title }}" class="story-cover">
                    @else
                        <div class="cover-placeholder">
                            <span>{{ $story->genre }}</span>
                            <strong>{{ $story->title }}</strong>
                            <small>TALEPAD EDITION</small>
                        </div>
                    @endif
                </a>
                <div class="story-info">
                    <span class="genre">{{ $story->genre }}</span>
                    <h3><a href="{{ route('stories.show', $story) }}">{{ $story->title }}</a></h3>
                    <p>by
                        @if($story->user)
                            <a href="{{ route('authors.show', $story->user) }}">{{ $story->author }}</a>
                        @else
                            {{ $story->author }}
                        @endif
                    </p>
                    <div class="story-bottom">
                        <a href="{{ route('stories.show', $story) }}">Read Story →</a>
                    </div>
                </div>
            </article>
        @empty
            <div class="empty-state">
                <div class="empty-icon">✦</div>
                <h3>{{ request('q') ? 'No stories found.' : 'Your reading journey starts here.' }}</h3>
                <p>{{ request('q') ? 'Try a different title, author, or genre.' : 'Be the first to publish a story on TalePad.' }}</p>
                @auth
                    <a href="{{ route('stories.create') }}" class="btn btn-dark">Create Your First Story</a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-dark">Join TalePad</a>
                @endauth
            </div>
        @endforelse
    </div>
</section>
@endsection
