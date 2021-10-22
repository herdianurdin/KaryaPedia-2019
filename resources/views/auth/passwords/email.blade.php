@extends('layouts.app')

@section('content')
<div class="d-flex card w-25 mx-auto border-0 px-2 shadow-sm">
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="card-body">
            <div class="card-title h3 text-center mb-4">
                <b>{{ __('Reset Kata Sandi') }}</b>
            </div>
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            <div class="form-group">
                <label for="email">{{ __('Email') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus onkeyup="return forceLower(this)">
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group mb-2">
                <button type="submit" class="btn btn-primary form-control"><b>{{ __('Kirim Link Reset Kata Sandi') }}</b></button>
            </div>
        </div>
    </form>
</div>
@endsection
