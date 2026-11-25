
@extends('layouts.app')

@section('title', 'Sunting Cerita')

@section('content')

<section class="form-section">

    <div class="eyebrow">RUANG KERJA PENULIS</div>

    <h1>Sempurnakan <em>ceritamu.</em></h1>

    <p class="form-intro">
        Perbarui detail atau isi ceritamu.
    </p>

    @include('stories._form')

</section>

@endsection
