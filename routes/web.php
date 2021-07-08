<?php

use App\Http\Controllers\HomeController;
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
Route::get('/vendor/{id}/available-store/{ui_type}', [HomeController::class, 'available_store'])->name('available-store');
Route::get('/vendor/{id}/categories', [HomeController::class, 'categories'])->name('categories');
Route::get('/categories/{id}/products', [HomeController::class, 'products'])->name('products');
Route::get('/subcategory/{subId}/product/{prodId}', [HomeController::class, 'product_details'])->name('product-details');
Route::post('/product-action/{id}', [HomeController::class, 'product_action'])->name('product-action');
