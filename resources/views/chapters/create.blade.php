@extends('layouts.app')
@section('title', 'Tambah Bab | ' . $story->title)
@section('content')
<section class="tp-editor-page"><a href="{{ route('stories.show', $story) }}" class="back-link">← Kembali ke cerita</a><div class="eyebrow">RUANG KERJA PENULIS</div><h1>Tambah Bab</h1><p class="tp-editor-subtitle">{{ $story->title }} · Bab {{ $story->chapters()->max('chapter_number') + 1 }}</p>
    <form action="{{ route('chapters.store', $story) }}" method="POST" class="tp-editor-form">@csrf @include('chapters._form')<div class="tp-form-actions"><button class="btn btn-dark" type="submit">Simpan Bab</button><a class="btn btn-outline" href="{{ route('stories.show', $story) }}">Batal</a></div></form>
</section>
@endsection
