<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OfferStatisctics;

class StatisticController extends Controller
{
    /** страница статистики */
    public function index(Request $request, OfferStatisctics $statisctics)
    {
        $role = $request->user()->role->name;
        if ($role === 'рекламодатель' || $role === 'веб-мастер') {
            return view('pages/statistics', $statisctics->getStatisticsData($request->user()));
        } else {
            return redirect('/dashboard');
        }
    }
}
