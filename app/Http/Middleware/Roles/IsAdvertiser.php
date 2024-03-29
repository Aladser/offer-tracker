<?php

namespace App\Http\Middleware\Roles;

use Illuminate\Http\Request;

/** пропускает только рекламодателей */
class IsAdvertiser
{
    public function handle(Request $request, \Closure $next)
    {
        if ($request->user()->role->name !== 'рекламодатель') {
            return redirect(route('dashboard'));
        }

        return $next($request);
    }
}
