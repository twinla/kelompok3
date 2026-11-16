
@extends('layouts.app')

@section('title', 'Write a Story')

@section('content')

<section class="form-section">

    <div class="eyebrow">SHARE YOUR IMAGINATION</div>

    <h1>Every great story<br>starts with a <em>first word.</em></h1>

    <p class="form-intro">
        Create your own space in TalePad and share your story with readers.
    </p>

    @include('stories._form')

</section>

@endsection
