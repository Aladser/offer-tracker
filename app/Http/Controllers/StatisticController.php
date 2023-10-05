<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OfferService;

class StatisticController extends Controller
{
    /** страница статистики */
    public function index(Request $request, OfferService $offerService)
    {
        $role = $request->user()->role->name;
        if ($role === 'рекламодатель' || $role === 'веб-мастер') {
            return view('pages/statistics', $offerService->getStatisticsData($request->user()));
        } else {
            return redirect('/dashboard');
        }
    }
}
