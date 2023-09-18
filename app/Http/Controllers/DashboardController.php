<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $url = null;
        switch ($request->user()->role->name) {
            case 'админ':
                $url = '/pages/admin';
                break;
            case 'веб-мастер':
                $url = '/pages/webmaster';
                break;
            case 'рекламодатель':
                $url = '/pages/advetiser';
                break;
            default:
                dd('ошибка роли пользователя');
        }
        
        return view($url, ['user' => $request->user()] );
    }
}
