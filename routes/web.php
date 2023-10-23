<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OfferThemeController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\SystemOptionController;
use App\Http\Controllers\UserController;
use App\Models\OfferSubscription;
use App\Services\SubscriptionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// аутентификация
require __DIR__.'/auth.php';

// главная страница и страница реферальных ссылок
Route::get('/', function () {
    $subscriptions = OfferSubscription::join('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
        ->where('status', '1')->get();

    return view(
        'welcome',
        ['subscriptions' => $subscriptions, 'user' => Auth::user()]
    );
})->middleware(['ref'])->name('main');

// страница пользователя
Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth'])->name('dashboard');
// статистика офферов по переходам и деньгам
Route::get('/offer/statistics', [StatisticController::class, 'index'])
    ->middleware(['auth', 'statistics'])->name('offer.statistics');
// подмена csrf
Route::get('/wrong-uri', fn () => view('wrongcsrf'));
// выключен JS
Route::get('/noscript', fn () => view('noscript'));

// пользователи
Route::resource('/users', UserController::class)
    ->except(['show', 'create', 'edit', 'update'])
    ->middleware(['auth', 'admin']);

// контроллер офферов
Route::post('/offer', [OfferController::class, 'store']);
Route::delete('/offer/{id}', [OfferController::class, 'destroy']);
Route::get('/offer/create', [OfferController::class, 'create'])
    ->middleware(['auth', 'advertiser'])->name('offer.create');

// контроллер тем офферов
Route::resource('/offer-theme', OfferThemeController::class)
    ->except(['show', 'create', 'edit', 'update'])
    ->middleware(['auth', 'admin']);

// установить статус пользователя (активен-неактивен)
Route::post('/users/status', [UserController::class, 'status']);
// установка статуса оффера (активен-неактивен)
Route::post('/offer/status', [OfferController::class, 'status']);
// подписка-отписка вебмастеров на офферы
Route::post('/offer/subscribe', [SubscriptionService::class, 'subscribe']);
Route::post('/offer/unsubscribe', [SubscriptionService::class, 'unsubscribe']);
Route::post('/offer/subscription', [SubscriptionService::class, 'index']);
// установка комиссии
Route::post('/commission', [SystemOptionController::class, 'store']);
