<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OfferStatistics;

class StatisticController extends Controller
{
    /** страница статистики */
    public function index(Request $request, OfferStatistics $statistics)
    {
        $role = $request->user()->role->name;
        if ($role === 'рекламодатель' || $role === 'веб-мастер') {
            return view('pages/statistics', $statistics->getStatisticsData($request->user()));
        } else {
            return redirect('/dashboard');
        }
    }
}
