@extends('layouts.app')

@section('title', 'Dokumen PDF Saya')

@section('content')
<section class="tp-pdf-page">
    <div class="tp-pdf-heading">
        <div>
            <span class="tp-pdf-eyebrow">RUANG DOKUMEN PRIBADIMU</span>
            <h1>Dokumen PDF Saya</h1>
            <p>Impor, pratinjau, unduh, dan kelola file PDF milikmu.</p>
        </div>
        <span class="tp-pdf-count">{{ $documents->total() }} dokumen</span>
    </div>

    <section class="tp-pdf-upload-card" aria-labelledby="tp-pdf-upload-title">
        <div class="tp-pdf-upload-icon" aria-hidden="true">＋</div>
        <div class="tp-pdf-upload-copy">
            <h2 id="tp-pdf-upload-title">Impor PDF</h2>
            <p>Pilih dokumen PDF dari perangkatmu. Ukuran file maksimal 20 MB.</p>
        </div>
        <form action="{{ route('pdf-library.store') }}" method="POST" enctype="multipart/form-data" class="tp-pdf-upload-form">
            @csrf
            <label class="tp-pdf-file-label" for="pdf-file">Pilih PDF</label>
            <input id="pdf-file" type="file" name="pdf" accept=".pdf,application/pdf" required>
            <button type="submit" class="tp-pdf-primary-button">Unggah PDF</button>
            @error('pdf')
                <small class="tp-pdf-error">{{ $message }}</small>
            @enderror
        </form>
        <p class="tp-pdf-upload-note">Format yang diterima: .pdf · Maksimal: 20 MB · File hanya dapat diakses oleh akunmu.</p>
    </section>

    <div class="tp-pdf-list-heading">
        <div>
            <span class="tp-pdf-eyebrow">KOLEKSI DOKUMENMU</span>
            <h2>Dokumen yang Diimpor</h2>
        </div>
    </div>

    @if($documents->isNotEmpty())
        <div class="tp-pdf-document-list">
            @foreach($documents as $document)
                <article class="tp-pdf-document-card">
                    <div class="tp-pdf-file-icon" aria-hidden="true">PDF</div>
                    <div class="tp-pdf-document-info">
                        <h3 title="{{ $document->original_name }}">{{ $document->original_name }}</h3>
                        <p>
                            {{ number_format($document->size_bytes / 1048576, 2) }} MB
                            <span aria-hidden="true">·</span>
                            Diunggah {{ $document->uploaded_at->locale('id')->translatedFormat('d M Y, H:i') }}
                        </p>
                    </div>
                    <div class="tp-pdf-document-actions">
                        <a href="{{ route('pdf-library.show', $document) }}" class="tp-pdf-secondary-button">Lihat</a>
                        <a href="{{ route('pdf-library.download', $document) }}" class="tp-pdf-secondary-button">Unduh</a>
                        <form action="{{ route('pdf-library.destroy', $document) }}" method="POST" onsubmit="return confirm('Hapus dokumen PDF ini? Tindakan ini tidak dapat dibatalkan.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="tp-pdf-delete-button">Hapus</button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>
        <div class="tp-pdf-pagination">@include('partials.pagination', ['paginator' => $documents])</div>
    @else
        <div class="tp-pdf-empty-state">
            <div aria-hidden="true">▤</div>
            <h3>Belum ada dokumen PDF</h3>
            <p>File PDF yang kamu impor akan muncul di sini. Hanya kamu yang dapat melihat dan mengelolanya.</p>
        </div>
    @endif
</section>
@endsection
