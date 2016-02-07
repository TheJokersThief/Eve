<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Redirect;
use View;

class StaffMiddleware
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
        if( Auth::check() && Auth::user()->is_staff ){
            return $next($request);
        } else{
            return  response(view('errors.403', ['error' => 'You do not have permission to access this resource.']), 403);
        }
    }
}
