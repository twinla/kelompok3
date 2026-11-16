@extends('layouts.app')
@section('title', 'Edit Chapter | ' . $story->title)
@section('content')
<section class="tp-editor-page"><a href="{{ route('stories.show', $story) }}" class="back-link">← Back to novel</a><div class="eyebrow">AUTHOR WORKSPACE</div><h1>Edit chapter {{ $chapter->chapter_number }}</h1><p class="tp-editor-subtitle">{{ $story->title }}</p>
    <form action="{{ route('chapters.update', [$story, $chapter]) }}" method="POST" class="tp-editor-form">@csrf @method('PUT') @include('chapters._form')<div class="tp-form-actions"><button class="btn btn-dark" type="submit">Update Chapter</button><a class="btn btn-outline" href="{{ route('stories.show', $story) }}">Cancel</a></div></form>
</section>
@endsection
