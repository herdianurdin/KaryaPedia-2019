@extends('layouts.app')
@section('content')
@if($orders->count() == 0)
<div class="shadow-sm bg-white p-4 mx-5 mb-4">
    <div class="text-center h5 mb-0">Anda Belum Memiliki Transaksi Apapun...</div>
</div>
@else
@foreach($orders as $order)
<div class="shadow-sm bg-white p-4 mx-5 mb-4">
    <div class="card">
        <div class="card-body row">
            <div class="col-8">
                <table class="table mb-0">
                    <tbody>
                        <tr class="d-flex">
                            <th class="col-3">Kode Pesanan</th>
                            <td class="col-1 text-center">:</td>
                            <td class="col-8">{{ $order->order_code }}</td>
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
                                @endif
                                ">{{ $order->status }}</span>
                            </td>
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
                            <th class="col-3">Total Pembayaran</th>
                            <td class="col-1 text-center">:</td>
                            <td class="col-8">Rp. {{ number_format($order->total_price + $order->unique_code + $order->shipping_price) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-4 row">
                <div class="align-self-start col-12">
                @switch($order->status)
                @case('Menunggu Pembayaran')
                    <div class="mb-3">Silakan lakukan pembayaran dengan mentransfer ke rekening berikut :</div>
                    <div class="text-center">
                        <b>Bank BRI SYARIAH</b>
                    </div>
                    <div class="text-center h4 mb-0"><b>123-4567-89</b></div>
                    <div class="text-center text-secondary">Herdi Herdianurdin</div>
                    <div class="text-center mt-3">Lakukan Pembayaran Paling Lambat 1x24 Jam</div>
                    @break
                @case('Diproses')
                Pesanan Anda sedang dalam pengemasan, mohon menunggu untuk informasi selanjutnya...
                    @break
                @case('Dikirim')
                    <div class="mb-3">Pesanan Anda dalam proses pengiriman, silakan cek melalui no resi berikut :</div>
                    <div class="text-center">
                        <b>{{ $order->courier_name }}</b>
                    </div>
                    <div class="text-center h4 mb-0"><b>{{ $order->track_code }}</b></div>
                    @break
                @case('Selesai')
                Proses transaksi telah selesai, terima kasih telah berbelanja di KaryaPedia... 
                    @break
                @case('Dibatalkan')
                Pemesanan Anda dibatalkan, karena melebihi batas waktu pembayaran...
                    @break
                @endswitch
                </div>
                <div class="align-self-end col-12">
                    <a href="/transaksi/detail/{{ $order->order_code }}" class="btn btn-primary w-100"><b>Detail Pemesanan</b></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
<div class="w-100">
    {!! $orders->links() !!}
</div>
@endif
@endsection