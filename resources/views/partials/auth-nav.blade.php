{{-- Account toolbar global: letakkan di bawah navbar utama pada layouts/app.blade.php. --}}
<div class="tp-account-bar">
    <div class="tp-auth-nav">
        @auth
            <a href="{{ route('authors.show', auth()->user()) }}" class="tp-nav-profile">My Profile</a>
            <span class="tp-nav-greeting">Hi, {{ auth()->user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="tp-nav-logout">Log Out</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="tp-nav-login">Log In</a>
            <a href="{{ route('register') }}" class="tp-nav-signup">Sign Up</a>
        @endauth
    </div>
</div>
