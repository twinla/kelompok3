@extends('layouts.app')

@section('title', $story->title)

@section('content')
<section class="reader-page tp-feature-page">
    <a href="{{ route('stories.index') }}" class="back-link">← Back to Discover</a>
    <div class="reader-header">
        <div class="reader-cover">
            @if($story->cover) <img src="{{ asset('storage/' . $story->cover) }}" alt="{{ $story->title }}">
            @else <div class="cover-placeholder reader-placeholder"><span>{{ $story->genre }}</span><strong>{{ $story->title }}</strong><small>TALEPAD EDITION</small></div> @endif
        </div>
        <div class="reader-details">
            <span class="genre">{{ $story->genre }}</span>
            <h1>{{ $story->title }}</h1>
            <p class="reader-author">Written by
                @if($story->user)<a href="{{ route('authors.show', $story->user) }}">{{ $story->author }}</a>@else{{ $story->author }}@endif
            </p>
            <div class="reader-synopsis">{{ $story->synopsis }}</div>
            <div class="reader-meta"><span>{{ $story->created_at->format('d M Y') }}</span><span>{{ $chapters->count() }} chapters</span><span>★ {{ $averageRating ? number_format($averageRating, 1) : 'No rating' }} ({{ $ratingCount }})</span></div>
            <div class="reader-actions">
                @if($chapters->isNotEmpty()) <a href="{{ route('chapters.read', [$story, $chapters->first()]) }}" class="btn btn-gold">Start Reading ↓</a>
                @elseif($isOwner) <a href="{{ route('chapters.create', $story) }}" class="btn btn-gold">+ Add First Chapter</a> @endif
                @if($isOwner)
                    <a href="{{ route('stories.edit', $story) }}" class="btn btn-outline">Edit Story</a>
                    <form action="{{ route('stories.destroy', $story) }}" method="POST" onsubmit="return confirm('Delete this story and its chapters?')">@csrf @method('DELETE')<button type="submit" class="btn btn-danger">Delete</button></form>
                @endif
            </div>
            @if($story->user && auth()->check() && !$isOwner)
                <form action="{{ route('authors.follow', $story->user) }}" method="POST" class="tp-inline-form">@csrf
                    <button class="btn btn-outline" type="submit">{{ $isFollowingAuthor ? 'Following author ✓' : '+ Follow author' }}</button>
                </form>
            @endif
        </div>
    </div>

    <section class="tp-social-bar">
        <div class="tp-social-actions">
            @auth
                <form action="{{ route('stories.like', $story) }}" method="POST">@csrf<button class="tp-action-button {{ $isLiked ? 'is-active' : '' }}" type="submit">♥ {{ $isLiked ? 'Liked' : 'Like' }} · {{ $likeCount }}</button></form>
                <form action="{{ route('library.store', $story) }}" method="POST">@csrf
                    <select name="shelf" aria-label="Choose library shelf"><option value="saved" @selected($libraryEntry?->shelf === 'saved')>Saved Books</option><option value="want_to_read" @selected($libraryEntry?->shelf === 'want_to_read')>Want to Read</option></select>
                    <button class="tp-action-button" type="submit">＋ {{ $libraryEntry ? 'Update Library' : 'Add to Library' }}</button>
                </form>
            @else
                <a class="tp-action-button" href="{{ route('login') }}">Log in to Like</a><a class="tp-action-button" href="{{ route('login') }}">Log in to Save</a>
            @endauth
        </div>
        <div class="tp-rating-box">
            <strong>Rate this story</strong>
            @auth
                <form action="{{ route('stories.rating', $story) }}" method="POST" class="tp-rating-form">@csrf
                    <select name="rating" required aria-label="Rating from 1 to 5"><option value="">Choose rating</option>@for($star = 5; $star >= 1; $star--)<option value="{{ $star }}" @selected((int) $userRating === $star)>{{ $star }} / 5 stars</option>@endfor</select>
                    <button type="submit" class="btn btn-dark">Submit</button>
                </form>
            @else <a href="{{ route('login') }}">Log in to rate</a> @endauth
        </div>
    </section>

    <section class="tp-chapter-section" id="chapters">
        <div class="tp-section-title-row"><div><div class="eyebrow">CONTINUE THE JOURNEY</div><h2>Chapters</h2><p>{{ $chapters->count() }} chapters available</p></div>
            @if($isOwner)<a href="{{ route('chapters.create', $story) }}" class="btn btn-dark">+ Add Chapter</a>@endif
        </div>
        @if($chapters->isNotEmpty())
            <div class="tp-chapter-tools"><input type="search" id="chapter-search" placeholder="Find a chapter by number or title..."><select id="chapter-jump" aria-label="Jump to chapter"><option value="">Choose chapter...</option>@foreach($chapters as $chapter)<option value="{{ route('chapters.read', [$story, $chapter]) }}">Chapter {{ $chapter->chapter_number }} — {{ $chapter->title }}</option>@endforeach</select></div>
            <div class="tp-chapter-list" id="chapter-list">
                @foreach($chapters as $chapter)
                    <article class="tp-chapter-row" data-chapter-search="{{ strtolower('chapter ' . $chapter->chapter_number . ' ' . $chapter->title) }}">
                        <a href="{{ route('chapters.read', [$story, $chapter]) }}"><span class="tp-chapter-number">{{ str_pad($chapter->chapter_number, 2, '0', STR_PAD_LEFT) }}</span><span><strong>{{ $chapter->title }}</strong><small>{{ $chapter->status === 'draft' ? 'Draft' : 'Published' }}</small></span></a>
                        @if($isOwner)<div class="tp-chapter-owner-actions"><a href="{{ route('chapters.edit', [$story, $chapter]) }}">Edit</a><form action="{{ route('chapters.destroy', [$story, $chapter]) }}" method="POST" onsubmit="return confirm('Delete this chapter?')">@csrf @method('DELETE')<button type="submit">Delete</button></form></div>@endif
                    </article>
                @endforeach
            </div>
        @else
            <div class="tp-empty-note">No chapters have been published yet.</div>
        @endif
    </section>

    {{-- Galeri karakter yang sudah ada tetap dipertahankan. --}}
    <section class="tp-character-section" id="characters">
        <div class="eyebrow">GET TO KNOW THE CAST</div><h2>Meet the Characters</h2><p class="tp-character-intro">Discover the people who bring this story to life.</p>
        @if($story->characters->isNotEmpty())
            <div class="tp-character-grid">
                @foreach($story->characters as $character)
                    <article class="tp-character-card"><img src="{{ asset('storage/' . $character->image) }}" alt="{{ $character->name }}"><div class="tp-character-info"><h3>{{ $character->name }}</h3>@if($character->description)<p>{{ $character->description }}</p>@endif
                        @if($isOwner)<form action="{{ route('stories.characters.destroy', [$story, $character]) }}" method="POST" onsubmit="return confirm('Remove this character?')">@csrf @method('DELETE')<button type="submit" class="tp-character-delete">Remove character</button></form>@endif
                    </div></article>
                @endforeach
            </div>
        @else <p class="tp-no-characters">The author has not added any character profiles yet.</p> @endif
        @if($isOwner)
            <div class="tp-character-form-wrap"><h3>Add a character</h3><form action="{{ route('stories.characters.store', $story) }}" method="POST" enctype="multipart/form-data" class="tp-character-form">@csrf
                <label>Character name</label><input type="text" name="name" maxlength="100" required>
                <label>Description</label><textarea name="description" rows="3" maxlength="1000"></textarea>
                <label>Character photo</label><input type="file" name="image" accept=".jpg,.jpeg,.png,.webp" required>
                <button type="submit" class="btn btn-dark">+ Add Character</button>
            </form></div>
        @endif
    </section>

    <section class="tp-comments-section" id="comments">
        <div class="eyebrow">READERS' CORNER</div><h2>Comments</h2>
        @auth
            <form action="{{ route('stories.comments.store', $story) }}" method="POST" class="tp-comment-form">@csrf
                <textarea name="content" rows="3" maxlength="2000" required placeholder="Share your thoughts about this story..."></textarea>
                @error('content')<small class="error">{{ $message }}</small>@enderror
                <button type="submit" class="btn btn-dark">Post Comment</button>
            </form>
        @else <p><a href="{{ route('login') }}">Log in</a> to join the discussion.</p> @endauth
        <div class="tp-comment-list">
            @forelse($comments as $comment)
                <article class="tp-comment-card"><div class="tp-comment-meta"><strong>{{ $comment->user->name }}</strong><span>{{ $comment->created_at->diffForHumans() }}</span></div><p>{{ $comment->content }}</p>
                    @auth @if((int) auth()->id() === (int) $comment->user_id || $isOwner)
                        <form action="{{ route('stories.comments.destroy', [$story, $comment]) }}" method="POST" onsubmit="return confirm('Delete this comment?')">@csrf @method('DELETE')<button class="tp-comment-delete" type="submit">Delete</button></form>
                    @endif @endauth
                </article>
            @empty <p class="tp-empty-note">No comments yet. Be the first to share your thoughts.</p> @endforelse
        </div>
        @include('partials.pagination', ['paginator' => $comments])
    </section>
</section>

@endsection
