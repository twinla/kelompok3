@extends('layouts.app')

@section('title', $story->title)

@section('content')
@php
    $isOwner = auth()->check() && (int) auth()->id() === (int) $story->user_id;
@endphp

<section class="reader-page">
    <a href="{{ route('stories.index') }}" class="back-link">← Back to Discover</a>

    @if(session('success'))
        <div class="tp-flash tp-flash-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="tp-flash tp-flash-error">{{ session('error') }}</div>
    @endif

    <div class="reader-header">
        <div class="reader-cover">
            @if($story->cover)
                <img src="{{ asset('storage/' . $story->cover) }}" alt="{{ $story->title }}">
            @else
                <div class="cover-placeholder reader-placeholder">
                    <span>{{ $story->genre }}</span>
                    <strong>{{ $story->title }}</strong>
                    <small>TALEPAD EDITION</small>
                </div>
            @endif
        </div>

        <div class="reader-details">
            <span class="genre">{{ $story->genre }}</span>
            <h1>{{ $story->title }}</h1>
            <p class="reader-author">
                Written by
                @if($story->user)
                    <a href="{{ route('authors.show', $story->user) }}">{{ $story->author }}</a>
                @else
                    {{ $story->author }}
                @endif
            </p>
            <div class="reader-synopsis">{{ $story->synopsis }}</div>
            <div class="reader-meta">
                <span>{{ $story->created_at->format('d M Y') }}</span>
                <span>{{ ucfirst($story->status) }}</span>
            </div>

            <div class="reader-actions">
                <a href="#read-content" class="btn btn-gold">Start Reading ↓</a>
                @if($isOwner)
                    <a href="{{ route('stories.edit', $story) }}" class="btn btn-outline">Edit Story</a>
                    <form action="{{ route('stories.destroy', $story) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this story?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    {{-- Galeri karakter bisa dilihat semua pembaca, tetapi hanya pemilik yang bisa mengelolanya. --}}
    <section class="tp-character-section" id="characters">
        <div class="eyebrow">GET TO KNOW THE CAST</div>
        <h2>Meet the Characters</h2>
        <p class="tp-character-intro">Discover the people who bring this story to life.</p>

        @if($story->characters->isNotEmpty())
            <div class="tp-character-grid">
                @foreach($story->characters as $character)
                    <article class="tp-character-card">
                        <img src="{{ asset('storage/' . $character->image) }}" alt="{{ $character->name }}">
                        <div class="tp-character-info">
                            <h3>{{ $character->name }}</h3>
                            @if($character->description)
                                <p>{{ $character->description }}</p>
                            @endif
                            @if($isOwner)
                                <form action="{{ route('stories.characters.destroy', [$story, $character]) }}" method="POST" onsubmit="return confirm('Hapus karakter ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="tp-character-delete">Remove character</button>
                                </form>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <p class="tp-no-characters">The author has not added any character profiles yet.</p>
        @endif

        @if($isOwner)
            <div class="tp-character-form-wrap">
                <h3>Add a character</h3>
                <p>Upload a portrait and add a short introduction for this character.</p>
                <form action="{{ route('stories.characters.store', $story) }}" method="POST" enctype="multipart/form-data" class="tp-character-form">
                    @csrf
                    <label for="character-name">Character name</label>
                    <input id="character-name" type="text" name="name" value="{{ old('name') }}" maxlength="100" required>
                    @error('name') <small class="error">{{ $message }}</small> @enderror

                    <label for="character-description">Description</label>
                    <textarea id="character-description" name="description" rows="3" maxlength="1000" placeholder="Describe this character...">{{ old('description') }}</textarea>
                    @error('description') <small class="error">{{ $message }}</small> @enderror

                    <label for="character-image">Character photo</label>
                    <input id="character-image" type="file" name="image" accept=".jpg,.jpeg,.png,.webp" required>
                    <small class="tp-field-hint">JPG, PNG, or WEBP. Maximum 3 MB.</small>
                    @error('image') <small class="error">{{ $message }}</small> @enderror

                    <button type="submit" class="btn btn-dark">+ Add Character</button>
                </form>
            </div>
        @endif
    </section>

    <article class="reader-content" id="read-content">
        <div class="eyebrow">THE STORY BEGINS</div>
        <h2>{{ $story->title }}</h2>
        <div class="reader-body">{{ $story->content }}</div>
    </article>
</section>
@endsection
