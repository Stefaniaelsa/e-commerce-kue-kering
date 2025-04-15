<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::get('login', [AuthController::class, 'showFormLogin']);
Route::post('login', [AuthController::class, 'auth'])->name('user.auth');
