<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // This condition will check if no logged user or authenticated user session try to acces login or register pages
        if(!session()->has('LoggedUser') && ($request->path() !='auth/login' && $request->path() !='auth/register')) {
            return redirect('auth/login')->with('fail', 'You must be logged in');
        }

        // This condition will prevent logged user or authenticated user to acces login or register pages
        if(session()->has('LoggedUser') && ($request->path() == 'auth/login' || $request->path() == 'auth/register')) {
            return back();
        }

        return $next($request)->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
                              ->header('Pragma', 'no-cache')
                              ->header('Expires', 'Sat 01 Jan 1990 00:00:00 GMT');
    }
}
