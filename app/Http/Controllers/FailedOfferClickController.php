<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FailedOfferClick;

/** контроллер по отказанным реферальным ссылкам */
class FailedOfferClickController extends Controller
{
    public function add($url)
    {
        return FailedOfferClick::create(['url' => $url]);
    }
}
