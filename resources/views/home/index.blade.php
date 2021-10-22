@extends('layouts.app')

@section('content')
<div class="d-flex flex-wrap">
    <div class="sidebar">
        <div class="list-group shadow-sm">
            <div class="list-group-item active text-center h5 m-0"><b>Kategori</b></div>
            <a href="/kategori/bambu" class="list-group-item list-group-item-action border-top @if(Request::is('kategori/bambu'))active font-weight-bolder @endif">Berbahan Bambu</a>
            <a href="/kategori/kayu" class="list-group-item list-group-item-action border-top @if(Request::is('kategori/kayu'))active font-weight-bolder @endif">Berbahan Kayu</a>
            <a href="/kategori/kelapa" class="list-group-item list-group-item-action border-top @if(Request::is('kategori/kelapa'))active font-weight-bolder @endif">Berbahan Kelapa</a>
            <a href="/kategori/kerang" class="list-group-item list-group-item-action border-top @if(Request::is('kategori/kerang'))active font-weight-bolder @endif">Berbahan Kerang</a>
            <a href="/kategori/sedotan" class="list-group-item list-group-item-action border-top @if(Request::is('kategori/sedotan'))active font-weight-bolder @endif">Berbahan Sedotan</a>
        </div>
    </div>
    
    <div class="w-75">
        <form action="/cari" class="has-search mx-4 px-1" method="get">
            <span class="fa fa-search form-control-feedback"></span>
            <input class="form-control border-0 shadow-sm" type="text" name="q" placeholder="Cari Produk..." value="@if(Request::is('cari*')){{ old('q') }}@endif">
        </form>
        @if ($products->isEmpty())
        <div class="px-1 mx-4 mt-3">
            <div class="bg-white shadow-sm rounded alert alert-light p-2">
                <h5 class="text-center text-dark m-0">Maaf, produknya tidak tersedia...</h5>
            </div>
        </div>
        @endif
        <div class="product-list mt-4">
            @foreach($products as $product)
            <div class="card shadow-sm">
                <img class="card-img-top" src="{{ asset('img/'.$product->image) }}" alt="{{ $product->name }}">
                <div class="card-body">
                    <p class="mb-3">{{ $product->name }}</p>
                    <p class="h5 mb-2"><b>Rp. {{ number_format($product->price) }}</b></p>
                    <a href="/detail/{{ $product->permalink }}" class="btn btn-primary w-100 mt-1"><b><span class="fa fa-eye"></span> Detail Produk</b></a>
                </div>
            </div>
            @endforeach
        </div>
            {!! $products->links() !!}
    </div>
</div>
@endsection