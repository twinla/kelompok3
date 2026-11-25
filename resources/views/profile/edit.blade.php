@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/talepad-profile.css') }}?v=1">
@endpush

@section('title', 'Sunting Profil')

@section('content')
<section class="tp-profile-edit-page">
    <header class="tp-profile-edit-heading">
        <div class="eyebrow">PROFILMU DI TALEPAD</div>
        <h1>Sunting Profil</h1>
        <p>Ceritakan sedikit tentang dirimu agar halaman penulismu terasa lebih personal.</p>
    </header>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="story-form tp-profile-edit-form">
        @csrf
        @method('PUT')

        <div class="tp-profile-photo-field">
            <div class="tp-profile-photo-current">
                @if($user->avatar_path)
                    <img src="{{ asset('storage/' . $user->avatar_path) }}" alt="Foto profil saat ini" class="tp-profile-avatar-preview">
                @else
                    <div class="tp-profile-avatar-preview tp-profile-avatar-fallback">
                        {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                    </div>
                @endif
            </div>
            <div class="tp-profile-photo-controls">
                <label for="avatar">Foto Profil</label>
                <input id="avatar" name="avatar" type="file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" aria-describedby="avatar-help">
                <small id="avatar-help" class="tp-field-hint">JPG, PNG, atau WEBP. Ukuran file maksimal 2 MB.</small>
                @error('avatar') <span class="error">{{ $message }}</span> @enderror
                @if($user->avatar_path)
                    <label class="tp-remove-avatar-option">
                        <input type="checkbox" name="remove_avatar" value="1" @checked(old('remove_avatar'))>
                        Hapus foto profil saat ini
                    </label>
                @endif
            </div>
        </div>

        <div class="form-group">
            <label for="name">Nama Tampilan</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" maxlength="100" required autocomplete="name">
            @error('name') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="bio">Tentang Dirimu</label>
            <textarea id="bio" name="bio" rows="5" maxlength="500" placeholder="Ceritakan hal yang kamu sukai untuk ditulis...">{{ old('bio', $user->bio) }}</textarea>
            <small class="tp-field-hint">Maksimal 500 karakter. Bio ini dapat dilihat siapa pun yang mengunjungi profil publikmu.</small>
            @error('bio') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="tp-profile-edit-actions">
            <button type="submit" class="btn btn-dark">Simpan Perubahan</button>
            <a href="{{ route('authors.show', $user) }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</section>
@endsection
