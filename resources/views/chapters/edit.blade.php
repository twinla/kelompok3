@extends('layouts.app')
@section('title', 'Sunting Bab | ' . $story->title)
@section('content')
<section class="tp-editor-page"><a href="{{ route('stories.show', $story) }}" class="back-link">← Kembali ke cerita</a><div class="eyebrow">RUANG KERJA PENULIS</div><h1>Sunting Bab {{ $chapter->chapter_number }}</h1><p class="tp-editor-subtitle">{{ $story->title }}</p>
    <form action="{{ route('chapters.update', [$story, $chapter]) }}" method="POST" class="tp-editor-form">@csrf @method('PUT') @include('chapters._form')<div class="tp-form-actions"><button class="btn btn-dark" type="submit">Perbarui Bab</button><a class="btn btn-outline" href="{{ route('stories.show', $story) }}">Batal</a></div></form>
</section>
@endsection
