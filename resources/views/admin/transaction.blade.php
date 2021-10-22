@extends('layouts.admin')

@section('admin_content')
<?php
    $orderPayment = DB::table('orders')->where('status', 'Menunggu Pembayaran')->count();
    $orderProcess = DB::table('orders')->where('status', 'Diproses')->count();
    $orderSend = DB::table('orders')->where('status', 'Dikirim')->count();
    $orderDone = DB::table('orders')->where('status', 'Selesai')->count();
    $orderCancel = DB::table('orders')->where('status', 'Dibatalkan')->count();
    $orderCount = DB::table('orders')->count();
?>
    <div class="shadow-sm bg-white rounded p-3 d-flex flex-wrap mb-3">
        <div class="col-2">
            <a href="/admin/transaksi/menunggu-pembayaran" class="btn border w-100 h-100 @if(Request::is('admin/transaksi/menunggu-pembayaran'))btn-primary active @endif"">
                <h4 class="mb-1"><b>{{ $orderPayment }}</b></h4>
                <h6 class="mb-0">Menunggu Pembayaran</h6>
            </a>
        </div>
        <div class="col-2">
            <a href="/admin/transaksi/diproses" class="btn border w-100 h-100 @if(Request::is('admin/transaksi/diproses'))btn-primary active @endif"">
                <h4 class="mb-1"><b>{{ $orderProcess }}</b></h4>
                <h6 class="mb-0">Pesanan Diproses</h6>
            </a>
        </div>
        <div class="col-2">
            <a href="/admin/transaksi/dikirim" class="btn border w-100 h-100 @if(Request::is('admin/transaksi/dikirim'))btn-primary active @endif"">
                <h4 class="mb-1"><b>{{ $orderSend }}</b></h4>
                <h6 class="mb-0">Pesanan Dikirim</h6>
            </a>
        </div>
        <div class="col-2">
            <a href="/admin/transaksi/selesai" class="btn border w-100 h-100 @if(Request::is('admin/transaksi/selesai'))btn-primary active @endif"">
                <h4 class="mb-1"><b>{{ $orderDone }}</b></h4>
                <h6 class="mb-0">Pesanan Selesai</h6>
            </a>
        </div>
        <div class="col-2">
            <a href="/admin/transaksi/dibatalkan" class="btn border w-100 h-100 @if(Request::is('admin/transaksi/dibatalkan'))btn-primary active @endif">
                <h4 class="mb-1"><b>{{ $orderCancel }}</b></h4>
                <h6 class="mb-0">Pesanan Dibatalkan</h6>
            </a>
        </div>
        <div class="col-2">
            <a href="/admin/transaksi" class="btn border w-100 h-100 @if(Request::is('admin/transaksi'))btn-primary active @endif">
                <h4 class="mb-1"><b>{{ $orderCount }}</b></h4>
                <h6 class="mb-0">Semua Pesanan</h6>
            </a>
        </div>
    </div>
    <form action="/admin/transaksi/cari" class="has-search mb-3" method="get">
                <span class="fa fa-search form-control-feedback"></span>
                <input class="form-control border-0 shadow-sm" type="text" name="q" placeholder="Cari Pesanan..." value="@if(Request::is('admin/transaksi/cari*')){{ old('q') }}@endif">
    </form>
    @if(Session::has('message'))
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">×</button> 
        {{ Session::get('message') }}
    </div>
    @endif
    @if($errors->has(request()->track_code))
      <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button> 
        Status Pesanan Tidak Dapat Diperbarui!
    </div>
    @endif
    @if(Session::has('msgError'))
      <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button> 
        {{ Session::get('msgError') }}
    </div>
    @endif
    @foreach($orders as $order)
    <div class="modal fade" id="{{ 'ubah'.$order->id }}" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header p-3">
        <h5 class="modal-title p-0 m-0">Perbarui Status Pesanan</h5>
        <button type="button" class="close p-0 m-0" data-dismiss="modal" aria-label="Close">&times;
        </button>
    </div>
    <div class="modal-body">
        <form action="/admin/transaksi/ubah/{{$order->id}}" method="POST">
        @csrf
            <div class="form-group">
                <label for="status">Status</label>
                <select class="custom-select" id="status" name="status">
                    <option {{ ($order->status) == 'Menunggu Pembayaran' ? 'selected' : '' }} value="Menunggu Pembayaran">Menunggu Pembayaran</option>
                    <option {{ ($order->status) == 'Diproses' ? 'selected' : '' }} value="Diproses">Diproses</option>
                    <option {{ ($order->status) == 'Dikirim' ? 'selected' : '' }} value="Dikirim">Dikirim</option>
                    <option {{ ($order->status) == 'Selesai' ? 'selected' : '' }} value="Selesai">Selesai</option>
                    <option {{ ($order->status) == 'Dibatalkan' ? 'selected' : '' }} value="Dibatalkan">Dibatalkan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="track-code">Nomor Resi</label>
                <input class="form-control @error('track_code') is-invalid @enderror" type="text" name="track_code" id="track-code" value="{{ $order->track_code }}">
                @error('track_code')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ 'Nomor resi Wajib diisi!' }}</strong>
                    </span>
                @enderror
            </div>
            <button class="btn btn-success text-white form-control" type="submit"><b>Simpan</b></button>
        </form>
    </div>
    </div>
    </div>
</div>
<div class="modal fade" id="{{ 'hapus'.$order->id }}" role="dialog" aria-hidden="true">
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
                <a href="/admin/transaksi/hapus/{{ $order->id }}" class="btn btn-primary"><b>Ya</b></a>
            </div>
        </div>
    </div>
</div>
    <div class="shadow-sm bg-white rounded p-3 d-flex flex-wrap mb-3">
        <div class="col-8">
            <table class="table mb-0">
                <tbody>
                    <tr class="d-flex">
                        <th class="col-3">Kode Pesanan</th>
                        <td class="col-1 text-center">:</td>
                        <td class="col-8">{{ $order->order_code }}</td>
                    </tr>
                    <tr class="d-flex">
                        <th class="col-3">Nama Pembeli</th>
                        <td class="col-1 text-center">:</td>
                        <td class="col-8">{{ $order->recipient_name }}</td>
                    </tr>
                    <tr class="d-flex">
                        <th class="col-3">Alamat Pengiriman</th>
                        <td class="col-1 text-center">:</td>
                        <td class="col-8">{{ $order->shipping_address }}</td>
                    </tr>
                    <tr class="d-flex">
                        <th class="col-3">Kurir Pengiriman</th>
                        <td class="col-1 text-center">:</td>
                        <td class="col-8">{{ $order->courier_name }}</td>
                    </tr>
                    <tr class="d-flex">
                        <th class="col-3">No. Handphone</th>
                        <td class="col-1 text-center">:</td>
                        <td class="col-8">{{ $order->phone_number }}</td>
                    </tr>
                    <tr class="d-flex">
                        <th class="col-3">Status</th>
                        <td class="col-1 text-center">:</td>
                        <td class="col-8">
                            <span class="badge 
                                @if($order->status == 'Selesai')
                                badge-success
                                @elseif($order->status == 'Dibatalkan')
                                badge-danger
                                @else
                                badge-warning
                                @endif">{{ $order->status }}</span>
                        </td>
                    </tr>
                    <tr class="d-flex">
                        <th class="col-3">Total Pembayaran</th>
                        <td class="col-1 text-center">:</td>
                        <td class="col-8">Rp. {{ number_format($order->total_price + $order->unique_code + $order->shipping_price) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-4">
            <a href="/admin/transaksi/detail/{{ strtolower($order->order_code) }}" class="btn btn-primary w-100 mb-3 mt-4" target="_blank"><b>Detail Pesanan</b></a>
            <a href="#" data-toggle="modal" data-target="{{ '#ubah'.$order->id }}" class="btn btn-info w-100 mb-3 text-white"><b>Perbarui Status Pesanan</b></a>
            <a href="#" data-toggle="modal" data-target="{{ '#hapus'.$order->id }}" class="btn btn-danger w-100"><b>Hapus Pesanan</b></a>
        </div>
    </div>
    @endforeach
    <div class="w-100">
    {!! $orders->links() !!}
    </div>
@endsection