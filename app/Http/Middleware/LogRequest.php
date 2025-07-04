<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $log = '[' . now() . '] ' . $request->method() . ' ' . $request->fullUrl();
        file_put_contents(storage_path('logs/api_activity.log'), $log . PHP_EOL, FILE_APPEND);
        return $next($request);
    }

}
