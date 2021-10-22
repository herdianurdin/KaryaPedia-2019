@extends('layouts.app')

@section('content')
<div class="card w-50 mx-auto border-0 p-2 shadow-sm mb-3">
    <form action="/checkout/lanjut" method="POST">
        @csrf
        <div class="card-body">
            <div class="card-title h4 text-center mb-4">
                <b>{{ __('Silakan Lengkapi Form Berikut') }}</b>
            </div>
            <div class="form-group">
                <label for="name">{{ __('Nama Penerima') }}</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ Auth::user()->name }}" required autocomplete="name">

                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="address">{{ __('Alamat Pengiriman') }}</label>
                <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address" rows="3" autocomplete="address" required>{{ Auth::user()->address }}</textarea>
                @error('address')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-row">
                <div class="form-group col-6">
                    <label for="phone_number">{{ __('No. Handphone') }}</label>
                    <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ Auth::user()->phone_number }}" autocomplete="phone_number" required>
                    @error('phone_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label for="courier_name">Kurir Pengiriman</label>
                    <select class="custom-select @error('courier_name') is-invalid @enderror" id="courier_name" name="courier_name">
                        <option></option>
                        <option {{ (old('courier_name')) == 'JNE' ? 'selected' : '' }} value="JNE">JNE</option>
                        <option {{ (old('courier_name')) == 'J&T' ? 'selected' : '' }} value="J&T">J&T</option>
                    </select>
                    @error('courier_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ 'Kurir pengiriman wajib diisi!' }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group mb-2">
                <button type="submit" class="btn btn-primary form-control"><b><span class="fa fa-arrow-right"></span> {{ __('Lanjut Checkout') }}</b></button>
            </div>
        </div>
    </form>
</div>
@endsection