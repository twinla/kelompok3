@extends('layouts.app')

@section('title', $pdfDocument->original_name)

@section('content')
<section class="tp-pdf-view-page">
    <div class="tp-pdf-view-header">
        <div>
            <a class="tp-pdf-back-link" href="{{ route('pdf-library.index') }}">← Kembali ke Dokumen PDF Saya</a>
            <h1>{{ $pdfDocument->original_name }}</h1>
        </div>
        <a class="tp-pdf-primary-button" href="{{ route('pdf-library.download', $pdfDocument) }}">Unduh PDF</a>
    </div>

    <iframe
        class="tp-pdf-viewer"
        src="{{ route('pdf-library.preview', $pdfDocument) }}"
        title="Pratinjau PDF: {{ $pdfDocument->original_name }}"
    ></iframe>
</section>
@endsection
