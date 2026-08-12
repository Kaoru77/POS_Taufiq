<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
Use App\Http\Controllers\DashboardController;
Use App\Http\Controllers\ItemPenjualanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
Use App\Http\Controllers\UserController;
Use App\Http\Controllers\KategoriController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/auth', [AuthController::class, 'auth'])->name('auth');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/show/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/users/update/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/destroy/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    Route::middleware('role:admin,kasir')->group(function () {
    Route::resource('/produk', ProdukController::class);
    Route::resource('/penjualan', PenjualanController::class);
    Route::resource('/itempenjualan',ItemPenjualanController::class);
    Route::resource('/kategori', KategoriController::class);
});


});
