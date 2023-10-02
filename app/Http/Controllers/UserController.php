<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRole;

class UserController extends Controller
{
    public function index()
    {
        return view('pages/users', ['roles' => UserRole::all()]);
    }
}
