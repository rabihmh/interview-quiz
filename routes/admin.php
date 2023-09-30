<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductsController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:admin', 'verified'], 'as' => 'admin.', 'prefix' => 'admin/dashboard'], function () {
    Route::get('/', [DashboardController::class, 'home'])->name('dashboard');
    Route::resource('categories', CategoriesController::class);
    Route::resource('products', ProductsController::class)->except('show');
});
