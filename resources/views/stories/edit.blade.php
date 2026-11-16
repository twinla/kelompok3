
@extends('layouts.app')

@section('title', 'Edit Story')

@section('content')

<section class="form-section">

    <div class="eyebrow">AUTHOR STUDIO</div>

    <h1>Refine your <em>story.</em></h1>

    <p class="form-intro">
        Update the details or content of your novel.
    </p>

    @include('stories._form')

</section>

@endsection
