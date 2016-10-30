<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmin
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
        if (isset($request->user()->is_admin)) {
            if ($request->user()->is_admin) {
                return $next($request);
            }
            return redirect('/');
        }
        return redirect('/login');
    }
}