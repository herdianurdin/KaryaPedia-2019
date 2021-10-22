@extends('layouts.app')

@section('content')
<div class="bg-white shadow-sm mx-5 p-4 mb-4">
    @if(empty($order))
        <h5 class="mb-0 text-center">Keranjangmu Masih Kosong, Yuk Belanja Dulu...</h5>
    @else
    @if(Session::has('message'))
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">×</button> 
        {{ Session::get('message') }}
    </div>
    @endif
    @if(Session::has('msgError'))
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button> 
        {{ Session::get('msgError') }}
    </div>
    @endif
    @if(Session::has('msgInfo'))
    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert">×</button> 
        {{ Session::get('msgInfo') }}
    </div>
    @endif
    @foreach($orderList as $list)
    <div class="modal fade" id="{{ 'hapus'.$list->id }}" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hapus Pesanan</h5>
                        <button type="button" class="close p-0 m-0" data-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">
                        Anda ingin menghapus pesanan ini?
                    </div>
                    <div class="modal-footer p-2">
                        <a href="#" class="btn btn-secondary" data-dismiss="modal"><b>Tidak</b></a>
                        <a href="/keranjang/hapus/{{ $list->id }}" class="btn btn-primary"><b>Ya</b></a>
                    </div>
                </div>
            </div>
    </div>
    @endforeach
    <table class="table">
        <thead class="text-center">
            <tr class="d-flex">
                <th class="col-1">No</th>
                <th class="col-2">Gambar</th>
                <th class="col-3">Nama Produk</th>
                <th class="col-1">Jumlah</th>
                <th class="col-2">Harga</th>
                <th class="col-2">Total Harga</th>
                <th class="col-1"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($orderList as $key=>$list)
            <tr class="d-flex">
                <td class="col-1 text-center">{{ $orderList->firstItem() + $key }}</td>
                <td class="col-2 text-center"><img src="{{ asset('img/'.$list->Product->image) }}" alt="$list->Product->name" class="img-fit"></td>
                <td class="col-3">{{ $list->Product->name }}</td>
                <td class="col-1 text-center">{{ $list->total_order }}</td>
                <td class="col-2">Rp. {{ number_format($list->Product->price) }}</td>
                <td class="col-2">Rp. {{ number_format($list->total_price) }}</td>
                <td class="col-1 text-center"><a data-toggle="modal" data-target="{{ '#hapus'.$list->id }}" href="#" class="fa fa-trash text-danger"></a></td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="d-flex">
                <th colspan="5" class="col-9 text-right">Total Harga :</th>
                <th class="col-2">Rp. {{ number_format($order->total_price) }}</th>
                <td class="col-1"></td>
            </tr>
        </tfoot>
    </table>
    <div class="w-100">
        {!! $orderList->links() !!}
    </div>
    <div class="text-right m-0">
        <a href="/checkout" class="btn btn-primary"><b><span class="fa fa-arrow-right"></span> Checkout</b></a>
    </div>
    @endif
</div>
@endsection