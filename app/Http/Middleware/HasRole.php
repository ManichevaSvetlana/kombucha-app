<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class HasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if($role == 'nova-user' && (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Sales Representative'))) return $next($request);

        if(Auth::check() == false || !Auth::user()->hasRole($role)) {
            return redirect('/');
        }

        return $next($request);
    }
}
