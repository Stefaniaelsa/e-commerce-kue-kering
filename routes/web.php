<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\Order_DetailsController;


Route::get('/', function () {
    return view('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');  // Form login
Route::post('/login', [AuthController::class, 'login'])->name('login.proses');


Route::get('/beranda', function () {
    return view('beranda');
})->middleware('auth');

Route::get('/produk', function () {
    return view('produk');
})->middleware('auth');


//Route::get('/produk/detail/{id}', function ($id) {
// Contoh: ambil produk berdasarkan ID
//   $produk = App\Models\Products::find($id);
//   return view('produk-detail', compact('produk'));
//})->name('produk.detail');

//Route::get('/produk-detail/{nama}', [ProductsController ::class, 'showByNama']);

//Route::get('/produk/detail/{id}', [ProductsController::class, 'detail'])->name('produk.detail');

// routes/web.php
Route::get('/produk/{id}', [ProductsController::class, 'show'])->name('produk.detail');

// Routes for pesanan (orders)
//Route::get('/pesanan', [OrdersController::class, 'show'])->name('pesanan.detail');


Route::get('/pesanan/{id}', [OrdersController::class, 'show'])->name('pesanan.show');
//Route::get('/pesanan', [OrdersController::class, 'index'])->name('pesanan.index');
//Route::post('/pesanan', [OrdersController::class, 'store'])->name('pesanan.store');

Route::post('/order/store', [OrdersController::class, 'store'])->name('order.store');
//Route::get('/order/confirm/{order}', [OrdersController::class, 'confirm'])->name('order.confirm');
//Route::get('/pesanan/{order}', [OrdersController::class, 'show'])->name('order.details');



Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.process');
