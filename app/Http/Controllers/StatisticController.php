<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OfferSubscription;

class StatisticController extends Controller
{
    public function index(Request $request)
    {
        return view('pages/statistics', ['user' => $request->user()] );
    }

    public function money(Request $request, $id)
    {
        $period = $request->all()['period'];

        return $period . ', ' . json_encode($request->user());
    }

    /** получить текущее время с учетом часового пояса */
    public static function getDate($period = null)
    {
        $date = new \DateTime();
        $date->modify('+' . env('TIMEZONE') . 'hours');
        if (!is_null($period)) {
            $date->modify($period);
        }
        return $date->format('Y-m-d H:i:s');
    }
}
