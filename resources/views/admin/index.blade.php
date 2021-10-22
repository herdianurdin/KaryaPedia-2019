@extends('layouts.admin')

@section('admin_content')
    <div class="shadow-sm bg-white rounded p-3 d-flex mb-3">
        <div class="row mx-auto pb-3">
            <div class="col-12 text-center mt-2 mb-4">
                <h3><b>Dashboard</b></h3>
            </div>
            <div class="col-3 text-center">
                <h2 class="mb-0"><b>{{ $orderCount }}</b></h2>
                <h5 class="text-muted mb-0">Pesanan Masuk</h5>
            </div>
            <div class="col-3 text-center">
                <h2 class="mb-0"><b>{{ $userCount }}</b></h2>
                <h5 class="text-muted mb-0">Pengguna</h5>
            </div>
            <div class="col-3 text-center">
                <h2 class="mb-0"><b>{{ $productCount }}</b></h2>
                <h5 class="text-muted mb-0">Jumlah Produk</h5>
            </div>
            <div class="col-3 text-center">
                <h2 class="mb-0"><b>{{ $productOutStock }}</b></h2>
                <h5 class="text-muted mb-0">Produk Habis Stok</h5>
            </div>
        </div>
    </div>
@endsection