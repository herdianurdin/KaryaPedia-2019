@extends('layouts.app')

@section('content')
<div class="card w-50 mx-auto border-0 px-2 shadow-sm mb-3">
    <form method="POST" action="/akun/perbarui">
        @csrf
        <div class="card-body">
            <div class="card-title h3 text-center mb-4">
                <b>{{ __('Akun') }}</b>
            </div>
            <div class="form-group">
                <label for="name">{{ __('Nama Lengkap') }}</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ Auth::user()->name }}" required autocomplete="name">

                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">{{ __('Email') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ Auth::user()->email }}" required autocomplete="email" onkeyup="return forceLower(this)">

                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="address">{{ __('Alamat Lengkap') }}</label>
                <textarea class="form-control" name="address" id="address" rows="3" autocomplete="address">{{ Auth::user()->address }}</textarea>
            </div>
            <div class="form-group">
                <label for="phone_number">{{ __('No. Handphone') }}</label>
                <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ Auth::user()->phone_number }}" autocomplete="phone_number">
            </div>
            <div class="form-row">
                <div class="form-group col-6">
                    <label for="password">{{ __('Kata Sandi') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                    
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label for="password-confirm">{{ __('Konfirmasi Kata Sandi') }}</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                </div>
            </div>
            <div class="form-group mb-2">
                <button type="submit" class="btn btn-primary form-control"><b>{{ __('Perbarui Akun') }}</b></button>
            </div>
        </div>
    </form>
</div>
@endsection