@extends('layouts.app')

@section('content')
<div class="d-flex card w-25 mx-auto border-0 px-2 shadow-sm">
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="card-body">
            <div class="card-title h3 text-center mb-4">
                <b>{{ __('Login') }}</b>
            </div>
            <div class="form-group">
                <label for="email">{{ __('Email') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus onkeyup="return forceLower(this)">
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">{{ __('Kata Sandi') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-check form-group">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">{{ __('Ingat saya') }}</label>
            </div>
            <div class="form-group mb-2">
                <button type="submit" class="btn btn-primary form-control"><b>Login</b></button>
            </div>
            <div class="form-group text-center mb-0">
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="btn btn-link">{{ __('Lupa kata sandi?') }}</a>
                @endif
            </div>
            <div class="form-group text-center mb-0">
                <a href="{{ route('register') }}" class="btn btn-link">{{ __('Belum punya akun? Daftar') }}</a>
            </div>
        </div>
    </form>
</div>
@endsection
