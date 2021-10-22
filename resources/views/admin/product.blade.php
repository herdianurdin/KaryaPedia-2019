@extends('layouts.admin')

@section('admin_content')

    @if (($errors->has('name')) || ($errors->has('category')) || ($errors->has('stock')) || ($errors->has('weight')) || ($errors->has('price')) || ($errors->has('image')))
      <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button> 
        Data Tidak Tersimpan, Silakan Cek Kembali Datanya!
    </div>
    @endif
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
    @if (($errors->has('update_name')) || ($errors->has('update_category')) || ($errors->has('update_stock')) || ($errors->has('update_weight')) || ($errors->has('update_price')) || ($errors->has('update_image')))
      <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button> 
        Perubahan Data Tidak Tersimpan, Silakan Cek Kembali Datanya!
    </div>
    @endif
    <a class="btn btn-primary mb-3" data-toggle="collapse" href="#tambah" role="button" aria-expanded="false"><b><span class="fa fa-upload"></span> Tambah Data Produk</b></a>
    <div class="collapse mb-3 @if(($errors->has('name')) || ($errors->has('category')) || ($errors->has('stock')) || ($errors->has('weight')) || ($errors->has('price')) || ($errors->has('image')))show @endif" id="tambah">
        <form action="/admin/produk/tambah" method="POST" enctype="multipart/form-data" class="card card-body border-0 shadow-sm">
        @csrf
            <div class="form-group">
                <label for="name">Nama Produk</label>
                <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name') }}">
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ 'Nama produk wajib diisi!' }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-row">
            <div class="form-group col-6">
                <label for="category">Kategori Produk</label>
                <select class="custom-select @error('category') is-invalid @enderror" id="category" name="category">
                    <option></option>
                    <option {{ (old('category')) == 'Bambu' ? 'selected' : '' }} value="Bambu">Bambu</option>
                    <option {{ (old('category')) == 'Kayu' ? 'selected' : '' }} value="Kayu">Kayu</option>
                    <option {{ (old('category')) == 'Kelapa' ? 'selected' : '' }} value="Kelapa">Kelapa</option>
                    <option {{ (old('category')) == 'Kerang' ? 'selected' : '' }} value="Kerang">Kerang</option>
                    <option {{ (old('category')) == 'Sedotan' ? 'selected' : '' }} value="Sedotan">Sedotan</option>
                </select>
                @error('category')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ 'Kategori produk wajib diisi!' }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group col-6">
                <label for="stock">Stok Produk</label>
                <input class="form-control @error('stock') is-invalid @enderror" type="number" name="stock" id="stock" min="1" value="{{ old('stock') }}">
                @error('stock')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ 'Stok produk wajib diisi!' }}</strong>
                </span>
                @enderror
            </div>
            </div>
            <div class="form-group">
                <label for="weight">Berat</label>
                <input class="form-control @error('weight') is-invalid @enderror" type="number" min="1" name="weight" id="weight" value="{{ old('weight') }}">
                @error('weight')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ 'Berat produk wajib diisi!' }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="price">Harga</label>
                <input class="form-control @error('price') is-invalid @enderror" type="number" min="1" name="price" id="price" value="{{ old('price') }}">
                @error('price')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ 'Harga produk wajib diisi!' }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="image">Gambar Produk</label>
                <input class="form-control-file @error('image') is-invalid @enderror" type="file" name="image" id="image">
                @error('image')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ 'Gambar produk wajib diisi!' }}</strong>
                </span>
                @enderror
            </div>
            <button class="btn btn-success text-white form-control" type="submit"><b>Simpan Data</b></button>
        </form>
        </div>
        <form action="/admin/produk/cari" class="has-search mb-3" method="get">
                <span class="fa fa-search form-control-feedback"></span>
                <input class="form-control border-0 shadow-sm" type="text" name="q" placeholder="Cari Produk..." value="@if(Request::is('admin/produk/cari*')){{ old('q') }}@endif">
        </form>
        @foreach($products as $product)
        <div class="modal fade" id="{{ 'hapus'.$product->id }}" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hapus Data Produk</h5>
                        <button type="button" class="close p-0 m-0" data-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">
                        Anda ingin menghapus data ini?
                    </div>
                    <div class="modal-footer p-2">
                        <a href="#" class="btn btn-secondary" data-dismiss="modal"><b>Tidak</b></a>
                        <a href="/admin/produk/hapus/{{ $product->id }}" class="btn btn-primary"><b>Ya</b></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="{{ 'ubah'.$product->id }}" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header p-3">
                <h5 class="modal-title p-0 m-0">Ubah Data Produk</h5>
                <button type="button" class="close p-0 m-0" data-dismiss="modal" aria-label="Close">&times;
                </button>
            </div>
            <div class="modal-body">
                <form action="/admin/produk/ubah/{{$product->id}}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="form-group">
                        <label for="update-name">Nama Produk</label>
                        <input class="form-control @error('update_name') is-invalid @enderror" type="text" name="update_name" id="update-name" value="{{ $product->name }}">
                        @error('update_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ 'Nama produk wajib diisi!' }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-row">
                    <div class="form-group col-6">
                        <label for="update-category">Kategori</label>
                        <select class="custom-select" id="update-category" name="update_category">
                            <option></option>
                            <option {{ ($product->category) == 'Bambu' ? 'selected' : '' }} value="Bambu">Bambu</option>
                            <option {{ ($product->category) == 'Kayu' ? 'selected' : '' }} value="Kayu">Kayu</option>
                            <option {{ ($product->category) == 'Kelapa' ? 'selected' : '' }} value="Kelapa">Kelapa</option>
                            <option {{ ($product->category) == 'Kerang' ? 'selected' : '' }} value="Kerang">Kerang</option>
                            <option {{ ($product->category) == 'Sedotan' ? 'selected' : '' }} value="Sedotan">Sedotan</option>
                        </select>
                    </div>
                    <div class="form-group col-6">
                        <label for="update-stock">Stok Produk</label>
                        <input class="form-control @error('update_stock') is-invalid @enderror" type="number" name="update_stock" id="stock" min="1" value="{{ $product->stock }}">
                        @error('update_stock')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ 'Stok produk wajib diisi!' }}</strong>
                            </span>
                        @enderror
                    </div>
                    </div>
                    <div class="form-group">
                        <label for="update-weight">Berat</label>
                        <input class="form-control @error('update_weight') is-invalid @enderror" type="number" name="update_weight" min="1" id="weight" value="{{ $product->weight }}">
                        @error('update-weight')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ 'Berat produk wajib diisi!' }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="update-price">Harga</label>
                        <input class="form-control @error('update_price') is-invalid @enderror" type="number" min="1" name="update_price" id="price" value="{{ $product->price }}">
                        @error('update_price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ 'Harga produk wajib diisi!' }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="update-image">Gambar Produk</label>
                        <input class="form-control-file @error('update_image') is-invalid @enderror" type="file" name="update_image" id="image">
                        @error('update_image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ 'Gambar produk wajib diisi!' }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button class="btn btn-success text-white form-control" type="submit"><b>Simpan Perubahan</b></button>
                </form>
            </div>
            </div>
            </div>
        </div>
        <div class="shadow-sm bg-white rounded p-3 d-flex mb-3">
            <div class="w-25">
                <img class="img-fluid rounded" src="{{ asset('img/'.$product->image) }}" alt="{{ $product->name }}">
            </div>
            <div class="w-75 px-4">
                <table class="table">
                    <tbody>
                        <tr class="d-flex">
                            <th class="col-2">Nama Produk</th>
                            <td class="col-1 text-center">:</td>
                            <td class="col-9">{{ $product->name }}</td>
                        </tr>
                        <tr class="d-flex">
                            <th class="col-2">Kategori</th>
                            <td class="col-1 text-center">:</td>
                            <td class="col-9">{{ $product->category }}</td>
                        </tr>
                        <tr class="d-flex">
                            <th class="col-2">Stok Produk</th>
                            <td class="col-1 text-center">:</td>
                            <td class="col-9">{{ $product->stock }} Unit</td>
                        </tr>
                        <tr class="d-flex">
                            <th class="col-2">Berat</th>
                            <td class="col-1 text-center">:</td>
                            <td class="col-9">{{ $product->weight }} gram</td>
                        </tr>
                        <tr class="d-flex">
                            <th class="col-2">Harga</th>
                            <td class="col-1 text-center">:</td>
                            <td class="col-9">Rp. {{ number_format($product->price) }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group form-row mb-0 mt-5 pt-1">
                    <div class="col-6">
                        <a href="#" data-toggle="modal" data-target="{{ '#ubah'.$product->id }}" class="btn btn-primary w-100"><b><span class="fa fa-pencil"></span> Ubah Data Produk</b></a>
                    </div>
                    <div class="col-6">
                        <a href="#" data-toggle="modal" data-target="{{ '#hapus'.$product->id }}" class="btn btn-danger w-100"><b><span class="fa fa-trash"></span> Hapus Data Produk</b></a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        {!! $products->links() !!}
@endsection