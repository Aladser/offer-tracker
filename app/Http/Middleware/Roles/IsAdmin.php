<?php

namespace App\Http\Middleware\Roles;

use Illuminate\Http\Request;

/** пропускает только администраторов */
class IsAdmin
{
    public function handle(Request $request, \Closure $next)
    {
        if ($request->user()->role->name !== 'администратор') {
            return redirect(route('dashboard'));
        }

        return $next($request);
    }
}
