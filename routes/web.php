<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProductsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::group(['middleware' => ['auth:web'], 'as' => 'front.'], function () {
    Route::get('products/search/', [ProductsController::class, 'search'])->name('products.search');
    Route::resource('products', ProductsController::class)->only(['index', 'show']);
    Route::resource('cart', CartController::class);

});

require __DIR__ . '/admin.php';
