@extends('layouts.app')
@section('title', 'Rekomendasi Untukmu')
@section('content')
<section class="tp-feature-page"><div class="eyebrow">REKOMENDASI BACAAN BERIKUTNYA</div><h1>Rekomendasi Cerita</h1>
@if(auth()->check() && $preferredGenres->isNotEmpty())<p class="tp-feature-intro">Berdasarkan genre yang kamu sukai: {{ $preferredGenres->map(fn ($genre) => __($genre))->implode(', ') }}.</p>
@elseif(auth()->check())<p class="tp-feature-intro">Semakin sering kamu menyukai, memberi penilaian, dan membaca cerita, rekomendasi akan semakin sesuai. Untuk saat ini, jelajahi cerita populer.</p>
@else<p class="tp-feature-intro">Cerita populer dengan penilaian tinggi dari komunitas TalePad.</p>@endif
<div class="story-grid">
@forelse($stories as $story)
<article class="story-card"><a href="{{ route('stories.show', $story) }}" class="cover-link">@if($story->cover)<img class="story-cover" src="{{ asset('storage/' . $story->cover) }}" alt="{{ $story->title }}">@else<div class="cover-placeholder"><span>{{ __($story->genre) }}</span><strong>{{ $story->title }}</strong><small>EDISI TALEPAD</small></div>@endif</a><div class="story-info"><span class="genre">{{ __($story->genre) }}</span><h3><a href="{{ route('stories.show', $story) }}">{{ $story->title }}</a></h3><p>Oleh {{ $story->author }}</p><div class="tp-card-stats"><span>♥ {{ $story->likes_count }}</span><span>★ {{ $story->ratings_avg_rating ? number_format($story->ratings_avg_rating, 1) : 'Baru' }}</span></div><div class="story-bottom"><a href="{{ route('stories.show', $story) }}">Baca Cerita →</a></div></div></article>
@empty<div class="empty-state"><h3>Belum ada rekomendasi.</h3><p>Kunjungi lagi setelah lebih banyak cerita diterbitkan.</p></div>@endforelse
</div>@include('partials.pagination', ['paginator' => $stories])
</section>
@endsection
