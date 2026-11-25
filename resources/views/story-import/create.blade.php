@extends('layouts.app')

@section('title', 'Impor Cerita dari PDF')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/talepad-story-import.css') }}?v=1">
@endpush

@section('content')
<section class="tp-story-import-page">
    <a class="tp-story-import-back" href="{{ route('stories.create') }}">← Kembali ke Tulis Cerita</a>

    <header class="tp-story-import-heading">
        <span class="eyebrow">CARA LAIN UNTUK MENULIS</span>
        <h1>Impor cerita<br>dari <em>PDF.</em></h1>
        <p>Sudah menyiapkan naskah? Unggah PDF dengan format khusus TalePad. Sistem akan mengubah informasi cerita dan seluruh bab menjadi cerita TalePad yang bisa disunting.</p>
    </header>

    <div class="tp-story-import-grid">
        <section class="tp-story-import-card">
            <div class="tp-story-import-card-heading">
                <span class="tp-story-import-icon" aria-hidden="true">↥</span>
                <div>
                    <h2>Unggah Naskah</h2>
                    <p>Satu file PDF akan menjadi satu cerita beserta seluruh bab di dalamnya.</p>
                </div>
            </div>

            <form action="{{ route('stories.import-pdf.store') }}" method="POST" enctype="multipart/form-data" class="tp-story-import-form">
                @csrf

                <label for="story-pdf">File PDF Cerita</label>
                <input id="story-pdf" type="file" name="pdf" accept=".pdf,application/pdf" required>
                @error('pdf') <small class="tp-story-import-error">{{ $message }}</small> @enderror
                <small class="tp-story-import-help">Hanya PDF · Maksimal 20 MB · Harus berupa PDF berbasis teks (PDF hasil pindai/foto tidak didukung)</small>

                <label for="story-status">Setelah Diimpor</label>
                <select id="story-status" name="status" required>
                    <option value="draft" @selected(old('status', 'draft') === 'draft')>Simpan sebagai Draf (disarankan)</option>
                    <option value="published" @selected(old('status') === 'published')>Terbitkan sekarang</option>
                </select>
                @error('status') <small class="tp-story-import-error">{{ $message }}</small> @enderror

                <button type="submit" class="tp-story-import-submit">Impor Cerita &amp; Bab</button>
            </form>

            <p class="tp-story-import-privacy">PDF yang kamu unggah akan diproses menjadi data cerita dan bab. File asli tidak disimpan sebagai dokumen terpisah.</p>
        </section>

        <aside class="tp-story-import-guide">
            <div class="tp-story-import-guide-top">
                <span class="eyebrow">FORMAT WAJIB</span>
                <h2>Gunakan templat TalePad.</h2>
                <p>PDF dengan struktur berbeda akan ditolak agar isi bab tidak salah dimasukkan ke kolom yang keliru.</p>
                <a class="tp-story-import-template" href="{{ route('stories.import-pdf.template') }}">Unduh Templat Teks <span aria-hidden="true">↓</span></a>
                <p class="tp-story-import-template-note">Sunting file TXT menggunakan Word/Google Docs, lalu simpan atau ekspor sebagai PDF sebelum diunggah.</p>
            </div>

            <div class="tp-story-import-spec">
                <h3>Informasi Cerita</h3>
                <ul>
                    <li><strong>Judul:</strong> maksimal 150 karakter</li>
                    <li><strong>Penulis:</strong> maksimal 100 karakter</li>
                    <li><strong>Genre:</strong> maksimal 80 karakter</li>
                    <li><strong>Sinopsis:</strong> maksimal 2.000 karakter</li>
                </ul>
                <h3>Bab</h3>
                <ul>
                    <li>Minimal satu bab dan maksimal 100 bab.</li>
                    <li>Nomor bab harus berurutan mulai dari 1.</li>
                    <li>Judul bab: maksimal 160 karakter.</li>
                    <li>Isi bab: minimal 20 karakter.</li>
                </ul>
            </div>

            <details class="tp-story-import-example">
                <summary>Lihat struktur PDF yang diwajibkan</summary>
                <pre>TALEPAD_STORY_IMPORT_V1

TITLE: Judul cerita kamu
AUTHOR: Nama penamu
GENRE: Fantasi

SYNOPSIS_START
Tulis sinopsis di sini.
SYNOPSIS_END

CHAPTER_START: 1
CHAPTER_TITLE: Awal Cerita
CHAPTER_CONTENT_START
Tulis isi lengkap bab di sini.
CHAPTER_CONTENT_END
CHAPTER_END

TALEPAD_STORY_END</pre>
                <p>Pertahankan semua penanda persis seperti tertulis. Ganti hanya teks contoh. Tambahkan satu blok CHAPTER_START lengkap untuk setiap bab berikutnya.</p>
            </details>
        </aside>
    </div>

    <div class="tp-story-import-manual-option">
        <span>Lebih suka menulis langsung di TalePad?</span>
        <a href="{{ route('stories.create') }}">Buka editor cerita →</a>
    </div>
</section>
@endsection
