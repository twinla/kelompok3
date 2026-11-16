
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'TalePad') — TalePad</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- CSS TalePad -->
    <link rel="stylesheet" href="{{ asset('css/talepad.css') }}">
    <link rel="stylesheet" href="{{ asset('css/talepad-enhancements.css') }}">
    <link rel="stylesheet" href="{{ asset('css/talepad-reader-features.css') }}">

    @stack('styles')
</head>

<body>

    <!-- Navbar Utama -->
    <header class="navbar">
        <div class="container navbar-inner">

            <a href="{{ route('stories.index') }}" class="logo">
                Tale<span>Pad.</span>
            </a>

            <nav class="nav-links">
                <a href="{{ route('stories.index') }}">Home</a>
                <a href="{{ route('stories.index') }}#discover">Discover</a>
                <a href="{{ route('stories.create') }}">Write a Story</a>
            </nav>

            <a href="{{ route('stories.random') }}" class="btn btn-dark">
                <span>↗</span> Randomize
            </a>

        </div>
    </header>

    <!-- Navigasi Akun -->
    @include('partials.auth-nav')

    <!-- Navigasi Reader Features -->
    @include('partials.reader-nav')

    <!-- Main Content -->
    <main>
        <div class="container">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')

        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container footer-inner">

            <div>
                <a href="{{ route('stories.index') }}" class="logo">
                    Tale<span>Pad.</span>
                </a>

                <p>Discover stories. Explore worlds.</p>
            </div>

            <p>© {{ date('Y') }} TalePad. All stories begin somewhere.</p>

        </div>
    </footer>

    @stack('scripts')

</body>
</html>
