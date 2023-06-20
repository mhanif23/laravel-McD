<?php

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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');

        Route::prefix('menu')->group(function(){
            Route::get('/', [App\Http\Controllers\MenuController::class, 'index'])->name('admin.menu');
            Route::get('/ajax', [App\Http\Controllers\MenuController::class, 'ajax'])->name('admin.menu.ajax');
            Route::get('/edit/{id}', [App\Http\Controllers\MenuController::class, 'edit'])->name('admin.menu.edit');
            Route::post('/', [App\Http\Controllers\MenuController::class, 'store'])->name('admin.menu.store');
            Route::patch('/update/{id}', [App\Http\Controllers\MenuController::class, 'update'])->name('admin.menu.update');
            Route::delete('/delete/{id}', [App\Http\Controllers\MenuController::class, 'destroy'])->name('admin.menu.destroy');
        });
    });
});
