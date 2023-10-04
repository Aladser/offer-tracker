<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FailedOfferClick;

/** контроллер по переходам-отказам */
class FailedOfferClickController extends Controller
{
    public static function add($url)
    {
        $click = new FailedOfferClick();
        $click->url = $url;
        return $click->save() ? 1 : 0;
    }
}
