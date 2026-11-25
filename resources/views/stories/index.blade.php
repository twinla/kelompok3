@extends('layouts.app')

@section('title', 'Jelajahi Cerita')

@section('content')
<section class="tp-top-area">
    <div class="tp-top-search">
        <form action="{{ route('stories.index') }}" method="GET" class="search-form">
            <input type="search" name="q" placeholder="Cari judul, penulis, atau genre..." value="{{ request('q') }}" aria-label="Cari cerita">
            <input type="hidden" name="per_page" value="{{ $perPage }}">
            <button type="submit">Cari →</button>
        </form>
    </div>
</section>

<section class="hero">
    <div class="hero-content">
        <div class="eyebrow">CERITA FAVORITMU BERIKUTNYA MENANTI</div>
        <h1>Setiap cerita memiliki<br>dunia <em>untuk dijelajahi.</em></h1>
        <p>Temukan kisah baru, kenali para penulis, dan biarkan imajinasimu menjelajah.</p>
        <div class="hero-actions">
            <a href="#discover" class="btn btn-gold">Jelajahi Cerita →</a>
            <a href="{{ route('stories.random') }}" class="btn btn-outline">⇄ Pilihkan Cerita</a>
            <a href="{{ route('recommendations.index') }}" class="btn btn-outline">Untukmu</a>
        </div>
    </div>
    <div class="hero-decoration"><div class="hero-circle"><span>TALEPAD</span><strong>Cerita<br>Melampaui<br>Imajinasi.</strong><small>BERDIRI SEJAK 2026</small></div></div>
</section>

<section class="discover-section" id="discover">
    <div class="section-heading">
        <div><div class="eyebrow">RUANG BACA</div><h2>{{ request('q') ? 'Hasil Pencarian' : 'Temukan bacaan berikutnya.' }}</h2></div>
        @auth <a href="{{ route('stories.create') }}" class="btn btn-dark">+ Terbitkan Cerita</a>
        @else <a href="{{ route('login') }}" class="btn btn-dark">Masuk untuk Menerbitkan</a> @endauth
    </div>

    <form action="{{ route('stories.index') }}" method="GET" class="tp-discovery-filters">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari judul, penulis, atau genre..." aria-label="Cari">
        <input type="hidden" name="per_page" value="{{ $perPage }}">
        <select name="genre" aria-label="Saring genre">
            <option value="">Semua genre</option>
            @foreach($genres as $genreOption)
                <option value="{{ $genreOption }}" @selected(request('genre') === $genreOption)>{{ __($genreOption) }}</option>
            @endforeach
        </select>
        <select name="sort" aria-label="Urutkan cerita">
            <option value="latest" @selected($sort === 'latest')>Terbaru</option>
            <option value="popular" @selected($sort === 'popular')>Paling disukai</option>
            <option value="top_rated" @selected($sort === 'top_rated')>Penilaian tertinggi</option>
            <option value="title" @selected($sort === 'title')>Judul A–Z</option>
        </select>
        <button type="submit" class="btn btn-dark">Terapkan</button>
        <a href="{{ route('stories.index') }}" class="tp-filter-reset">Atur ulang</a>
    </form>

    <div class="story-grid">
        @forelse($stories as $story)
            <article class="story-card">
                <a href="{{ route('stories.show', $story) }}" class="cover-link">
                    @if($story->cover) <img src="{{ asset('storage/' . $story->cover) }}" alt="{{ $story->title }}" class="story-cover">
                    @else <div class="cover-placeholder"><span>{{ __($story->genre) }}</span><strong>{{ $story->title }}</strong><small>EDISI TALEPAD</small></div> @endif
                </a>
                <div class="story-info">
                    <span class="genre">{{ __($story->genre) }}</span>
                    <h3><a href="{{ route('stories.show', $story) }}">{{ $story->title }}</a></h3>
                    <p>Oleh @if($story->user)<a href="{{ route('authors.show', $story->user) }}">{{ $story->author }}</a>@else{{ $story->author }}@endif</p>
                    <div class="tp-card-stats"><span>♥ {{ $story->likes_count }}</span><span>★ {{ $story->ratings_avg_rating ? number_format($story->ratings_avg_rating, 1) : 'Baru' }}</span></div>
                    <div class="story-bottom"><a href="{{ route('stories.show', $story) }}">Baca Cerita →</a></div>
                </div>
            </article>
        @empty
            <div class="empty-state"><div class="empty-icon">✦</div><h3>Cerita tidak ditemukan.</h3><p>Coba ubah kata kunci, genre, atau pilihan urutan.</p></div>
        @endforelse
    </div>
    <section class="tp-discovery-pagination" aria-label="Navigasi halaman daftar cerita">
        <div class="tp-discovery-pagination-top">
            <p class="tp-pagination-summary">
                Menampilkan <strong>{{ $stories->firstItem() ?? 0 }}–{{ $stories->lastItem() ?? 0 }}</strong>
                dari <strong>{{ $stories->total() }}</strong> cerita
            </p>

            <form action="{{ route('stories.index') }}" method="GET" class="tp-per-page-control">
                @if (request()->filled('q'))
                    <input type="hidden" name="q" value="{{ request('q') }}">
                @endif
                @if (request()->filled('genre'))
                    <input type="hidden" name="genre" value="{{ request('genre') }}">
                @endif
                <input type="hidden" name="sort" value="{{ $sort }}">
                <label for="tp-per-page">Tampilkan</label>
                <select id="tp-per-page" name="per_page" aria-label="Jumlah cerita per halaman">
                    @foreach ([5, 10, 20, 40] as $pageSize)
                        <option value="{{ $pageSize }}" @selected($perPage === $pageSize)>{{ $pageSize }}</option>
                    @endforeach
                </select>
                <span>per halaman</span>
                <button type="submit" class="tp-per-page-apply">Terapkan</button>
            </form>
        </div>

        @include('partials.pagination', ['paginator' => $stories])
    </section>
</section>
@endsection
