@extends('layouts.app')
@section('title', 'Reading History')
@section('content')
<section class="tp-feature-page"><div class="eyebrow">YOUR READING JOURNEY</div><h1>Reading History</h1><p class="tp-feature-intro">Stories you have opened, the latest chapter you reached, and completed reads.</p>
<nav class="tp-tabs"><a href="{{ route('library.index', ['shelf' => 'saved']) }}">Saved Books</a><a href="{{ route('library.index', ['shelf' => 'want_to_read']) }}">Want to Read</a><a href="{{ route('reading.bookmarks') }}">Reading Bookmarks</a><a class="active" href="{{ route('reading.history') }}">Reading History</a></nav>
<div class="tp-history-list">
@forelse($progressItems as $item)
    @if($item->story)
    <article class="tp-history-row"><div><span class="genre">{{ $item->story->genre }}</span><h3><a href="{{ route('stories.show', $item->story) }}">{{ $item->story->title }}</a></h3><p>{{ $item->chapter ? 'Chapter ' . $item->chapter->chapter_number . ' · ' . $item->chapter->title : 'Chapter unavailable' }}</p><small>Last read {{ $item->last_read_at?->format('d M Y, H:i') ?? 'Recently' }}</small></div><div class="tp-history-status">@if($item->completed_at)<span class="tp-status-complete">Completed</span>@else<span class="tp-status-reading">Reading · {{ $item->progress_percent }}%</span>@endif @if($item->chapter)<a href="{{ route('chapters.read', [$item->story, $item->chapter]) }}?resume=1">Continue →</a>@endif</div></article>
    @endif
@empty <div class="empty-state"><h3>Your history is empty.</h3><p>Start reading a chapter to build your reading history.</p></div> @endforelse
</div>@include('partials.pagination', ['paginator' => $progressItems])
</section>
@endsection
