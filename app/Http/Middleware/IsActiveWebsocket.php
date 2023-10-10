<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\ScriptLinuxProcess;

class IsActiveWebsocket
{
    public function handle(Request $request, Closure $next)
    {
        $os = explode(' ', php_uname())[0];
        if ($os !== 'Windows') {
            $websocket = new ScriptLinuxProcess(
                'offer-service',
                dirname(__DIR__, 2) . '/offer-service.php',
                dirname(__DIR__, 3) . '/storage/logs/websocket.log',
                dirname(__DIR__, 3) . '/storage/logs/pids.log'
            );
            if (!$websocket->isActive()) {
                $websocket->run();
            }
        }

        return $next($request);
    }
}