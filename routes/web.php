<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // Pastikan import facade Auth

// PERBAIKAN KONTROL AKSES HALAMAN UTAMA
Route::get('/', function () {
    // Jika user diam-diam SUDAH login, tendang ke /catalog
    if (Auth::check()) {
        return redirect('/catalog');
    }
    // Jika BELUM login, panggil form login bawaan Breeze
    return app(AuthenticatedSessionController::class)->create();
})->name('home');

// Halaman Katalog Utama setelah login
Route::middleware('auth')->group(function () {
    Route::get('/catalog', [HomeController::class, 'index'])->name('catalog');     
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::patch('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/categories', [ProductCategoryController::class, 'index'])->name('categories.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';