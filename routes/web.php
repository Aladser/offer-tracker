<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OfferThemeController;
use App\Http\Controllers\StatisticController;
use App\Models\Offer;
use Illuminate\Support\Facades\Auth;

Route::get('/', fn() => view('welcome', ['offers' => Offer::getActiveOffers(), 'auth' => !is_null(Auth::user())]))
    ->name('main');
// страница пользователя
Route::get('/dashboard', DashboardController::class)->middleware(['auth'])
    ->name('dashboard');
// аутентификация
require __DIR__.'/auth.php';

Route::resource('/offer', OfferController::class)->except(['index', 'show'])
    ->middleware(['auth']);
Route::post('/offer/status', [OfferController::class, 'status']);

Route::get('/advertiser/{id}/index', [StatisticController::class, 'index'])
    ->middleware(['auth']);
Route::post('/advertiser/{id}/money', [StatisticController::class, 'money'])
    ->middleware(['auth']);;

Route::resource('/offer-theme', OfferThemeController::class)
    ->except(['index', 'show', 'create', 'edit', 'update'])
    ->middleware(['auth']);