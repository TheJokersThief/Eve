<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Redirect;
use View;

class TranslationMiddleware
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
        return $next( $request )->withCookie(cookie()->forever('locale', 'fr'));
    }
}
