<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OfferService;
use App\Models\OfferSubscription;
use App\Models\User;
use App\Models\SystemOption;

class StatisticController extends Controller
{
    /** страница статистики */
    public function index(Request $request, OfferService $offerService)
    {
        if ($request->user()->role->name === 'рекламодатель') {
            return view('pages/statistics', $offerService->getStatisticsData($request->user()));
        } else if($request->user()->role->name === 'веб-мастер') {
            return view('pages/statistics', ['user' => $request->user(), 'times' => $times] );
        } else {
            return redirect('/dashboard');
        }
    }
}
