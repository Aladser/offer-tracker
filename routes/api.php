<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Здесь вы можете зарегистрировать маршруты API для вашего приложения. Эти
| маршруты загружаются RouteServiceProvider внутри группы, которая
| назначается группа промежуточного программного обеспечения «api». Наслаждайтесь созданием своего API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
