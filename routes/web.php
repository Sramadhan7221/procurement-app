<?php

use App\Http\Controllers\DivisionController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'auth'])->name('auth');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/login', [HomeController::class, 'login'])->name('login');
Route::post('/logout', [HomeController::class, 'logout'])->name('logout');

Route::group(['prefix' => 'divisions'], function () {
    Route::get('/', [DivisionController::class, 'index'])->name('division.index');
    Route::post('/datatable', [DivisionController::class, 'datatableAjax'])->name('division.datatable');
    Route::post('/', [DivisionController::class, 'store'])->name('division.store');
    Route::put('/{id}', [DivisionController::class, 'update'])->name('division.update');
    Route::delete('/{id}', [DivisionController::class, 'destroy'])->name('division.destroy');
});
