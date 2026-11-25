{{-- Navbar TalePad bergaya Wattpad: logo, Browse/Community, search | Write, Log in, Sign Up --}}
<header class="tp-navbar">
    <div class="tp-navbar-inner">
        <a href="{{ route('stories.index') }}" class="tp-logo" aria-label="Beranda TalePad">
            <span class="tp-logo-mark" aria-hidden="true">T</span>
        </a>

        <nav class="tp-nav-links" aria-label="Navigasi utama">
            <div class="tp-dropdown">
                <button type="button" class="tp-dropdown-toggle" aria-expanded="false" aria-haspopup="true">
                    Jelajahi
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <div class="tp-dropdown-menu">
                    <a href="{{ route('stories.index') }}#discover">Semua cerita</a>
                    <a href="{{ route('stories.index', ['q' => 'Romance']) }}">Romansa</a>
                    <a href="{{ route('stories.index', ['q' => 'Fantasy']) }}">Fantasi</a>
                    <a href="{{ route('stories.index', ['q' => 'Mystery']) }}">Misteri</a>
                    <a href="{{ route('stories.index', ['q' => 'Horror']) }}">Horor</a>
                    <a href="{{ route('stories.index', ['q' => 'Sci-Fi']) }}">Fiksi Ilmiah</a>
                </div>
            </div>

            <div class="tp-dropdown">
                <button type="button" class="tp-dropdown-toggle" aria-expanded="false" aria-haspopup="true">
                    Komunitas
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <div class="tp-dropdown-menu">
                    <a href="{{ route('stories.index') }}#discover">Jelajahi</a>
                    <a href="{{ route('stories.random') }}">Acak cerita</a>
                </div>
            </div>
        </nav>

        <form action="{{ route('stories.index') }}" method="GET" class="tp-search" role="search">
            <button type="submit" class="tp-search-submit" aria-label="Cari">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
            </button>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari cerita" aria-label="Cari judul, penulis, atau genre" autocomplete="off">
            @if(request('q'))
                <a href="{{ route('stories.index') }}" class="tp-search-clear" aria-label="Hapus pencarian">&times;</a>
            @endif
        </form>

        <div class="tp-nav-right">
            <div class="tp-dropdown tp-dropdown-right">
                <button type="button" class="tp-dropdown-toggle" aria-expanded="false" aria-haspopup="true">
                    Menulis
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <div class="tp-dropdown-menu">
                    <a href="{{ route('stories.create') }}">Tulis cerita baru</a>
                </div>
            </div>

            @auth
                <span class="tp-nav-greeting">Halo, {{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="tp-nav-text">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="tp-nav-text {{ request()->routeIs('login') ? 'is-active' : '' }}">Masuk</a>
                <a href="{{ route('register') }}" class="tp-nav-text {{ request()->routeIs('register') ? 'is-active' : '' }}">Daftar</a>
            @endauth
        </div>
    </div>
</header>

<script>
(function () {
    var dropdowns = document.querySelectorAll('.tp-dropdown');
    function closeAll(except) {
        dropdowns.forEach(function (d) {
            if (d !== except) {
                d.classList.remove('is-open');
                d.querySelector('.tp-dropdown-toggle').setAttribute('aria-expanded', 'false');
            }
        });
    }
    dropdowns.forEach(function (d) {
        var btn = d.querySelector('.tp-dropdown-toggle');
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            var open = d.classList.toggle('is-open');
            btn.setAttribute('aria-expanded', open ? 'true' : 'false');
            closeAll(d);
        });
    });
    document.addEventListener('click', function () { closeAll(null); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeAll(null); });
})();
</script>