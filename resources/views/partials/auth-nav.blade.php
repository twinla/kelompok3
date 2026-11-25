{{-- Account toolbar global: letakkan di bawah navbar utama pada layouts/app.blade.php. --}}
<div class="tp-account-bar">
    <div class="tp-auth-nav">
        @auth
            <a href="{{ route('authors.show', auth()->user()) }}" class="tp-nav-profile">Profil Saya</a>
            <span class="tp-nav-greeting">Halo, {{ auth()->user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="tp-nav-logout">Keluar</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="tp-nav-login">Masuk</a>
            <a href="{{ route('register') }}" class="tp-nav-signup">Daftar</a>
        @endauth
    </div>
</div>
