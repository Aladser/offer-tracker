<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\WebsocketService;
use App\Models\UserRole;
use App\Models\User;
use App\Models\Advertiser;
use App\Models\Webmaster;

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
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        // проверка, если подмена роли
        $roleId = UserRole::where('name', $request->role)->first()->id;
        if ($roleId != 2 && $roleId != 3) {
            return redirect('/404');
        }

        // создание пользователя
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role_id = $roleId;
        $user->save();

        // запись в таблицу рекламодателей или вебмастеров. Если отправляется другая цифра - 404
        if ($request->role == 2) {
            Advertiser::create(['user_id' => $user->id]);
        } else if ($request->role == 3){
            Webmaster::create(['user_id' => $user->id]);
        }
        event(new Registered($user));

        Auth::login($user);

        WebsocketService::send(['type'=>'REGISTER', 'id'=>$user->id, 'name'=>$user->name, 'email'=>$user->email, 'role'=>UserRole::find($request->role)->name]);

        return redirect(RouteServiceProvider::HOME);
    }
}
