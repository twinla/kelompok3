@extends('layouts.app')
@section('title', 'My Library')
@section('content')
<section class="tp-feature-page"><div class="eyebrow">YOUR PERSONAL SHELVES</div><h1>My Library</h1><p class="tp-feature-intro">Keep the stories you love and the ones you want to read next.</p>
    <nav class="tp-tabs"><a class="{{ $shelf === 'saved' ? 'active' : '' }}" href="{{ route('library.index', ['shelf' => 'saved']) }}">Saved Books</a><a class="{{ $shelf === 'want_to_read' ? 'active' : '' }}" href="{{ route('library.index', ['shelf' => 'want_to_read']) }}">Want to Read</a><a href="{{ route('reading.bookmarks') }}">Reading Bookmarks</a><a href="{{ route('reading.history') }}">Reading History</a></nav>
    <div class="story-grid">
        @forelse($entries as $entry)
            @php($story = $entry->story)
            <article class="story-card"><a class="cover-link" href="{{ route('stories.show', $story) }}">@if($story->cover)<img class="story-cover" src="{{ asset('storage/' . $story->cover) }}" alt="{{ $story->title }}">@else<div class="cover-placeholder"><span>{{ $story->genre }}</span><strong>{{ $story->title }}</strong><small>TALEPAD EDITION</small></div>@endif</a><div class="story-info"><span class="genre">{{ $story->genre }}</span><h3><a href="{{ route('stories.show', $story) }}">{{ $story->title }}</a></h3><p>by {{ $story->author }}</p><div class="story-bottom"><a href="{{ route('stories.show', $story) }}">Open Story →</a><form action="{{ route('library.destroy', $entry) }}" method="POST">@csrf @method('DELETE')<button type="submit" class="tp-text-button">Remove</button></form></div></div></article>
        @empty <div class="empty-state"><h3>This shelf is empty.</h3><p>Open a novel and add it to {{ $shelf === 'saved' ? 'Saved Books' : 'Want to Read' }}.</p><a href="{{ route('stories.index') }}" class="btn btn-dark">Explore Stories</a></div> @endforelse
    </div>
    {{ $entries->links() }}
</section>
@endsection
