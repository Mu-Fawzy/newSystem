<?php

namespace App\Http\Middleware;

use App\Models\Contract;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureNotEmpty
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
        if (Contract::onlyTrashed()->count() <= 0)
        {
            return redirect()->back();
        }
        return $next($request);
    }
}
