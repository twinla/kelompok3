<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#263A30">
    <meta name="description" content="TalePad — discover stories, explore worlds, and share your own writing.">
    <title>@yield('title', 'Discover Stories') — TalePad</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <header class="tp-site-header">
        <div class="tp-navbar">
            <div class="tp-navbar-inner">
                <x-brand />

                <nav class="tp-nav-links" aria-label="Navigasi utama">
                    <div class="tp-dropdown">
                        <button type="button" class="tp-dropdown-toggle" aria-expanded="false" aria-haspopup="true">
                            Browse <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                        </button>
                        <div class="tp-dropdown-menu">
                            <a href="{{ route('stories.index') }}#discover">All stories</a>
                            <a href="{{ route('stories.index', ['q' => 'Romance']) }}">Romance</a>
                            <a href="{{ route('stories.index', ['q' => 'Fantasy']) }}">Fantasy</a>
                            <a href="{{ route('stories.index', ['q' => 'Mystery']) }}">Mystery</a>
                            <a href="{{ route('stories.index', ['q' => 'Horror']) }}">Horror</a>
                        </div>
                    </div>
                    <a href="{{ route('stories.index') }}#discover">Discover</a>
                    <a href="{{ route('stories.random') }}">Randomize</a>
                    <a href="{{ route('recommendations.index') }}">For You</a>
                </nav>

                <form action="{{ route('stories.index') }}" method="GET" class="tp-search" role="search">
                    <button type="submit" class="tp-search-submit" aria-label="Cari cerita">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg>
                    </button>
                    <input type="search" name="q" value="{{ request('q') }}" placeholder="Find a story..." aria-label="Cari judul, penulis, atau genre">
                </form>

                <div class="tp-nav-right">
                    <div class="tp-dropdown tp-dropdown-right">
                        <button type="button" class="tp-dropdown-toggle" aria-expanded="false" aria-haspopup="true">Write <span aria-hidden="true">⌄</span></button>
                        <div class="tp-dropdown-menu"><a href="{{ route('stories.create') }}">Create a new story</a></div>
                    </div>
                    @auth
                        <a class="tp-nav-text" href="{{ route('authors.show', auth()->user()) }}">My profile</a>
                        <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="tp-nav-text">Log out</button></form>
                    @else
                        <a class="tp-nav-text" href="{{ route('login') }}">Log in</a>
                        <a class="btn btn-gold" href="{{ route('register') }}">Join TalePad</a>
                    @endauth
                </div>

                <button class="tp-mobile-toggle" type="button" data-mobile-toggle aria-label="Buka navigasi" aria-expanded="false" aria-controls="tp-mobile-panel">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
                </button>
            </div>
        </div>
        <nav class="tp-mobile-panel" id="tp-mobile-panel" data-mobile-panel aria-label="Navigasi mobile">
            <a href="{{ route('stories.index') }}">Discover stories</a>
            <a href="{{ route('recommendations.index') }}">Recommendations</a>
            <a href="{{ route('stories.random') }}">Surprise me</a>
            <a href="{{ route('stories.create') }}">Write a story</a>
            @auth
                <a href="{{ route('authors.show', auth()->user()) }}">My profile</a>
                <a href="{{ route('library.index') }}">My library</a>
                <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="tp-nav-text">Log out</button></form>
            @else
                <a href="{{ route('login') }}">Log in</a>
                <a href="{{ route('register') }}">Create account</a>
            @endauth
        </nav>
    </header>

    @include('partials.reader-nav')

    <main>
        <div class="container">
            @if(!request()->routeIs('stories.index'))
                <x-flash-message />
            @endif
            @yield('content')
        </div>
    </main>

    <footer class="tp-footer">
        <div class="container tp-footer-inner">
            <div>
                <x-brand />
                <p>Discover stories. Explore worlds. Make words matter.</p>
            </div>
            <p>© {{ date('Y') }} TalePad. All stories begin somewhere.</p>
        </div>
    </footer>

    <nav class="tp-bottom-nav" aria-label="Navigasi cepat">
        <a href="{{ route('stories.index') }}" @if(request()->routeIs('stories.index')) aria-current="page" @endif><span aria-hidden="true">⌂</span><span>Home</span></a>
        <a href="{{ route('stories.random') }}"><span aria-hidden="true">✧</span><span>Random</span></a>
        @auth
            <a href="{{ route('library.index') }}" @if(request()->routeIs('library.*')) aria-current="page" @endif><span aria-hidden="true">▤</span><span>Library</span></a>
            <a href="{{ route('authors.show', auth()->user()) }}"><span aria-hidden="true">◉</span><span>Profile</span></a>
        @else
            <a href="{{ route('login') }}"><span aria-hidden="true">↪</span><span>Log in</span></a>
            <a href="{{ route('register') }}"><span aria-hidden="true">＋</span><span>Join</span></a>
        @endauth
    </nav>

    @stack('scripts')
</body>
</html>
