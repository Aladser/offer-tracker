<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OfferThemeController;
use App\Http\Controllers\StatisticController;
use App\Models\OfferSubscription;
use Illuminate\Support\Facades\Auth;

Route::get('/', function() {
        $subscriptions = OfferSubscription::join('offers','offer_subscriptions.offer_id', '=', 'offers.id')
            ->where('status','1')->get();
        return view(
            'welcome', 
            ['subscriptions' => $subscriptions, 'user' => Auth::user()]
        );
    })
    ->name('main');
    
// страница пользователя
Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth'])
    ->name('dashboard');

// пользователи
Route::resource('/users', UserController::class)
    ->except(['show', 'create', 'edit', 'update'])
    ->middleware(['auth']);
Route::post('/users/status', [UserController::class, 'status']);

// аутентификация
require __DIR__.'/auth.php';

// контроллер офферов
Route::resource('/offer', OfferController::class)
    ->except(['index', 'show', 'edit', 'update'])
    ->middleware(['auth']);
Route::post('/offer/status', [OfferController::class, 'status']);
Route::get('/offer/statistics', [StatisticController::class, 'index'])
    ->middleware(['auth'])
    ->name('offer.statistics');

// подписка-отписка вебмастеров на офферы
Route::post('/offer/subscribe', [OfferController::class, 'subscribe']);
Route::post('/offer/unsubscribe', [OfferController::class, 'unsubscribe']);

// контроллер тем офферов
Route::resource('/offer-theme', OfferThemeController::class)
    ->except(['show', 'create', 'edit', 'update'])
    ->middleware(['auth']);

// подмена csrf
Route::get('/wrong-uri', fn() => view('wrongcsrf'));
// выключен JS
Route::get('/noscript', fn() => view('noscript'));