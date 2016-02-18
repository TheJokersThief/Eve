<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UnfinishedUser
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param  string|null  $guard
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (Auth::check() && ( Auth::user()->username == Auth::user()->facebook_id )
				          && strpos($request->route()->getName(), 'user') === false) {
			return redirect()->route('user/editSelf')->with('message', 'You must finish editing your account.');
		}

		return $next($request);
	}
}
