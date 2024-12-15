<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\employeController;
use App\Http\Controllers\jobController;
use App\Http\Controllers\wilayahController;
use Illuminate\Support\Facades\Route;

Route::get('/', [authController::class, 'login'])->name('login');
Route::post('/login', [authController::class, 'logindb'])->name('logindb');
Route::get('/register', [authController::class, 'register'])->name('register');
Route::post('/register', [authController::class, 'registerdb'])->name('registerdb');

Route::prefix('wilayah')->name('wilayah.')->group(function () {
    Route::get('provinsi', [wilayahController::class, 'provinsi'])->name('provinsi');
    Route::get('kabupaten/{id}', [wilayahController::class, 'kabupaten'])->name('kabupaten');
    Route::get('kecamatan/{id}', [wilayahController::class, 'kecamatan'])->name('kecamatan');
    Route::get('kelurahan/{id}', [wilayahController::class, 'kelurahan'])->name('kelurahan');
});

Route::prefix('job')->name('job.')->group(function () {
    Route::get('/', [jobController::class, 'index'])->name('index');
    Route::get('list', [jobController::class, 'list'])->name('list');
    Route::post('store', [jobController::class, 'store'])->name('store');
    Route::get('detail/{id}', [jobController::class, 'show'])->name('show');
    Route::put('update/{id}', [jobController::class, 'update'])->name('update');
    Route::delete('destory/{id}', [jobController::class, 'destory'])->name('destory');
});

Route::prefix('employe')->name('employe.')->group(function () {
    Route::get('/', [employeController::class, 'index'])->name('index');
    Route::get('list', [employeController::class, 'list'])->name('list');
    Route::post('store', [employeController::class, 'store'])->name('store');
    Route::get('detail/{id}', [employeController::class, 'show'])->name('show');
    Route::put('update/{id}', [employeController::class, 'update'])->name('update');
    Route::delete('destory/{id}', [employeController::class, 'destory'])->name('destory');
});
