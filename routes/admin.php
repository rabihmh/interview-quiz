<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:admin', 'verified'], 'as' => 'admin.', 'prefix' => 'admin/dashboard'], function () {
    Route::get('/', [DashboardController::class, 'home'])->name('dashboard');
});
