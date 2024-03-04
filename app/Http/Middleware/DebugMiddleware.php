<?php

namespace App\Http\Middleware;

use Closure;
use DebugBar\DebugBar;
use Illuminate\Support\Facades\Config;

class DebugMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /* if (auth()->user() && auth()->user()->hasRole('superadmin')) {
            //config(['app.debug' => true]);
            Config::set('app.debug', true);
        }
        else {
            //config(['app.debug' => false]);
            Config::set('app.debug', false);
        } */

        app('debugbar')->disable();
        if (auth()->check() && auth()->user()->hasRole('superadmin')) {
            app('debugbar')->enable();
        }
        return $next($request);
    }
}
