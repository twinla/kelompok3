@extends('layouts.app')

@section('title', $story->title)

@section('content')
<section class="reader-page tp-feature-page">
    <a href="{{ route('stories.index') }}" class="back-link">← Kembali ke Jelajahi Cerita</a>
    <div class="reader-header">
        <div class="reader-cover">
            @if($story->cover) <img src="{{ asset('storage/' . $story->cover) }}" alt="{{ $story->title }}">
            @else <div class="cover-placeholder reader-placeholder"><span>{{ __($story->genre) }}</span><strong>{{ $story->title }}</strong><small>EDISI TALEPAD</small></div> @endif
        </div>
        <div class="reader-details">
            <span class="genre">{{ __($story->genre) }}</span>
            <h1>{{ $story->title }}</h1>
            <p class="reader-author">Ditulis oleh
                @if($story->user)<a href="{{ route('authors.show', $story->user) }}">{{ $story->author }}</a>@else{{ $story->author }}@endif
            </p>
            <div class="reader-synopsis">{{ $story->synopsis }}</div>
            <div class="reader-meta"><span>{{ $story->created_at->locale('id')->translatedFormat('d M Y') }}</span><span>{{ $chapters->count() }} bab</span><span>★ {{ $averageRating ? number_format($averageRating, 1) : 'Belum dinilai' }} ({{ $ratingCount }})</span></div>
            <div class="reader-actions">
                @if($story->status === 'published')
                    <!-- TalePad public PDF export actions -->
                    <a href="{{ route('stories.pdf.view', $story) }}" class="btn btn-outline" target="_blank" rel="noopener">Lihat sebagai PDF</a>
                    <a href="{{ route('stories.pdf.download', $story) }}" class="btn btn-dark">Unduh PDF</a>
                @endif
                @if($chapters->isNotEmpty()) <a href="{{ route('chapters.read', [$story, $chapters->first()]) }}" class="btn btn-gold">Mulai Membaca ↓</a>
                @elseif($isOwner) <a href="{{ route('chapters.create', $story) }}" class="btn btn-gold">+ Tambah Bab Pertama</a> @endif
                @if($isOwner)
                    <a href="{{ route('stories.edit', $story) }}" class="btn btn-outline">Sunting Cerita</a>
                    <form action="{{ route('stories.destroy', $story) }}" method="POST" onsubmit="return confirm('Hapus cerita ini beserta seluruh babnya?')">@csrf @method('DELETE')<button type="submit" class="btn btn-danger">Hapus</button></form>
                @endif
            </div>
            @if($story->user && auth()->check() && !$isOwner)
                <form action="{{ route('authors.follow', $story->user) }}" method="POST" class="tp-inline-form">@csrf
                    <button class="btn btn-outline" type="submit">{{ $isFollowingAuthor ? 'Mengikuti penulis ✓' : '+ Ikuti penulis' }}</button>
                </form>
            @endif
        </div>
    </div>

    <section class="tp-social-bar">
        <div class="tp-social-actions">
            @auth
                <form action="{{ route('stories.like', $story) }}" method="POST">@csrf<button class="tp-action-button {{ $isLiked ? 'is-active' : '' }}" type="submit">♥ {{ $isLiked ? 'Disukai' : 'Sukai' }} · {{ $likeCount }}</button></form>
                <form action="{{ route('library.store', $story) }}" method="POST">@csrf
                    <select name="shelf" aria-label="Pilih rak pustaka"><option value="saved" @selected($libraryEntry?->shelf === 'saved')>Buku Tersimpan</option><option value="want_to_read" @selected($libraryEntry?->shelf === 'want_to_read')>Ingin Dibaca</option></select>
                    <button class="tp-action-button" type="submit">＋ {{ $libraryEntry ? 'Perbarui Pustaka' : 'Tambahkan ke Pustaka' }}</button>
                </form>
            @else
                <a class="tp-action-button" href="{{ route('login') }}">Masuk untuk Menyukai</a><a class="tp-action-button" href="{{ route('login') }}">Masuk untuk Menyimpan</a>
            @endauth
        </div>
        <div class="tp-rating-box">
            <strong>Beri Penilaian</strong>
            @auth
                <form action="{{ route('stories.rating', $story) }}" method="POST" class="tp-rating-form">@csrf
                    <select name="rating" required aria-label="Penilaian dari 1 sampai 5"><option value="">Pilih penilaian</option>@for($star = 5; $star >= 1; $star--)<option value="{{ $star }}" @selected((int) $userRating === $star)>{{ $star }} / 5 bintang</option>@endfor</select>
                    <button type="submit" class="btn btn-dark">Kirim</button>
                </form>
            @else <a href="{{ route('login') }}">Masuk untuk memberi penilaian</a> @endauth
        </div>
    </section>

    <section class="tp-chapter-section" id="chapters">
        <div class="tp-section-title-row"><div><div class="eyebrow">LANJUTKAN PERJALANAN</div><h2>Bab</h2><p>{{ $chapters->count() }} bab tersedia</p></div>
            @if($isOwner)<a href="{{ route('chapters.create', $story) }}" class="btn btn-dark">+ Tambah Bab</a>@endif
        </div>
        @if($chapters->isNotEmpty())
            <div class="tp-chapter-tools"><input type="search" id="chapter-search" placeholder="Cari bab berdasarkan nomor atau judul..."><select id="chapter-jump" aria-label="Pilih bab"><option value="">Pilih bab...</option>@foreach($chapters as $chapter)<option value="{{ route('chapters.read', [$story, $chapter]) }}">Bab {{ $chapter->chapter_number }} — {{ $chapter->title === 'Chapter ' . $chapter->chapter_number ? 'Bab ' . $chapter->chapter_number : $chapter->title }}</option>@endforeach</select></div>
            <div class="tp-chapter-list" id="chapter-list">
                @foreach($chapters as $chapter)
                    <article class="tp-chapter-row" data-chapter-search="{{ strtolower('bab ' . $chapter->chapter_number . ' ' . $chapter->title) }}">
                        <a href="{{ route('chapters.read', [$story, $chapter]) }}"><span class="tp-chapter-number">{{ str_pad($chapter->chapter_number, 2, '0', STR_PAD_LEFT) }}</span><span><strong>{{ $chapter->title === 'Chapter ' . $chapter->chapter_number ? 'Bab ' . $chapter->chapter_number : $chapter->title }}</strong><small>{{ $chapter->status === 'draft' ? 'Draf' : 'Terbit' }}</small></span></a>
                        @if($isOwner)<div class="tp-chapter-owner-actions"><a href="{{ route('chapters.edit', [$story, $chapter]) }}">Sunting</a><form action="{{ route('chapters.destroy', [$story, $chapter]) }}" method="POST" onsubmit="return confirm('Hapus bab ini?')">@csrf @method('DELETE')<button type="submit">Hapus</button></form></div>@endif
                    </article>
                @endforeach
            </div>
        @else
            <div class="tp-empty-note">Belum ada bab yang diterbitkan.</div>
        @endif
    </section>

    {{-- Galeri karakter yang sudah ada tetap dipertahankan. --}}
    <section class="tp-character-section" id="characters">
        <div class="eyebrow">KENALI PARA TOKOH</div><h2>Kenali Tokoh Cerita</h2><p class="tp-character-intro">Kenali tokoh-tokoh yang menghidupkan cerita ini.</p>
        @if($story->characters->isNotEmpty())
            <div class="tp-character-grid">
                @foreach($story->characters as $character)
                    <article class="tp-character-card"><img src="{{ asset('storage/' . $character->image) }}" alt="{{ $character->name }}"><div class="tp-character-info"><h3>{{ $character->name }}</h3>@if($character->description)<p>{{ $character->description }}</p>@endif
                        @if($isOwner)<form action="{{ route('stories.characters.destroy', [$story, $character]) }}" method="POST" onsubmit="return confirm('Hapus tokoh ini?')">@csrf @method('DELETE')<button type="submit" class="tp-character-delete">Hapus tokoh</button></form>@endif
                    </div></article>
                @endforeach
            </div>
        @else <p class="tp-no-characters">Penulis belum menambahkan profil tokoh.</p> @endif
        @if($isOwner)
            <div class="tp-character-form-wrap"><h3>Tambah Tokoh</h3><form action="{{ route('stories.characters.store', $story) }}" method="POST" enctype="multipart/form-data" class="tp-character-form">@csrf
                <label>Nama Tokoh</label><input type="text" name="name" maxlength="100" required>
                <label>Deskripsi</label><textarea name="description" rows="3" maxlength="1000"></textarea>
                <label>Foto Tokoh</label><input type="file" name="image" accept=".jpg,.jpeg,.png,.webp" required>
                <button type="submit" class="btn btn-dark">+ Tambah Tokoh</button>
            </form></div>
        @endif
    </section>

    <section class="tp-comments-section" id="comments">
        <div class="eyebrow">RUANG PEMBACA</div><h2>Komentar</h2>
        @auth
            <form action="{{ route('stories.comments.store', $story) }}" method="POST" class="tp-comment-form">@csrf
                <textarea name="content" rows="3" maxlength="2000" required placeholder="Bagikan pendapatmu tentang cerita ini..."></textarea>
                @error('content')<small class="error">{{ $message }}</small>@enderror
                <button type="submit" class="btn btn-dark">Kirim Komentar</button>
            </form>
        @else <p><a href="{{ route('login') }}">Masuk</a> untuk ikut berdiskusi.</p> @endauth
        <div class="tp-comment-list">
            @forelse($comments as $comment)
                <article class="tp-comment-card"><div class="tp-comment-meta"><strong>{{ $comment->user->name }}</strong><span>{{ $comment->created_at->locale('id')->diffForHumans() }}</span></div><p>{{ $comment->content }}</p>
                    @auth @if((int) auth()->id() === (int) $comment->user_id || $isOwner)
                        <form action="{{ route('stories.comments.destroy', [$story, $comment]) }}" method="POST" onsubmit="return confirm('Hapus komentar ini?')">@csrf @method('DELETE')<button class="tp-comment-delete" type="submit">Hapus</button></form>
                    @endif @endauth
                </article>
            @empty <p class="tp-empty-note">Belum ada komentar. Jadilah yang pertama menyampaikan pendapat.</p> @endforelse
        </div>
        @include('partials.pagination', ['paginator' => $comments])
    </section>
</section>

@endsection
