<?php

namespace App\Http\Middleware\Roles;

use Closure;
use Illuminate\Http\Request;

/** пропускает только администраторов */
class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->role->name !== 'администратор') {
            return redirect('/dashboard');
        }
        return $next($request);
    }
}
