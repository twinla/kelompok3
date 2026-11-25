<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $story->title }} - TalePad</title>
    <style>
        @page { margin: 24mm 20mm 22mm; }
        * { box-sizing: border-box; }
        body { margin: 0; color: #29272B; font-family: DejaVu Sans, sans-serif; font-size: 10.5pt; line-height: 1.7; }
        .brand { color: #263A30; font-size: 10pt; font-weight: bold; letter-spacing: 3px; text-transform: uppercase; }
        .cover { padding: 38px 0 30px; border-bottom: 2px solid #C6A36B; }
        .genre { display: inline-block; margin-bottom: 14px; color: #783F4A; font-size: 8pt; font-weight: bold; letter-spacing: 2px; text-transform: uppercase; }
        h1 { margin: 0 0 12px; color: #263A30; font-size: 29pt; line-height: 1.2; }
        .author { margin: 0 0 20px; color: #68635D; font-size: 11pt; }
        .meta { color: #77716A; font-size: 8.5pt; }
        .synopsis { margin-top: 25px; padding: 16px 18px; background: #F3EEE3; border-left: 4px solid #C6A36B; }
        .synopsis h2 { margin: 0 0 8px; color: #263A30; font-size: 12pt; }
        .synopsis p { margin: 0; white-space: pre-wrap; }
        .chapter { margin-top: 28px; }
        .chapter + .chapter { page-break-before: always; }
        .chapter-label { color: #9B7950; font-size: 8pt; font-weight: bold; letter-spacing: 2px; text-transform: uppercase; }
        h2.chapter-title { margin: 5px 0 20px; padding-bottom: 12px; color: #263A30; border-bottom: 1px solid #DED5C7; font-size: 20pt; line-height: 1.3; }
        .chapter-content { color: #29272B; font-size: 10.5pt; line-height: 1.9; white-space: pre-wrap; overflow-wrap: break-word; }
        .empty-chapters { margin-top: 24px; color: #77716A; font-style: italic; }
        .footer { margin-top: 38px; padding-top: 10px; color: #888078; border-top: 1px solid #DED5C7; font-size: 8pt; }
    </style>
</head>
<body>
    <header class="cover">
        <div class="brand">TalePad</div>
        <div class="genre">{{ __($story->genre) }}</div>
        <h1>{{ $story->title }}</h1>
        <p class="author">Ditulis oleh {{ $authorName }}</p>
        <div class="meta">
            Cerita terbit · {{ optional($story->created_at)?->locale('id')->translatedFormat('d F Y') }}
        </div>
        @if(filled($story->synopsis))
            <section class="synopsis">
                <h2>Sinopsis</h2>
                <p>{{ $story->synopsis }}</p>
            </section>
        @endif
    </header>

    @forelse($chapters as $chapter)
        <section class="chapter">
            <div class="chapter-label">Bab {{ $chapter->chapter_number }}</div>
            <h2 class="chapter-title">{{ $chapter->title === 'Chapter ' . $chapter->chapter_number ? 'Bab ' . $chapter->chapter_number : $chapter->title }}</h2>
            <div class="chapter-content">{{ $chapter->content }}</div>
        </section>
    @empty
        <p class="empty-chapters">Cerita ini belum memiliki bab yang diterbitkan.</p>
    @endforelse

    <footer class="footer">
        Diekspor dari TalePad · {{ $exportedAt->locale('id')->translatedFormat('d F Y, H:i') }}
    </footer>
</body>
</html>
