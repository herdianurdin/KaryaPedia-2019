@extends('layouts.app')

@section('content')
<div class="d-flex flex-wrap">
    <div class="sidebar">
        <div class="list-group shadow-sm">
            <a href="/admin" class="list-group-item list-group-item-action @if(Request::is('admin')) active font-weight-bolder @endif">Dashboard</a>
            <a href="/admin/produk" class="list-group-item list-group-item-action border-top @if(Request::is('admin/produk*')) active font-weight-bolder @endif">Produk</a>
            <a href="/admin/transaksi" class="list-group-item list-group-item-action border-top @if(Request::is('admin/transaksi*')) active font-weight-bolder @endif">Transaksi</a>
        </div>
    </div>
    <div class="content">
        @yield('admin_content')
    </div>
</div>
@endsection