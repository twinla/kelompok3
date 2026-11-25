@extends('layouts.app')
@section('title', 'Riwayat Bacaan')
@section('content')
<section class="tp-feature-page"><div class="eyebrow">PERJALANAN MEMBACAMU</div><h1>Riwayat Bacaan</h1><p class="tp-feature-intro">Cerita yang pernah kamu buka, bab terakhir yang dibaca, serta bacaan yang telah diselesaikan.</p>
<nav class="tp-tabs"><a href="{{ route('library.index', ['shelf' => 'saved']) }}">Buku Tersimpan</a><a href="{{ route('library.index', ['shelf' => 'want_to_read']) }}">Ingin Dibaca</a><a href="{{ route('reading.bookmarks') }}">Penanda Bacaan</a><a class="active" href="{{ route('reading.history') }}">Riwayat Bacaan</a></nav>
<div class="tp-history-list">
@forelse($progressItems as $item)
    @if($item->story)
    <article class="tp-history-row"><div><span class="genre">{{ __($item->story->genre) }}</span><h3><a href="{{ route('stories.show', $item->story) }}">{{ $item->story->title }}</a></h3><p>{{ $item->chapter ? 'Bab ' . $item->chapter->chapter_number . ' · ' . ($item->chapter->title === 'Chapter ' . $item->chapter->chapter_number ? 'Bab ' . $item->chapter->chapter_number : $item->chapter->title) : 'Bab tidak tersedia' }}</p><small>Terakhir dibaca {{ $item->last_read_at?->locale('id')->translatedFormat('d M Y, H:i') ?? 'Baru saja' }}</small></div><div class="tp-history-status">@if($item->completed_at)<span class="tp-status-complete">Selesai</span>@else<span class="tp-status-reading">Sedang dibaca · {{ $item->progress_percent }}%</span>@endif @if($item->chapter)<a href="{{ route('chapters.read', [$item->story, $item->chapter]) }}?resume=1">Lanjutkan →</a>@endif</div></article>
    @endif
@empty <div class="empty-state"><h3>Riwayat bacaanmu masih kosong.</h3><p>Mulai baca sebuah bab untuk mengisi riwayat bacaanmu.</p></div> @endforelse
</div>@include('partials.pagination', ['paginator' => $progressItems])
</section>
@endsection
