<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {return view('welcome');})->name('main');
// страница пользователя
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');
// аутентификация
require __DIR__.'/auth.php';
