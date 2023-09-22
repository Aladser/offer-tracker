<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\StatisticController;

Route::get('/', fn() => view('welcome'))->name('main');
// страница пользователя
Route::get('/dashboard', DashboardController::class)->middleware(['auth'])->name('dashboard');
// аутентификация
require __DIR__.'/auth.php';

Route::resource('/offer', OfferController::class)->except(['index', 'show']);
Route::post('/offer/status', [OfferController::class, 'status']);

Route::get('/advertiser/{id}/statistic', StatisticController::class);