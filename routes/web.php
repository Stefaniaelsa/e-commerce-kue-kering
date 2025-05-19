<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductsController;

/*
|--------------------------------------------------------------------------
| Public Routes (tanpa login)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');  
Route::post('/login', [AuthController::class, 'login'])->name('login.proses');

Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.process');


/*
|--------------------------------------------------------------------------
| Logout (bisa logout dari user atau admin)
|--------------------------------------------------------------------------
*/
Route::post('/logout', function () {
    if (Auth::guard('admin')->check()) {
        Auth::guard('admin')->logout();
    } else {
        Auth::logout();
    }
    return redirect('/login');
})->name('logout');


/*
|--------------------------------------------------------------------------
| Routes untuk user biasa (guard 'web')
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:web'])->group(function () {
    Route::get('/beranda', function () {
        $produks = \App\Models\Product::with('defaultVariant')->get();
        $bestSellerProduk = \App\Models\Product::where('is_best_seller', true)->get();
        $favoritProduk = \App\Models\Product::where('is_favorit', true)->get();

        return view('beranda', compact('produks', 'bestSellerProduk', 'favoritProduk'));
    })->name('beranda');

    // Produk user
    Route::get('/produk', [ProductsController::class, 'index'])->name('produk.index');
    Route::get('/produk/{id}', [ProductsController::class, 'show'])->name('produk.detail');

    // Keranjang
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
    Route::post('/keranjang', [CartController::class, 'store'])->name('cart.store');
    Route::delete('/keranjang/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::put('/keranjang/{id}', [CartController::class, 'update'])->name('cart.update');

    // Checkout
    Route::post('/checkout', [CheckoutController::class, 'proses'])->name('checkout');

    // Pesanan user
    Route::get('/pesanan/{id}', [OrdersController::class, 'show'])->name('pesanan.show');
    Route::post('/order/store', [OrdersController::class, 'store'])->name('order.store');
});


/*
|--------------------------------------------------------------------------
| Routes khusus admin (guard 'admin')
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::get('/dashboard_admin', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen produk admin
    Route::resource('products', ProductController::class);

    // Manajemen user oleh admin
    Route::resource('users', UserController::class);
});
