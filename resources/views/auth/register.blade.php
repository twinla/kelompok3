@extends('layouts.app')

@section('title', 'Buat Akun | TalePad')

@section('content')
<section class="tp-auth-page">
    <div class="tp-auth-card">
        <div class="eyebrow">GABUNG DENGAN RUANG BACA</div>
        <h1>Buat akun <em>TalePad</em>-mu.</h1>
        <p class="tp-auth-intro">Terbitkan ceritamu, perkenalkan tokoh-tokohnya, dan jelajahi dunia baru.</p>

        <form action="{{ route('register.store') }}" method="POST" class="tp-auth-form">
            @csrf
            <label for="name">Nama tampilan</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" maxlength="100" required autocomplete="name" autofocus @error('name') class="is-invalid" @enderror>
            @error('name') <small class="error">{{ $message }}</small> @enderror

            <label for="email">Alamat email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" @error('email') class="is-invalid" @enderror>
            @error('email') <small class="error">{{ $message }}</small> @enderror

            <label for="password">Kata sandi</label>
            <div class="tp-password-field">
                <input id="password" type="password" name="password" required autocomplete="new-password" @error('password') class="is-invalid" @enderror>
                <button type="button" class="tp-password-toggle" data-target="password" aria-pressed="false">Tampilkan</button>
            </div>
            <small class="tp-field-hint">Gunakan minimal 8 karakter.</small>
            @error('password') <small class="error">{{ $message }}</small> @enderror

            <label for="password_confirmation">Konfirmasi kata sandi</label>
            <div class="tp-password-field">
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" @error('password_confirmation') class="is-invalid" @enderror>
                <button type="button" class="tp-password-toggle" data-target="password_confirmation" aria-pressed="false">Tampilkan</button>
            </div>

            <button type="submit" class="tp-btn-primary">Buat Akun</button>
        </form>

        <p class="tp-auth-switch">Sudah memiliki akun? <a href="{{ route('login') }}">Masuk</a></p>
    </div>
</section>

@endsection
