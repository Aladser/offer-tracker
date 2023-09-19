<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OfferTheme;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $url = null;
        switch ($request->user()->role->name) {
            case 'администратор':
                $url = 'pages/admin';
                break;
            case 'веб-мастер':
                $url = 'pages/webmaster';
                break;
            case 'рекламодатель':
                $url = 'pages/advertiser';
                break;
            default:
                dd('ошибка роли пользователя: ' . $request->user()->role->name);
        }
        
        $themes = [];
        foreach (OfferTheme::all()->toArray() as $theme) {
            $themes[] = $theme['name'];
        }
        return view($url, ['user' => $request->user(), 'themes' => $themes] );
    }
}
