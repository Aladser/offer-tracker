<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Advertiser;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Webmaster;
use App\Providers\RouteServiceProvider;
use App\Services\WebsocketService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /** Показать страницу регистраци */
    public function create()
    {
        $userRoles = UserRole::where('name', '!=', 'администратор')->orderBy('name', 'desc')->get()->toArray();

        return view('auth.register', ['roles' => $userRoles]);
    }

    /** Создание пользователя */
    public function store(Request $request)
    {
        // валидация полей
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        // проверка, если подмена роли. Может быть подмена отправляемых данных на клиенте
        if ($request->role != 'рекламодатель' && $request->role != 'веб-мастер') {
            return redirect('/404');
        }

        // создание пользователя
        $user = new User();
        // имя
        $user->name = $request->name;
        // почта
        $user->email = $request->email;
        // пароль
        $user->password = Hash::make($request->password);
        // роль
        $roleId = UserRole::where('name', $request->role)->first()->id;
        $user->role_id = $roleId;
        // сохранение пользователя
        $user->save();

        // запись в таблицу рекламодателей или вебмастеров
        if ($request->role == 'рекламодатель') {
            Advertiser::create(['user_id' => $user->id]);
        } elseif ($request->role == 'веб-мастер') {
            Webmaster::create(['user_id' => $user->id]);
        }

        // отправка в вебсокет соощения о новом пользователе администратору
        WebsocketService::send(['type' => 'NEW_REGISTRATION', 'id' => $user->id, 'name' => $user->name, 'email' => $user->email, 'role' => $request->role]);
        // событие регистрации пользователя
        event(new Registered($user));
        // автовход пользователя
        Auth::login($user);

        // редирект в dashboard
        return redirect(RouteServiceProvider::HOME);
    }
}
