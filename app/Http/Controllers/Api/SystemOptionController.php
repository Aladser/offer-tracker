<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SystemOption;

class SystemOptionController extends Controller
{
    public function store(Request $request)
    {
        $commission = $request->all()['commission'];
        $rslt = SystemOption::where('name', 'commission')->update(['value' => $commission]);
        return ['result' => $rslt];
    }
}
