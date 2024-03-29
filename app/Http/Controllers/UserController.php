<?php

namespace App\Http\Controllers;

use App\Models\Advertiser;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Webmaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /** показ страницы пользователей */
    public function index()
    {
        // роли пользователей
        $roles = UserRole::orderBy('name', 'desc')->get()->toArray();
        // пользователи кроме админа
        $users = User::where('name', '!=', 'admin')->get();

        return view('pages/users', ['roles' => $roles, 'users' => $users]);
    }

    /** сохранить нового пользователя */
    public function store(Request $request): array
    {
        $userData = $request->all();

        // проверка существования почты
        if (User::where('name', $userData['name'])->exists()) {
            return ['result' => 0, 'description' => 'Имя занято'];
        }
        // проверка существования имени пользователя
        if (User::where('email', $userData['email'])->exists()) {
            return ['result' => 0, 'description' => 'Почта занята'];
        }

        $user = new User();
        // имя
        $user->name = $userData['name'];
        // почта
        $user->email = $userData['email'];
        // пароль
        $user->password = Hash::make($userData['password1']);
        // роль
        $roleId = UserRole::where('name', $userData['role'])->first()['id'];
        $user->role_id = $roleId;

        $userSaved = $user->save();
        if ($userSaved) {
            // добавляется в соотвествующую таблицу рекламодатель или веб-мастер
            if ($userData['role'] === 'рекламодатель') {
                Advertiser::create(['user_id' => $user->id]);
            } elseif ($userData['role'] === 'веб-мастер') {
                Webmaster::create(['user_id' => $user->id]);
            }

            return ['result' => 1,
                    'row' => ['id' => $user->id, 'name' => $user->name, 'email' => $user->email, 'role' => $user->role->name],
                ];
        } else {
            return ['result' => 0,
                    'description' => 'Серверная ошибка сохранения пользователя',
                ];
        }
    }

    /** удалить пользователя */
    public function destroy($id): array
    {
        return ['result' => User::find($id)->delete() ? 1 : 0];
    }

    /** установить активность учетной записи */
    public function status(Request $request)
    {
        $requestData = $request->all();
        $status = $requestData['status'];
        $id = $requestData['id'];

        $user = User::find($id);
        $user->status = $status === 'true' ? 1 : 0;

        return $user->save();
    }

    // вход в систему
    public function authenticate(Request $request)
    {
        // валидация полей
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // проверка наличия записи в БД
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password'], 'status' => 1])) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        $userData = $request->all();
        // проверка почты
        $user = User::where('email', $userData['email']);
        if (!$user->exists()) {
            return back()->withErrors([
                'email' => 'Учетная запись с указанной почтой не существует',
            ]);
        } else {
            // проверка активности учетной записи
            $isActive = $user->first()->status == 1;
            if (!$isActive) {
                return back()->withErrors([
                    'status' => 'Данная учетная запись выключена администратором',
                ]);
            } else {
                return back()->withErrors(['password' => 'Неверный пароль']);
            }
        }
    }
}
