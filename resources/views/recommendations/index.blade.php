@extends('layouts.app')
@section('title', 'Recommended for You')
@section('content')
<section class="tp-feature-page"><div class="eyebrow">A LITTLE SOMETHING TO READ NEXT</div><h1>Recommended Stories</h1>
@if(auth()->check() && $preferredGenres->isNotEmpty())<p class="tp-feature-intro">Based on the genres you like: {{ $preferredGenres->implode(', ') }}.</p>
@elseif(auth()->check())<p class="tp-feature-intro">As you like, rate, and read stories, recommendations will become more relevant. For now, explore popular stories.</p>
@else<p class="tp-feature-intro">Popular and highly rated stories from the TalePad community.</p>@endif
<div class="story-grid">
@forelse($stories as $story)
<article class="story-card"><a href="{{ route('stories.show', $story) }}" class="cover-link">@if($story->cover)<img class="story-cover" src="{{ asset('storage/' . $story->cover) }}" alt="{{ $story->title }}">@else<div class="cover-placeholder"><span>{{ $story->genre }}</span><strong>{{ $story->title }}</strong><small>TALEPAD EDITION</small></div>@endif</a><div class="story-info"><span class="genre">{{ $story->genre }}</span><h3><a href="{{ route('stories.show', $story) }}">{{ $story->title }}</a></h3><p>by {{ $story->author }}</p><div class="tp-card-stats"><span>♥ {{ $story->likes_count }}</span><span>★ {{ $story->ratings_avg_rating ? number_format($story->ratings_avg_rating, 1) : 'New' }}</span></div><div class="story-bottom"><a href="{{ route('stories.show', $story) }}">Read Story →</a></div></div></article>
@empty<div class="empty-state"><h3>No recommendations yet.</h3><p>Check back after more stories are published.</p></div>@endforelse
</div>{{ $stories->links() }}
</section>
@endsection
