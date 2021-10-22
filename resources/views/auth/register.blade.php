@extends('layouts.app')

@section('content')
<div class="card w-50 mx-auto border-0 px-2 shadow-sm">
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="card-body">
            <div class="card-title h3 text-center mb-4">
                <b>{{ __('Daftar Akun') }}</b>
            </div>
            <div class="form-group">
                <label for="name">{{ __('Nama Lengkap') }}</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">{{ __('Email') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" onkeyup="return forceLower(this)">

                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-row">
                <div class="form-group col-6">
                    <label for="password">{{ __('Kata Sandi') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label for="password-confirm">{{ __('Konfirmasi Kata Sandi') }}</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>
            </div>
            <div class="form-group mb-2">
                <button type="submit" class="btn btn-primary form-control"><b>{{ __('Daftar') }}</b></button>
            </div>
            <div class="form-group mb-0 text-center">
                <a href="{{ route('login') }}" class="btn btn-link">{{ __('Sudah punya akun? Login') }}</a>
            </div>
        </div>
    </form>
</div>
@endsection
