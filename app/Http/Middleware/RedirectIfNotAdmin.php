<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
class RedirectIfNotAdmin
{
    
    public function handle($request, Closure $next, $guard="admin")
    {
        if(auth()->guard($guard)->check() && Auth::guard('admin')->user()->role->id == 1) {
            

            return $next($request);
        
        }else{
        	

        	return redirect(route('admin.login'));
        }
        
    }
}