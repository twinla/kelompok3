@extends('layouts.app')
@section('title', 'Penanda Bacaan')
@section('content')
<section class="tp-feature-page"><div class="eyebrow">LANJUTKAN DARI POSISI TERAKHIR</div><h1>Penanda Bacaan</h1><p class="tp-feature-intro">Bab terakhir dan posisi bacaanmu tersimpan otomatis saat kamu membaca dalam keadaan masuk.</p>
<nav class="tp-tabs"><a href="{{ route('library.index', ['shelf' => 'saved']) }}">Buku Tersimpan</a><a href="{{ route('library.index', ['shelf' => 'want_to_read']) }}">Ingin Dibaca</a><a class="active" href="{{ route('reading.bookmarks') }}">Penanda Bacaan</a><a href="{{ route('reading.history') }}">Riwayat Bacaan</a></nav>
<div class="tp-reading-list">
@forelse($progressItems as $item)
    @if($item->story && $item->chapter)
    <article class="tp-progress-card"><div class="tp-progress-cover">@if($item->story->cover)<img src="{{ asset('storage/' . $item->story->cover) }}" alt="">@else<span>{{ __($item->story->genre) }}</span>@endif</div><div class="tp-progress-info"><span class="genre">{{ __($item->story->genre) }}</span><h3>{{ $item->story->title }}</h3><p>Bab {{ $item->chapter->chapter_number }} · {{ $item->chapter->title === 'Chapter ' . $item->chapter->chapter_number ? 'Bab ' . $item->chapter->chapter_number : $item->chapter->title }}</p><div class="tp-progress-track"><span style="width: {{ $item->progress_percent }}%"></span></div><small>{{ $item->progress_percent }}% dari bab ini · {{ $item->last_read_at?->locale('id')->diffForHumans() }}</small><a href="{{ route('chapters.read', [$item->story, $item->chapter]) }}?resume=1" class="btn btn-dark">Lanjutkan Membaca →</a></div></article>
    @endif
@empty <div class="empty-state"><h3>Belum ada penanda bacaan.</h3><p>Buka bab saat sudah masuk. TalePad akan mengingat posisi terakhirmu.</p><a href="{{ route('stories.index') }}" class="btn btn-dark">Jelajahi Cerita</a></div> @endforelse
</div>@include('partials.pagination', ['paginator' => $progressItems])
</section>
@endsection
