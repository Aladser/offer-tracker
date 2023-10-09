<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemOption;

class SystemOptionController extends Controller
{
    public function store(Request $request)
    {
        $commission = $request->all()['commission'];
        $rslt = SystemOption::where('name', 'commission')->update(['value' => $commission]);
        return ['result' => $rslt];
    }
    
    public static function commission()
    {
        return SystemOption::where('name', 'commission')->value('value');
    }
}
