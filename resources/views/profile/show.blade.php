@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/talepad-profile.css') }}?v=1">
@endpush

@section('title', $user->name . ' | Profil Penulis')

@section('content')
<section class="tp-profile-page">
    <div class="tp-profile-heading">
        @if($user->avatar_path)
            <img
                class="tp-profile-avatar tp-profile-avatar-image"
                src="{{ asset('storage/' . $user->avatar_path) }}"
                alt="Foto profil {{ $user->name }}"
            >
        @else
            <div class="tp-profile-avatar" aria-label="Inisial {{ $user->name }}">
                {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
            </div>
        @endif

        <div class="tp-profile-identity">
            <div class="eyebrow">PROFIL PENULIS TALEPAD</div>
            <h1>{{ $user->name }}</h1>
            <p class="tp-profile-member-since">Bergabung sejak {{ $user->created_at?->locale('id')->isoFormat('MMMM YYYY') ?? 'Baru saja' }}</p>

            @if($user->bio)
                <p class="tp-profile-bio">{{ $user->bio }}</p>
            @else
                <p class="tp-profile-bio tp-profile-bio-empty">{{ $isOwner ? 'Tambahkan bio singkat agar pembaca bisa mengenalmu.' : 'Penulis ini belum menambahkan bio.' }}</p>
            @endif

            <div class="tp-profile-actions">
                @if($isOwner)
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline">Sunting Profil</a>
                    <a href="{{ route('stories.create') }}" class="btn btn-gold">+ Tulis Cerita</a>
                @elseif(auth()->check())
                    <form action="{{ route('authors.follow', $user) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-dark" @if($isFollowing) aria-pressed="true" @else aria-pressed="false" @endif>
                            {{ $isFollowing ? 'Mengikuti ✓' : '+ Ikuti Penulis' }}
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-dark">Masuk untuk mengikuti</a>
                @endif
            </div>
        </div>
    </div>

    <div class="tp-profile-stats">
        <article class="tp-profile-stat">
            <span class="tp-profile-stat-number">{{ $publishedStories->count() }}</span>
            <span class="tp-profile-stat-label">Cerita Terbit</span>
        </article>
        <article class="tp-profile-stat">
            <span class="tp-profile-stat-number">{{ number_format($publishedWordCount) }}</span>
            <span class="tp-profile-stat-label">Jumlah Kata Terbit</span>
        </article>
        <article class="tp-profile-stat">
            <span class="tp-profile-stat-number">{{ $followersCount }}</span>
            <span class="tp-profile-stat-label">Pengikut</span>
        </article>
        <article class="tp-profile-stat">
            <span class="tp-profile-stat-number">{{ $followingCount }}</span>
            <span class="tp-profile-stat-label">Mengikuti</span>
        </article>
    </div>

    <section class="tp-profile-section">
        <div class="tp-profile-section-heading">
            <div>
                <div class="eyebrow">KOLEKSI PENULIS</div>
                <h2>Cerita Terbit</h2>
            </div>
        </div>

        @if($publishedStories->isNotEmpty())
            <div class="story-grid">
                @foreach($publishedStories as $story)
                    <article class="story-card">
                        <a href="{{ route('stories.show', $story) }}" class="cover-link">
                            @if($story->cover)
                                <img src="{{ asset('storage/' . $story->cover) }}" class="story-cover" alt="{{ $story->title }}">
                            @else
                                <div class="cover-placeholder">
                                    <span>{{ __($story->genre) }}</span>
                                    <strong>{{ $story->title }}</strong>
                                    <small>EDISI TALEPAD</small>
                                </div>
                            @endif
                        </a>
                        <div class="story-info">
                            <span class="genre">{{ __($story->genre) }}</span>
                            <h3><a href="{{ route('stories.show', $story) }}">{{ $story->title }}</a></h3>
                            <p>Diperbarui {{ $story->updated_at->locale('id')->translatedFormat('d M Y') }}</p>
                            <div class="tp-card-stats">
                                <span>♥ {{ $story->likes_count }}</span>
                                <span>★ {{ $story->ratings_avg_rating ? number_format($story->ratings_avg_rating, 1) : 'Baru' }}</span>
                            </div>
                            <div class="story-bottom"><a href="{{ route('stories.show', $story) }}">Baca Cerita →</a></div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="tp-profile-empty"><h3>Belum ada cerita yang diterbitkan.</h3></div>
        @endif
    </section>

    @if($isOwner)
        <section class="tp-profile-section tp-profile-drafts">
            <div class="eyebrow">KARYA YANG SEDANG DIKERJAKAN</div>
            <h2>Draf Pribadi</h2>
            @forelse($draftStories as $story)
                <article class="tp-profile-draft-item">
                    <div>
                        <span class="tp-profile-draft-badge">DRAF</span>
                        <h3>{{ $story->title }}</h3>
                    </div>
                    <a href="{{ route('stories.edit', $story) }}" class="btn btn-outline">Lanjutkan Menulis</a>
                </article>
            @empty
                <p>Kamu belum memiliki draf.</p>
            @endforelse
        </section>
    @endif
</section>
@endsection
