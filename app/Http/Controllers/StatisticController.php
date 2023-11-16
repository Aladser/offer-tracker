<?php

namespace App\Http\Controllers;

use App\Services\OfferStatistics;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    /** страница статистики */
    public function index(Request $request, OfferStatistics $statistics)
    {
        return view('pages/statistics', $statistics->getStatisticsData($request->user()));
    }
}
