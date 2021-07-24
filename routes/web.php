<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GroceryController;
use App\Http\Controllers\HomeController;
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
Route::get('/subcategory/{subId}/product/{prodId}', [HomeController::class, 'product_details'])->name('product-details');
Route::post('/product-action/{prodId}', [HomeController::class, 'product_action'])->name('product-action');



Route::prefix('/grocery')->group(function () {
    Route::get('/vendor/{vendor_id}/categories', [GroceryController::class, 'categories'])->name('grocery-categories');
    Route::get('/vendor/{vendor_id}/categories/{cat_id}/products', [GroceryController::class, 'products'])->name('grocery-products');
});

Route::prefix('/pharmacy')->group(function () {
    Route::get('/vendor/{vendor_id}/products', [PharmacyController::class, 'products'])->name('pharmacy-products');
});

Route::prefix('/restaurant')->group(function () {
    Route::get('/vendor/{vendor_id}/products', [RestaurantController::class, 'products'])->name('restaurant-products');
});


Route::middleware('auth')->group(function () {
    Route::get('/checkout', [HomeController::class, 'checkout'])->name('checkout');
    Route::post('/order', [HomeController::class, 'order'])->name('order');
    Route::post('/payment', [HomeController::class, 'payment'])->name('payment');
    Route::get('/my-account', [UserController::class, 'my_account'])->name('my-account');
    Route::post('/add-address', [UserController::class, 'add_address'])->name('add-address');
    Route::get('/delete-address/{id}', [UserController::class, 'delete_address'])->name('delete-address');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::post('/get-area-list', [AjaxController::class, 'get_area_list']);
Route::post('/get-time-slots', [AjaxController::class, 'get_time_slots']);




