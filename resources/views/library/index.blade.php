@extends('layouts.app')
@section('title', 'Pustaka Saya')
@section('content')
<section class="tp-feature-page"><div class="eyebrow">RAK BACA PRIBADIMU</div><h1>Pustaka Saya</h1><p class="tp-feature-intro">Simpan cerita favorit dan cerita yang ingin kamu baca nanti.</p>
    <nav class="tp-tabs"><a class="{{ $shelf === 'saved' ? 'active' : '' }}" href="{{ route('library.index', ['shelf' => 'saved']) }}">Buku Tersimpan</a><a class="{{ $shelf === 'want_to_read' ? 'active' : '' }}" href="{{ route('library.index', ['shelf' => 'want_to_read']) }}">Ingin Dibaca</a><a href="{{ route('reading.bookmarks') }}">Penanda Bacaan</a><a href="{{ route('reading.history') }}">Riwayat Bacaan</a></nav>
    <div class="story-grid">
        @forelse($entries as $entry)
            @php($story = $entry->story)
            <article class="story-card"><a class="cover-link" href="{{ route('stories.show', $story) }}">@if($story->cover)<img class="story-cover" src="{{ asset('storage/' . $story->cover) }}" alt="{{ $story->title }}">@else<div class="cover-placeholder"><span>{{ __($story->genre) }}</span><strong>{{ $story->title }}</strong><small>EDISI TALEPAD</small></div>@endif</a><div class="story-info"><span class="genre">{{ __($story->genre) }}</span><h3><a href="{{ route('stories.show', $story) }}">{{ $story->title }}</a></h3><p>Oleh {{ $story->author }}</p><div class="story-bottom"><a href="{{ route('stories.show', $story) }}">Buka Cerita →</a><form action="{{ route('library.destroy', $entry) }}" method="POST">@csrf @method('DELETE')<button type="submit" class="tp-text-button">Hapus</button></form></div></div></article>
        @empty <div class="empty-state"><h3>Rak ini masih kosong.</h3><p>Buka cerita lalu tambahkan ke rak {{ $shelf === 'saved' ? 'Buku Tersimpan' : 'Ingin Dibaca' }}.</p><a href="{{ route('stories.index') }}" class="btn btn-dark">Jelajahi Cerita</a></div> @endforelse
    </div>
    @include('partials.pagination', ['paginator' => $entries])
</section>
@endsection
