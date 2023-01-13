<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Log;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        Log::Debug('######################################################################');
        Log::Debug($request);

        if (Auth::guard($guard)->check()) {

            if (auth()->user()->rol == 0) {
              return redirect('alumno\index');
            }elseif (auth()->user()->rol == 1) {
              return redirect('coordinador\index');
            }elseif (auth()->user()->rol == 2) {
              return redirect('administrador\index');
            }elseif (auth()->user()->rol == 3) {
              return redirect('super\index');
            }
        }

        return $next($request);
    }
}
