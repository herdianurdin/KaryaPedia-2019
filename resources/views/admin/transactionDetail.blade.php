@extends('layouts.app')

@section('content')
<div class="bg-white shadow-sm mx-5 p-4 mb-4">
    <table class="table">
        <thead class="text-center">
            <tr class="d-flex">
                <th class="col-1">No</th>
                <th class="col-2">Gambar</th>
                <th class="col-3">Nama Produk</th>
                <th class="col-1">Jumlah</th>
                <th class="col-2">Harga</th>
                <th class="col-3">Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orderList as $key=>$list)
            <tr class="d-flex">
                <td class="col-1 text-center">{{ $orderList->firstItem() + $key }}</td>
                <td class="col-2 text-center"><img src="{{ asset('img/'.$list->Product->image) }}" alt="{{ $list->Product->name }}" class="img-fit"></td>
                <td class="col-3">{{ $list->Product->name }}</td>
                <td class="col-1 text-center">{{ $list->total_order }}</td>
                <td class="col-2">Rp. {{ number_format($list->Product->price) }}</td>
                <td class="col-3">Rp. {{ number_format($list->total_price) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="d-flex">
                <th colspan="5" class="col-9 text-right">Total Harga :</th>
                <th class="col-3">Rp. {{ number_format($order->total_price) }}</th>
            </tr>
            <tr class="d-flex">
                <th colspan="5" class="col-9 text-right">Kode Unik :</th>
                <th class="col-3">Rp. {{ number_format($order->unique_code) }}</th>
            </tr>
            <tr class="d-flex">
                <th colspan="5" class="col-9 text-right">Biaya Ongkir :</th>
                <th class="col-3">Rp. {{ number_format($order->shipping_price) }}</th>
            </tr>
            <tr class="d-flex">
                <th colspan="5" class="col-9 text-right">Total Pembayaran :</th>
                <th class="col-3">Rp. {{ number_format($order->total_price + $order->unique_code + $order->shipping_price) }}</th>
            </tr>
        </tfoot>
    </table>
    <div class="w-100">
        {!! $orderList->links() !!}
    </div>
</div>
@endsection