@extends('layouts.app')
@section('title', 'Add Chapter | ' . $story->title)
@section('content')
<section class="tp-editor-page"><a href="{{ route('stories.show', $story) }}" class="back-link">← Back to novel</a><div class="eyebrow">AUTHOR WORKSPACE</div><h1>Add a chapter</h1><p class="tp-editor-subtitle">{{ $story->title }} · Chapter {{ $story->chapters()->max('chapter_number') + 1 }}</p>
    <form action="{{ route('chapters.store', $story) }}" method="POST" class="tp-editor-form">@csrf @include('chapters._form')<div class="tp-form-actions"><button class="btn btn-dark" type="submit">Save Chapter</button><a class="btn btn-outline" href="{{ route('stories.show', $story) }}">Cancel</a></div></form>
</section>
@endsection
