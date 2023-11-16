<?php

namespace App\Http\Middleware\Roles;

use Illuminate\Http\Request;

/** допускает к странице статистики */
class IsStatisticsPage
{
    public function handle(Request $request, \Closure $next)
    {
        if ($request->user()->role->name !== 'рекламодатель' && $request->user()->role->name !== 'веб-мастер') {
            return redirect(route('dashboard'));
        }

        return $next($request);
    }
}
