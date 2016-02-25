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

		if( Auth::check() ){
			// If logged in, take the user's language setting
			$language = Auth::user()->language;
		} else {
			// If not logged in, rely on cookies
			if( $request->hasCookie( 'locale' ) ){
				// If cookie exists, use it
				$language = $request->cookie('locale');
			} else{
				// Otherwise, English is our default language
				$language = 'en';
			}
		}
		return $next( $request )->withCookie(cookie()->forever('locale', $language));
	}
}
