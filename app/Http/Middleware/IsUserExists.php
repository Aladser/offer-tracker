<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

/** проверяет существование пользователя  */
class IsUserExists
{
    public function handle(Request $request, \Closure $next)
    {
        if (!$request->user()->exists()) {
            Auth::logout();

            return redirect(route('login'));
        }

        return $next($request);
    }
}
