@extends('layouts.app')

@section('title', 'Log In | TalePad')

@section('content')
<section class="tp-auth-page">
    <div class="tp-auth-card">
        <div class="eyebrow">WELCOME BACK</div>

        <h1>Continue your <em>story.</em></h1>

        <p class="tp-auth-intro">
            Log in to publish, manage, and share your novels.
        </p>

        <form action="{{ route('login.store') }}"
              method="POST"
              class="tp-auth-form">

            @csrf

            <label for="email">Email address</label>
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

            <label for="password">Password</label>
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
                Remember me
            </label>

            <button type="submit" class="btn btn-dark">
                Log In
            </button>
        </form>

        <p class="tp-auth-switch">
            New to TalePad?
            <a href="{{ route('register') }}">Create an account</a>
        </p>
    </div>
</section>
@endsection