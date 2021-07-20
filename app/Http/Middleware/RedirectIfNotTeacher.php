<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotTeacher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard="admin")
    {
        if(auth()->guard($guard)->check() && Auth::guard('admin')->user()->role->id == 4 ) {
            

            return $next($request);
        }else{
            

            return redirect(route('admin.login'));
        }
    }
}
