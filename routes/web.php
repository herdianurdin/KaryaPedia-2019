<?php

use Illuminate\Support\Facades\Route;

// Route for Public
Route::get('/', 'HomeController@index');
Route::get('/kategori', 'HomeController@index');
Route::get('/kategori/{category}', 'HomeController@category');
Route::get('/cari', 'HomeController@search');
Route::get('/detail/{permalink}', 'HomeController@detail');

// Auth for route Admin or Member
Auth::routes();

// Route for Admin
Route::get('/admin', 'AdminController@index');
Route::get('/admin/produk', 'AdminController@product');
Route::post('/admin/produk/tambah', 'AdminController@insertProduct');
Route::post('/admin/produk/ubah/{id}', 'AdminController@updateProduct');
Route::get('/admin/produk/hapus/{id}', 'AdminController@deleteProduct');
Route::get('/admin/produk/cari', 'AdminController@search');
Route::get('/admin/transaksi', 'AdminController@transaction');
Route::get('/admin/transaksi/cari', 'AdminController@transactionSearch');
Route::get('/admin/transaksi/{status}', 'AdminController@transactionStatus');
Route::get('/admin/transaksi/detail/{order_code}', 'AdminController@transactionDetail');
Route::post('/admin/transaksi/ubah/{id}', 'AdminController@transactionUpdate');
Route::get('/admin/transaksi/hapus/{id}', 'AdminController@transactionDelete');

// Route for Member
Route::get('/akun', 'MemberController@account');
Route::post('/akun/perbarui', 'MemberController@updateAccount');
Route::get('/keranjang', 'MemberController@cart');
Route::post('/keranjang/tambah/{id}', 'MemberController@addToCart');
Route::get('/keranjang/hapus/{id}', 'MemberController@removeFromCart');
Route::get('/checkout', 'MemberController@checkout');
Route::post('/checkout/lanjut', 'MemberController@continueCheckout');
Route::get('/checkout/konfirmasi', 'MemberController@confirmCheckout');
Route::get('/checkout/pesanan', 'MemberController@orderNow');
Route::get('/transaksi', 'MemberController@transaction');
Route::get('/transaksi/detail/{order_code}', 'MemberController@transactionDetail');