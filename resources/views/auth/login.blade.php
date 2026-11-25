@extends('layouts.app')

@section('title', 'Masuk | TalePad')

@section('content')
<section class="tp-auth-page">
    <div class="tp-auth-card">
        <div class="eyebrow">SELAMAT DATANG KEMBALI</div>

        <h1>Lanjutkan <em>ceritamu.</em></h1>

        <p class="tp-auth-intro">
            Masuk untuk menerbitkan, mengelola, dan membagikan ceritamu.
        </p>

        <form action="{{ route('login.store') }}"
              method="POST"
              class="tp-auth-form">

            @csrf

            <label for="email">Alamat email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autocomplete="email"
            >

            @error('email')
                <small class="error">{{ $message }}</small>
            @enderror

            <label for="password">Kata sandi</label>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
            >

            @error('password')
                <small class="error">{{ $message }}</small>
            @enderror

            <label class="tp-remember-label">
                <input type="checkbox" name="remember" value="1">
                Ingat saya
            </label>

            <button type="submit" class="btn btn-dark">
                Masuk
            </button>
        </form>

        <p class="tp-auth-switch">
            Baru di TalePad?
            <a href="{{ route('register') }}">Buat akun</a>
        </p>
    </div>
</section>
@endsection