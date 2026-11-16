@extends('layouts.app')

@section('title', 'Create Account | TalePad')

@section('content')
<section class="tp-auth-page">
    <div class="tp-auth-card">
        <div class="eyebrow">JOIN THE READING ROOM</div>
        <h1>Create your <em>TalePad</em> account.</h1>
        <p class="tp-auth-intro">Publish your stories, introduce your characters, and discover new worlds.</p>

        <form action="{{ route('register.store') }}" method="POST" class="tp-auth-form">
            @csrf
            <label for="name">Display name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" maxlength="100" required autocomplete="name" autofocus @error('name') class="is-invalid" @enderror>
            @error('name') <small class="error">{{ $message }}</small> @enderror

            <label for="email">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" @error('email') class="is-invalid" @enderror>
            @error('email') <small class="error">{{ $message }}</small> @enderror

            <label for="password">Password</label>
            <div class="tp-password-field">
                <input id="password" type="password" name="password" required autocomplete="new-password" @error('password') class="is-invalid" @enderror>
                <button type="button" class="tp-password-toggle" data-target="password" aria-pressed="false">Show</button>
            </div>
            <small class="tp-field-hint">Use at least 8 characters.</small>
            @error('password') <small class="error">{{ $message }}</small> @enderror

            <label for="password_confirmation">Confirm password</label>
            <div class="tp-password-field">
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" @error('password_confirmation') class="is-invalid" @enderror>
                <button type="button" class="tp-password-toggle" data-target="password_confirmation" aria-pressed="false">Show</button>
            </div>

            <button type="submit" class="tp-btn-primary">Create Account</button>
        </form>

        <p class="tp-auth-switch">Already have an account? <a href="{{ route('login') }}">Log in</a></p>
    </div>
</section>

<script>
document.querySelectorAll('.tp-password-toggle').forEach(function (btn) {
    btn.addEventListener('click', function () {
        var input = document.getElementById(btn.dataset.target);
        var show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        btn.textContent = show ? 'Hide' : 'Show';
        btn.setAttribute('aria-pressed', show ? 'true' : 'false');
    });
});
</script>
@endsection
