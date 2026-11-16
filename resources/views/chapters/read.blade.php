@extends('layouts.app')
@section('title', $chapter->title . ' | ' . $story->title)
@section('content')
<section class="tp-reader-page" data-progress-url="{{ route('chapters.progress', [$story, $chapter]) }}" data-resume-percent="{{ $resumePercent }}" data-csrf-token="{{ csrf_token() }}">
    <a href="{{ route('stories.show', $story) }}#chapters" class="back-link">← {{ $story->title }} · All chapters</a>
    <header class="tp-reading-heading"><div class="eyebrow">{{ $story->genre }}</div><h1>{{ $story->title }}</h1><p>Chapter {{ $chapter->chapter_number }} · {{ $chapter->title }}</p></header>
    <div class="tp-reading-toolbar">
        <label for="reader-chapter-select">Jump to chapter</label>
        <select id="reader-chapter-select"><option value="">Select a chapter</option>@foreach($visibleChapters as $item)<option value="{{ route('chapters.read', [$story, $item]) }}" @selected($item->id === $chapter->id)>Chapter {{ $item->chapter_number }} — {{ $item->title }}</option>@endforeach</select>
        <span id="reading-save-state" aria-live="polite">@auth Progress is saved while you read. @else Log in to save your reading position. @endauth</span>
    </div>
    <article class="tp-reading-content" id="reading-content"><div class="eyebrow">CHAPTER {{ $chapter->chapter_number }}</div><h2>{{ $chapter->title }}</h2><div class="tp-reading-text">{{ $chapter->content }}</div></article>
    <nav class="tp-chapter-navigation" aria-label="Chapter navigation">
        @if($previousChapter)<a class="btn btn-outline" href="{{ route('chapters.read', [$story, $previousChapter]) }}">← Previous Chapter</a>@else<span></span>@endif
        @if($nextChapter)<a class="btn btn-dark" href="{{ route('chapters.read', [$story, $nextChapter]) }}">Next Chapter →</a>@else<a class="btn btn-gold" href="{{ route('stories.show', $story) }}#comments">Finish · Back to story</a>@endif
    </nav>
    @if(auth()->check() && (int) auth()->id() === (int) $story->user_id)
        <div class="tp-reader-owner-link"><a href="{{ route('chapters.edit', [$story, $chapter]) }}">Edit this chapter</a></div>
    @endif
</section>
@endsection

@push('scripts')
@auth
<script>
document.addEventListener('DOMContentLoaded', function () {
    const page = document.querySelector('.tp-reader-page');
    const content = document.getElementById('reading-content');
    const state = document.getElementById('reading-save-state');
    const selector = document.getElementById('reader-chapter-select');
    if (selector) selector.addEventListener('change', () => { if (selector.value) window.location.href = selector.value; });
    if (!page || !content) return;
    const resume = Number(page.dataset.resumePercent || 0);
    if (resume > 0) {
        setTimeout(() => {
            const top = window.scrollY + content.getBoundingClientRect().top;
            const max = Math.max(0, content.scrollHeight - window.innerHeight);
            window.scrollTo({ top: top + max * (resume / 100), behavior: 'instant' });
        }, 120);
    }
    let timer = null;
    let lastSaved = -1;
    async function saveProgress() {
        const contentTop = window.scrollY + content.getBoundingClientRect().top;
        const maxScroll = Math.max(1, content.scrollHeight - window.innerHeight);
        const percent = Math.max(0, Math.min(100, Math.round(((window.scrollY - contentTop) / maxScroll) * 100)));
        if (Math.abs(percent - lastSaved) < 2 && percent !== 100) return;
        lastSaved = percent;
        try {
            const response = await fetch(page.dataset.progressUrl, {
                method: 'POST',
                headers: {'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': page.dataset.csrfToken},
                body: JSON.stringify({progress_percent: percent}),
                keepalive: true
            });
            if (response.ok && state) state.textContent = 'Reading progress saved · ' + percent + '%';
        } catch (error) { if (state) state.textContent = 'Progress could not be saved right now.'; }
    }
    window.addEventListener('scroll', () => { clearTimeout(timer); timer = setTimeout(saveProgress, 900); }, {passive: true});
    window.addEventListener('pagehide', saveProgress);
    saveProgress();
});
</script>
@endauth
@endpush
