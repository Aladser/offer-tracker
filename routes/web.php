<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OfferController;

Route::get('/', function () {return view('welcome');})->name('main');
// страница пользователя
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');
// аутентификация
require __DIR__.'/auth.php';

Route::resource('/offer', OfferController::class)->except(['index']);