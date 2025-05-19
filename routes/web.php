<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RegisterController;


// Halaman login awal (jika langsung ke "/")
Route::get('/', function () {
    return view('login');
});

// Form login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.proses');

// Form register
Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.process');


Route::middleware('auth')->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Halaman beranda umum (bisa diubah sesuai role juga nanti)
    Route::get('/beranda', function () {
        return view('beranda');
    })->name('beranda');

    // Halaman produk umum (untuk user)
    // Route::get('/produk', function () {
    //     return view('produk');
    // });

    Route::get('/produk', [ProductsController::class, 'index'])->name('produk.index');

    // Detail produk (untuk user)
    Route::get('/produk/{id}', [ProductsController::class, 'show'])->name('produk.detail');


    // Detail pesanan (untuk user)
    Route::get('/pesanan/{id}', [OrdersController::class, 'show'])->name('pesanan.show');

    // Menyimpan pesanan (untuk user)
    Route::post('/order/store', [OrdersController::class, 'store'])->name('order.store');

    /*
    |--------------------------------------------------------------------------
    | Routes Admin - Manajemen Produk (Prefix: /admin)
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->group(function () {

        // Menampilkan semua produk (admin)
        Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');

        // Form tambah produk (admin)
        Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');

        // Simpan produk baru (admin)
        Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');

        // Form edit produk (admin)
        Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');

        // Update produk (admin)
        Route::put('/products/{id}', [ProductController::class, 'update'])->name('admin.products.update');

        // Hapus produk (admin)
        Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    });
});


Route::middleware(['auth'])->group(function () {
    // Route untuk menampilkan keranjang
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');

    // Route untuk menambahkan item ke keranjang
    Route::post('/keranjang', [CartController::class, 'store'])->name('cart.store');

    // Route untuk menghapus item dari keranjang
    Route::delete('/keranjang/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::put('/keranjang/{id}', [CartController::class, 'update'])->name('cart.update');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
});
