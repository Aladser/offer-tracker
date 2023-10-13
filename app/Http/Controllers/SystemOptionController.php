<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemOption;

class SystemOptionController extends Controller
{
    public function store(Request $request): array
    {
        $commission = $request->all()['commission'];
        $isStored = SystemOption::where('name', 'commission')->update(['value' => $commission]);
        return ['result' => $isStored];
    }

    public static function commission()
    {
        return SystemOption::where('name', 'commission')->value('value');
    }
}
