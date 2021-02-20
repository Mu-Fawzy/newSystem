<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutUsers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check())
        {
            if (Auth::User()->status != true)
            {
                Auth::logout();
                return redirect()->to('/')->with('warning', 'Your session has expired because your account is deactivated.');
            }
        }
        return $next($request);
    }
}
