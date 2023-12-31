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
    Route::post('/store-keranjang/{menu_id}', [App\Http\Controllers\HomeController::class, 'storeKeranjang'])->name('store-keranjang');
    Route::post('/simpan-pesanan', [App\Http\Controllers\HomeController::class, 'simpanPesanan'])->name('simpan-pesanan');

    Route::get('/keranjang', [App\Http\Controllers\HomeController::class, 'keranjang'])->name('guest.keranjang');
    Route::delete('/keranjang/delete/{id}', [App\Http\Controllers\HomeController::class, 'hapusKeranjang'])->name('delete-keranjang');

    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');
        Route::get('/dashboard/ajax', [App\Http\Controllers\AdminController::class, 'ajax'])->name('admin.dashboard.ajax');
        
        Route::prefix('menu')->group(function(){
            Route::get('/', [App\Http\Controllers\MenuController::class, 'index'])->name('admin.menu');
            Route::get('/ajax', [App\Http\Controllers\MenuController::class, 'ajax'])->name('admin.menu.ajax');
            Route::get('/edit/{id}', [App\Http\Controllers\MenuController::class, 'edit'])->name('admin.menu.edit');
            Route::post('/', [App\Http\Controllers\MenuController::class, 'store'])->name('admin.menu.store');
            Route::patch('/update/{id}', [App\Http\Controllers\MenuController::class, 'update'])->name('admin.menu.update');
            Route::delete('/delete/{id}', [App\Http\Controllers\MenuController::class, 'destroy'])->name('admin.menu.destroy');
        });

        Route::prefix('meja')->group(function(){
            Route::get('/', [App\Http\Controllers\MejaController::class, 'index'])->name('admin.meja');
            Route::get('/ajax', [App\Http\Controllers\MejaController::class, 'ajax'])->name('admin.meja.ajax');
            Route::get('/edit/{id}', [App\Http\Controllers\MejaController::class, 'edit'])->name('admin.meja.edit');
            Route::post('/', [App\Http\Controllers\MejaController::class, 'store'])->name('admin.meja.store');
            Route::patch('/update/{id}', [App\Http\Controllers\MejaController::class, 'update'])->name('admin.meja.update');
            Route::delete('/delete/{id}', [App\Http\Controllers\MejaController::class, 'destroy'])->name('admin.meja.destroy');
        });
    });
});
