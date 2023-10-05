<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\UserRole;
use App\Models\User;
use App\Models\Advertiser;
use App\Models\Webmaster;

class RegisteredUserController extends Controller
{
    /** Показать страницу регистраци */
    public function create()
    {
        return view('auth.register', ['roles' => UserRole::orderBy('name', 'desc')->get()->toArray()]);
    }

    /** Создание пользователя */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        // создание пользователя
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role_id = UserRole::find($request->role)->id;
        $user->save();

        // запись в таблицу рекламодателей или вебмастеров
        if ($request->role == 2) {
            Advertiser::create(['user_id' => $user->id]);
        } else if ($request->role == 3){
            Webmaster::create(['user_id' => $user->id]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
