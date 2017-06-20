<?php

namespace App\Http\Middleware;

use Closure;
use Facades\App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check() || !UserService::isAdmin(Auth::user())) {
            return redirect()->action('HomeController@index');
        }

        return $next($request);
    }
}
