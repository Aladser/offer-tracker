<?php

namespace App\Http\Controllers;

use App\Models\SystemOption;
use Illuminate\Http\Request;

class SystemOptionController extends Controller
{
    public function store(Request $request): array
    {
        $commission = $request->all()['commission'];
        $isStored = SystemOption::where('name', 'commission')->update(['value' => $commission]);

        return ['result' => $isStored, 'commission' => $commission];
    }

    public static function commission()
    {
        return SystemOption::where('name', 'commission')->value('value');
    }
}
