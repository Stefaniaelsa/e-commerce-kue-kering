<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\adminController;
use App\Http\Controllers\admin\OrdersController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UserController as WebUserController;

/*
|--------------------------------------------------------------------------
| Public Routes (Tanpa Login)
|--------------------------------------------------------------------------
*/

Route::get('/', fn () => view('login'));
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.process');

/*
|--------------------------------------------------------------------------
| Logout (Admin / User)
|--------------------------------------------------------------------------
*/
Route::post('/logout', function () {
    Auth::guard('admin')->check() ? Auth::guard('admin')->logout() : Auth::logout();
    return redirect('/login');
})->name('logout');

/*
|--------------------------------------------------------------------------
| Routes untuk User Biasa (Guard 'web')
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:web'])->group(function () {
    // Beranda
    Route::get('/beranda', function () {
        $produks = \App\Models\Product::with('defaultVariant')->get();
        $bestSellerProduk = \App\Models\Product::where('is_best_seller', true)->get();
        $favoritProduk = \App\Models\Product::where('is_favorit', true)->get();
        $keranjang = \App\Models\Keranjang::where('user_id', auth()->id())->first();
        session(['total_produk' => $keranjang ? $keranjang->total_produk : 0]);

        return view('beranda', compact('produks', 'bestSellerProduk', 'favoritProduk'));
    })->name('beranda');

    // Profil
    Route::get('/profil', [WebUserController::class, 'profil'])->name('profil');

    // Produk
    Route::get('/produk', [ProductsController::class, 'index'])->name('produk.index');
    Route::get('/produk/search', [ProductsController::class, 'search'])->name('produk.search');
    Route::get('/produk/{id}', [ProductsController::class, 'show'])->name('produk.detail');

    // Keranjang
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
    Route::post('/keranjang', [CartController::class, 'store'])->name('cart.store');
    Route::delete('/keranjang/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::put('/keranjang/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Order
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
    // Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');

    // Pesanan
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{id}', [PesananController::class, 'show'])->name('pesanan.show');
    Route::post('/pesanan', [PesananController::class, 'store'])->name('pesanan.store');

    // Proses Pembayaran / Order
    Route::post('/order/process', [OrderController::class, 'store'])->name('order.process');

    // Konfirmasi Pembayaran
    Route::get('/pembayaran', [PembayaranController::class, 'show'])->name('pembayaran');
    Route::post('/konfirmasi', [PembayaranController::class, 'store'])->name('konfirmasi.upload');

    

    // Route::get('/konfirmasi/{id}', [KonfirmasiPembayaranController::class, 'show'])->name('konfirmasi.show');
    // Route::post('/konfirmasi/{id}/update', [KonfirmasiPembayaranController::class, 'updateStatus'])->name('konfirmasi.update');

    Route::get('/konfirmasi-pembayaran', fn () => view('konfirmasi-pembayaran'))->name('konfirmasi.pembayaran');
});

/*
|--------------------------------------------------------------------------
| Routes Khusus Admin (Guard 'admin')
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::get('/dashboard_admin', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Produk, User, Admin, dan Pesanan
    Route::resource('products', ProductController::class);
    Route::resource('users', UserController::class);
    Route::resource('admins', adminController::class);
    Route::resource('orders', OrdersController::class);
    
    Route::resource('pembayarans', App\Http\Controllers\Admin\PembayaranController::class)->only(['index', 'update']);
});

