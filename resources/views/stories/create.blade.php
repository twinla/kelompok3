
@extends('layouts.app')

@section('title', 'Tulis Cerita')@push('styles')
    <link rel="stylesheet" href="{{ asset('css/talepad-story-import.css') }}?v=1">
@endpush


@section('content')

<section class="form-section">

    <div class="eyebrow">BAGIKAN IMAJINASIMU</div>

    <h1>Setiap cerita hebat<br>berawal dari <em>satu kata.</em></h1>

    <p class="form-intro">
        Buat ruang karyamu sendiri di TalePad dan bagikan ceritamu kepada pembaca.
    </p>

    @include('stories._form')    <!-- TalePad PDF manuscript import option -->
    <div class="tp-story-import-inline-option">
        <span>Sudah memiliki naskah yang tersusun rapi?</span>
        <a href="{{ route('stories.import-pdf.create') }}">Impor dari PDF →</a>
    </div>


</section>

@endsection
