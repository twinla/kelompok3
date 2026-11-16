@extends('layouts.app')
@section('title', 'Reading Bookmarks')
@section('content')
<section class="tp-feature-page"><div class="eyebrow">PICK UP WHERE YOU LEFT OFF</div><h1>Reading Bookmarks</h1><p class="tp-feature-intro">Your last chapter and reading position are saved here automatically when you read while logged in.</p>
<nav class="tp-tabs"><a href="{{ route('library.index', ['shelf' => 'saved']) }}">Saved Books</a><a href="{{ route('library.index', ['shelf' => 'want_to_read']) }}">Want to Read</a><a class="active" href="{{ route('reading.bookmarks') }}">Reading Bookmarks</a><a href="{{ route('reading.history') }}">Reading History</a></nav>
<div class="tp-reading-list">
@forelse($progressItems as $item)
    @if($item->story && $item->chapter)
    <article class="tp-progress-card"><div class="tp-progress-cover">@if($item->story->cover)<img src="{{ asset('storage/' . $item->story->cover) }}" alt="">@else<span>{{ $item->story->genre }}</span>@endif</div><div class="tp-progress-info"><span class="genre">{{ $item->story->genre }}</span><h3>{{ $item->story->title }}</h3><p>Chapter {{ $item->chapter->chapter_number }} · {{ $item->chapter->title }}</p><div class="tp-progress-track"><span style="width: {{ $item->progress_percent }}%"></span></div><small>{{ $item->progress_percent }}% through this chapter · {{ $item->last_read_at?->diffForHumans() }}</small><a href="{{ route('chapters.read', [$item->story, $item->chapter]) }}?resume=1" class="btn btn-dark">Continue Reading →</a></div></article>
    @endif
@empty <div class="empty-state"><h3>No reading bookmarks yet.</h3><p>Open a chapter while logged in. TalePad will remember where you stopped.</p><a href="{{ route('stories.index') }}" class="btn btn-dark">Discover Stories</a></div> @endforelse
</div>{{ $progressItems->links() }}
</section>
@endsection
