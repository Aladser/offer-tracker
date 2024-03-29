<?php

namespace App\Http\Controllers;

use App\Models\OfferClick;

class OfferClickController extends Controller
{
    /** добавить новый переход */
    public static function add($webmasterId, $offerId)
    {
        $click = new OfferClick();
        $click->webmaster_id = $webmasterId;
        $click->offer_id = $offerId;
        $commission = SystemOptionController::commission();
        // часть цены-дохода вебмастера
        $click->income_part = round((100 - $commission) / 100, 2);

        return $click->save() ? 1 : 0;
    }
}
