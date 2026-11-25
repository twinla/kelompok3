<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#263A30">
    <meta name="description" content="TalePad — temukan cerita, jelajahi dunia, dan bagikan tulisanmu.">
    <title>@yield('title', 'Jelajahi Cerita') — TalePad</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <link rel="stylesheet" href="{{ asset('css/talepad-pdf-library.css') }}?v=1">
    {{-- Loaded after Vite and page styles so pagination stays styled even with a stale build manifest. --}}
    <link rel="stylesheet" href="{{ asset('css/talepad-pagination.css') }}?v=4">
    <link rel="stylesheet" href="{{ asset('css/talepad-kontras.css') }}?v=20261125-2">
</head>
<body>
    <header class="tp-site-header">
        <div class="tp-navbar">
            <div class="tp-navbar-inner">
                <x-brand />

                <nav class="tp-nav-links" aria-label="Navigasi utama">
                    <div class="tp-dropdown">
                        <button type="button" class="tp-dropdown-toggle" aria-expanded="false" aria-haspopup="true">
                            Jelajahi <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                        </button>
                        <div class="tp-dropdown-menu">
                            <a href="{{ route('stories.index') }}#discover">Semua cerita</a>
                            <a href="{{ route('stories.index', ['q' => 'Romance']) }}">Romansa</a>
                            <a href="{{ route('stories.index', ['q' => 'Fantasy']) }}">Fantasi</a>
                            <a href="{{ route('stories.index', ['q' => 'Mystery']) }}">Misteri</a>
                            <a href="{{ route('stories.index', ['q' => 'Horror']) }}">Horor</a>
                        </div>
                    </div>
                    <a href="{{ route('stories.index') }}#discover">Jelajahi</a>
                    <a href="{{ route('stories.random') }}">Acak cerita</a>
                    <a href="{{ route('recommendations.index') }}">Untukmu</a>
                </nav>

                <form action="{{ route('stories.index') }}" method="GET" class="tp-search" role="search">
                    <button type="submit" class="tp-search-submit" aria-label="Cari cerita">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg>
                    </button>
                    <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari cerita..." aria-label="Cari judul, penulis, atau genre">
                </form>

                <div class="tp-nav-right">
                    <div class="tp-dropdown tp-dropdown-right">
                        <button type="button" class="tp-dropdown-toggle" aria-expanded="false" aria-haspopup="true">Menulis <span aria-hidden="true">⌄</span></button>
                        <div class="tp-dropdown-menu"><a href="{{ route('stories.create') }}">Tulis cerita baru</a>
                            <!-- TalePad Story PDF Import desktop option -->
                            <a href="{{ route('stories.import-pdf.create') }}">Impor cerita dari PDF</a>
                            @auth
                                <!-- Legacy PDF document navigation hidden; use Import story from PDF in Write menu. -->
                            @endauth</div>
                    </div>
                    @auth
                        <a class="tp-nav-text" href="{{ route('authors.show', auth()->user()) }}">Profil saya</a>
                        <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="tp-nav-text">Keluar</button></form>
                    @else
                        <a class="tp-nav-text" href="{{ route('login') }}">Masuk</a>
                        <a class="btn btn-gold" href="{{ route('register') }}">Gabung TalePad</a>
                    @endauth
                </div>

                <button class="tp-mobile-toggle" type="button" data-mobile-toggle aria-label="Buka navigasi" aria-expanded="false" aria-controls="tp-mobile-panel">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
                </button>
            </div>
        </div>
        <nav class="tp-mobile-panel" id="tp-mobile-panel" data-mobile-panel aria-label="Navigasi mobile">
            <a href="{{ route('stories.index') }}">Jelajahi cerita</a>
            <a href="{{ route('recommendations.index') }}">Rekomendasi</a>
            <a href="{{ route('stories.random') }}">Acak cerita</a>
            <a href="{{ route('stories.create') }}">Tulis cerita</a>
            <!-- TalePad Story PDF Import mobile option -->
            <a href="{{ route('stories.import-pdf.create') }}">Impor cerita dari PDF</a>
            @auth
                <!-- Legacy PDF document navigation hidden; use Import story from PDF in Write menu. -->
            @endauth
            @auth
                <a href="{{ route('authors.show', auth()->user()) }}">Profil saya</a>
                <a href="{{ route('library.index') }}">Pustaka saya</a>
                <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="tp-nav-text">Keluar</button></form>
            @else
                <a href="{{ route('login') }}">Masuk</a>
                <a href="{{ route('register') }}">Buat akun</a>
            @endauth
        </nav>
    </header>

    @include('partials.reader-nav')

    <main>
        <div class="container">
            <x-flash-message />
            @yield('content')
        </div>
    </main>

    <footer class="tp-footer">
        <div class="container tp-footer-inner">
            <div>
                <x-brand />
                <p>Temukan cerita, jelajahi dunia, dan hidupkan setiap kata.</p>
            </div>
            <p>© {{ date('Y') }} TalePad. Setiap cerita memiliki awal.</p>
        </div>
    </footer>

    <nav class="tp-bottom-nav" aria-label="Navigasi cepat">
        <a href="{{ route('stories.index') }}" @if(request()->routeIs('stories.index')) aria-current="page" @endif><span aria-hidden="true">⌂</span><span>Beranda</span></a>
        <a href="{{ route('stories.random') }}"><span aria-hidden="true">✧</span><span>Acak</span></a>
        @auth
            <a href="{{ route('library.index') }}" @if(request()->routeIs('library.*')) aria-current="page" @endif><span aria-hidden="true">▤</span><span>Pustaka</span></a>
            <a href="{{ route('authors.show', auth()->user()) }}"><span aria-hidden="true">◉</span><span>Profil</span></a>
        @else
            <a href="{{ route('login') }}"><span aria-hidden="true">↪</span><span>Masuk</span></a>
            <a href="{{ route('register') }}"><span aria-hidden="true">＋</span><span>Daftar</span></a>
        @endauth
    </nav>

    @stack('scripts')
</body>
</html>
