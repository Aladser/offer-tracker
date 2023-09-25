<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
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
                return view($url, ['advertiser' => $request->user()->advertiser, 'userId' => $request->user()->id] );
            default:
                dd('ошибка роли пользователя: ' . $request->user()->role->name);
        }
        
        return view($url, ['user' => $request->user()] );
    }
}
