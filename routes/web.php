<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'homepage']);
Route::get('/cart', [HomeController::class, 'cart'])->name('cart');
Route::get('/cart/{id}', [HomeController::class, 'remove_cart'])->name('remove-cart');


Route::get('/login', [AuthController::class, 'login_form'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register_form'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/user/{id}/otp-verify', [AuthController::class, 'otp_verify'])->name('otp-verify');


Route::get('/vendor/{id}/available-store/{ui_type}', [HomeController::class, 'available_store'])->name('available-store');
Route::get('/vendor/{id}/categories', [HomeController::class, 'categories'])->name('categories');
Route::get('/categories/{id}/products', [HomeController::class, 'products'])->name('products');
Route::get('/subcategory/{subId}/product/{prodId}', [HomeController::class, 'product_details'])->name('product-details');
Route::post('/product-action/{id}', [HomeController::class, 'product_action'])->name('product-action');

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [HomeController::class, 'checkout'])->name('checkout');
    Route::post('/order', [HomeController::class, 'order'])->name('order');
    Route::post('/payment', [HomeController::class, 'payment'])->name('payment');
    Route::get('/my-account', [UserController::class, 'my_account'])->name('my-account');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});





