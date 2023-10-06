<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemOption;

class SystemOptionController extends Controller
{
    public static function commission()
    {
        return SystemOption::where('name', 'commission')->value('value');
    }
}
