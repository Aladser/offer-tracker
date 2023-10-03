<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\UserRole;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return view(
            'pages/users', 
            ['roles' => UserRole::orderBy('name', 'desc')->get()->toArray(), 'users' => User::all()],
        );
    }

    public function store(Request $request)
    {
        $userData = $request->all();

        // проверка существования почты и имени пользователя
        if (count(User::where('name', $userData['name'])->get()) === 1) {
            return ['result' => 0, 'description' => 'Имя занято'];
        }
        if (count(User::where('email', $userData['email'])->get()) == 1) {
            return ['result' => 0, 'description' => 'Почта занята'];
        }

        $roleId = UserRole::where('name', $userData['role'])->first()['id'];
        $user = new User();
        $user->name = $userData['name'];
        $user->email = $userData['email'];
        $user->password = Hash::make($userData['password1']);
        $user->role_id = $roleId;
        $userSaved = $user->save();

        if ($userSaved) {
            return ['result' => 1, 
                    'row' => ['id'=>$user->id, 'name'=>$user->name, 'email'=>$user->email, 'role'=> $user->role->name]
                ];
        } else {
            return ['result' => 0, 
                    'description' => 'Серверная ошибка сохранения пользователя'
                ];
        }
    }

    public function destroy($id)
    {
        return ['result' => User::find($id)->delete() ? 1 : 0];
    }

    /** установить статус */
    public function status(Request $request)
    {
        $requestData = $request->all();
        $status = $requestData['status']; 
        $id = $requestData['id'];

        $user = User::find($id);
        $user->status = $status === 'true' ? 1 : 0;
        return $user->save();
    }
    
}
