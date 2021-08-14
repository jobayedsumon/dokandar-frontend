<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GroceryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\RestaurantController;
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

Route::get('/', [HomeController::class, 'homepage'])->name('homepage');
Route::get('/cart', [HomeController::class, 'cart'])->name('cart');
Route::get('/cart/{id}', [HomeController::class, 'remove_cart'])->name('remove-cart');


Route::get('/login', [AuthController::class, 'login_form'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register_form'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/user/{id}/otp-verify', [AuthController::class, 'otp_verify'])->name('otp-verify');


Route::get('/vendor/{vendor_cat_id}/ui-type/{ui_type}/available-store', [HomeController::class, 'available_store'])->name('available-store');
Route::get('/vendor/{vendor_id}/ui-type/{ui_type}/vendor-type', [HomeController::class, 'vendor_type'])->name('vendor-type');
Route::post('/vendor/{vendor_id}/product-action/{prodId}', [HomeController::class, 'product_action'])->name('product-action');



Route::prefix('/grocery')->group(function () {
    Route::get('/vendor/{vendor_id}/categories', [GroceryController::class, 'categories'])->name('grocery-categories');
    Route::get('/vendor/{vendor_id}/categories/{cat_id}/products', [GroceryController::class, 'products'])->name('grocery-products');
    Route::get('/vendor/{vendor_id}/product/{prodId}', [GroceryController::class, 'product_details'])->name('grocery-product-details');
});

Route::prefix('/pharmacy')->group(function () {
    Route::get('/vendor/{vendor_id}/products', [PharmacyController::class, 'products'])->name('pharmacy-products');
    Route::get('/vendor/{vendor_id}/product/{prodId}', [PharmacyController::class, 'product_details'])->name('pharmacy-product-details');
});

Route::prefix('/restaurant')->group(function () {
    Route::get('/vendor/{vendor_id}/products', [RestaurantController::class, 'products'])->name('restaurant-products');
    Route::get('/vendor/{vendor_id}/product/{prodId}', [RestaurantController::class, 'product_details'])->name('restaurant-product-details');
});


Route::middleware('auth')->group(function () {
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/order', [OrderController::class, 'order'])->name('order');
    Route::get('/order/{cart_id}/payment', [OrderController::class, 'payment'])->name('payment');
    Route::post('/order/{cart_id}/payment', [OrderController::class, 'payment_process'])->name('payment');
    Route::post('/order/{cart_id}/apply-coupon', [OrderController::class, 'apply_coupon'])->name('apply-coupon');
    Route::get('/order/{cart_id}/feedback', [OrderController::class, 'order_feedback'])->name('order-feedback');
    Route::get('/my-account', [UserController::class, 'my_account'])->name('my-account');
    Route::get('/order-details/{cart_id}', [UserController::class, 'order_details'])->name('order-details');
    Route::post('/add-address', [UserController::class, 'add_address'])->name('add-address');
    Route::get('/delete-address/{id}', [UserController::class, 'delete_address'])->name('delete-address');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::post('/get-area-list', [AjaxController::class, 'get_area_list'])->name('get-area-list');
Route::post('/get-time-slots', [AjaxController::class, 'get_time_slots'])->name('get-time-slots');
Route::post('/get-nearby-stores', [AjaxController::class, 'get_nearby_stores'])->name('get-nearby-stores');




