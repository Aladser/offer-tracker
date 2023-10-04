<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OfferClick;
use App\Models\SystemOption;

class OfferClickController extends Controller
{
    /** добавить новый переход */
    public static function add($webmasterId, $offerId)
    {
        $click = new OfferClick();
        $click->webmaster_id = $webmasterId;
        $click->offer_id = $offerId;
        $commission = SystemOption::where('name', 'commission')->first()->value;
        $click->income_part = (100 - $commission) / 100;

        return $click->save() ? 1 : 0;
    }
}
