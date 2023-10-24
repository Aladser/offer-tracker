<?php

namespace App\Http\Controllers;

use App\Models\SystemOption;
use Illuminate\Http\Request;

class SystemOptionController extends Controller
{
    // установить комиссию
    public function set_commission(Request $request)
    {
        $commission = $request->all()['commission'];
        $isStored = SystemOption::where('name', 'commission')->update(['value' => $commission]);

        return ['result' => $isStored, 'commission' => $commission];
    }

    // получить комиссию
    public static function commission()
    {
        return SystemOption::where('name', 'commission')->value('value');
    }
}
