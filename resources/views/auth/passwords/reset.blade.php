@extends('layouts.app')

@section('content')
<div class="d-flex card w-50 mx-auto border-0 px-2 shadow-sm">
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <div class="card-body">
            <div class="card-title h3 text-center mb-4">
                <b>{{ __('Reset Password') }}</b>
            </div>
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group">
                <label for="email">{{ __('Email') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
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
                <button type="submit" class="btn btn-primary form-control"><b>{{ __('Reset Kata Sandi') }}</b></button>
            </div>
        </div>
    </form>
</div>
@endsection
