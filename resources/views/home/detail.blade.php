@extends('layouts.app')

@section('content')
<div class="d-flex flex-wrap container bg-white p-4 mb-3 rounded shadow-sm">
    <div class="w-50">
    <img class="img-fluid rounded" src="{{ asset('img/'.$product->image) }}" alt="{{ $product->name }}">
    </div>
    <div class="w-50">
        <form action="/keranjang/tambah/{{ $product->id }}" method="POST">
            @csrf
            <div class="h5 mb-3 text-center">{{ $product->name }}</div>
                <table class="table mb-4">
                    <tbody>
                        <tr class="d-flex">
                            <th class="col-4">Stok Produk</th>
                            <td class="col-1 text-center">:</td>
                            <td class="col-7">{{ $product->stock }} Unit</td>
                        </tr>
                        <tr class="d-flex">
                            <th class="col-4">Kategori</th>
                            <td class="col-1 text-center">:</td>
                            <td class="col-7">{{ $product->category }}</td>
                        </tr>
                        <tr class="d-flex">
                            <th class="col-4">Berat</th>
                            <td class="col-1 text-center">:</td>
                            <td class="col-7">{{ $product->weight }} gram</td>
                        </tr>
                        <tr class="d-flex">
                            <th class="col-4">Harga</th>
                            <td class="col-1 text-center">:</td>
                            <td class="col-7">Rp. {{ number_format($product->price) }}</td>
                        </tr>
                        <tr class="d-flex">
                            <th class="col-4">Jumlah</th>
                            <td class="col-1 text-center">:</td>
                            <td class="col-7 py-2">
                            <input class="form-control" name="total_order"
                            type="number" min="1" max="{{ $product->stock }}"
                            onkeyup="
                            if(parseInt(this.value)>{{ $product->stock }}) 
                            {
                                this.value={{ $product->stock }}; 
                                return false;
                            } else if(parseInt(this.value)<=0)
                            {
                                this.value=1;
                                return false;
                            }" value="0"></td>
                        </tr>
                    </tbody>
                </table>
                    <button class="btn btn-primary w-100
                    @if((Auth::user()) && (request()->user()->hasRole('admin')))
                        disabled
                    @endif" type="submit"><i class="fa fa-shopping-cart"></i> <b>Masukkan Keranjang</b></button>
        </form>
    </div>
</div>
@endsection