@extends('layouts.app')

@section('title', $profileUser->name . ' | Author Profile')

@section('content')
<section class="tp-profile-page">
    <div class="tp-profile-heading">
        <div class="tp-profile-avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr($profileUser->name, 0, 1)) }}</div>
        <div class="tp-profile-identity">
            <div class="eyebrow">TALEPAD AUTHOR PROFILE</div>
            <h1>{{ $profileUser->name }}</h1>
            <p>Member since {{ $profileUser->created_at?->format('F Y') ?? 'Recently' }}</p>
            @if($isOwner)
                <a href="{{ route('stories.create') }}" class="btn btn-gold">+ Write a Story</a>
            @endif
        </div>
    </div>

    <div class="tp-profile-stats">
        <article class="tp-profile-stat">
            <span class="tp-profile-stat-number">{{ $publishedStories->count() }}</span>
            <span class="tp-profile-stat-label">Published stories</span>
        </article>
        <article class="tp-profile-stat">
            <span class="tp-profile-stat-number">{{ number_format($publishedWordCount) }}</span>
            <span class="tp-profile-stat-label">Words published</span>
        </article>
        @if($isOwner)
            <article class="tp-profile-stat">
                <span class="tp-profile-stat-number">{{ $draftStories->count() }}</span>
                <span class="tp-profile-stat-label">Private drafts</span>
            </article>
        @endif
    </div>

    <section class="tp-profile-section">
        <div class="tp-profile-section-heading">
            <div>
                <div class="eyebrow">THE AUTHOR'S LIBRARY</div>
                <h2>Published stories</h2>
            </div>
        </div>

        @if($publishedStories->isNotEmpty())
            <div class="story-grid">
                @foreach($publishedStories as $story)
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
                            <p>Updated {{ $story->updated_at->format('d M Y') }}</p>
                            <div class="story-bottom">
                                <a href="{{ route('stories.show', $story) }}">Read Story →</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="tp-profile-empty">
                <h3>No published stories yet.</h3>
                <p>When this author publishes a novel, it will appear here.</p>
            </div>
        @endif
    </section>

    @if($isOwner)
        <section class="tp-profile-section tp-profile-drafts">
            <div class="tp-profile-section-heading">
                <div>
                    <div class="eyebrow">YOUR WORK IN PROGRESS</div>
                    <h2>Private drafts</h2>
                    <p>Only you can see these drafts.</p>
                </div>
            </div>

            @if($draftStories->isNotEmpty())
                <div class="tp-profile-draft-list">
                    @foreach($draftStories as $story)
                        <article class="tp-profile-draft-item">
                            <div>
                                <span class="tp-profile-draft-badge">DRAFT</span>
                                <h3>{{ $story->title }}</h3>
                                <p>Last updated {{ $story->updated_at->format('d M Y') }}</p>
                            </div>
                            <a href="{{ route('stories.edit', $story) }}" class="btn btn-outline">Continue writing</a>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="tp-profile-empty">
                    <p>You do not have any drafts yet.</p>
                    <a href="{{ route('stories.create') }}" class="btn btn-dark">Start a new story</a>
                </div>
            @endif
        </section>
    @endif
</section>
@endsection
