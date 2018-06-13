<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class Permissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        if ($permission == 'admin' && Auth::id() > 5) {
            return redirect()->route('home')->with('error', trans('auth.error_no_permissions'));
        }

        return $next($request);
    }
}
