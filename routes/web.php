<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [AppController::class , 'index'])->name('index');
Route::get('/shop', [ShopController::class , 'index'])->name('shop');
Route::get('/product/{slug}', [ShopController::class , 'productDetails'])->name('productDetails');
Route::get('/cart', [CartController::class , 'index'])->name('cart');
Route::post('/cart/store', [CartController::class , 'addToCart'])->name('cart.store');
Route::get('/cart/ds', [CartController::class , 'emptyCart'])->name('cart.ds');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/user',[UserController::class, 'index'])->name('user.index');
});
Route::middleware(['auth','admin'])->group(function () {
    Route::get('/admin',[AdminController::class, 'index'])->name('admin.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';