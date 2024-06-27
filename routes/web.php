<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [AppController::class , 'index'])->name('index');
Route::get('/shop', [ShopController::class , 'index'])->name('shop');
Route::get('/product/{slug}', [ShopController::class , 'productDetails'])->name('productDetails');

Route::get('/cart', [CartController::class , 'index'])->name('cart');
Route::post('/cart/store', [CartController::class , 'addToCart'])->name('cart.store');
Route::put('/cart/update', [CartController::class , 'updateQuantity'])->name('cart.update');
Route::delete('/cart/remove', [CartController::class , 'removeItem'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class , 'clearCart'])->name('cart.clear');

Route::post('/wishlist/add',[WishlistController::class , 'addProductToWishlist'])->name('wishlist.store');
Route::get('/wishlist',[WishlistController::class , 'index'])->name('wishlist.list');
Route::get('/wishlist/remove/{id}',[WishlistController::class , 'removeItemFromWishlist'])->name('wishlist.remove.item');
Route::delete('/wishlist/clear',[WishlistController::class , 'clearWishlist'])->name('wishlist.clear');
Route::get('/wishlist-count',[WishlistController::class , 'getWishlistCount'])->name('wishlist.count');

Route::resource('order', OrderController::class);
Route::post('order/s', [OrderController::class,'store'])->name('o.store');
Route::get('/checkout',[CheckoutController::class, 'index'])->name('checkout');
Route::resource('/orderItems', OrderItemController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/user',[UserController::class, 'index'])->name('user.dashboard');
    Route::get('/user/edit',[UserController::class, 'show'])->name('user.editPage');
    Route::put('/user/edituser',[UserController::class, 'edit'])->name('user.edit');
    Route::get('/user/remove/{user}',[UserController::class, 'remove'])->name('user.remove');
});
Route::middleware(['auth','adminn'])->group(function () {
    Route::get('/adminn',[AdminController::class, 'index'])->name('adminn.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
