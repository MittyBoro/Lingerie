<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;

class GuestOrVerified
{
	public function handle(Request $request, Closure $next, ...$guards)
	{
		if ($request->user()) {
			return app(EnsureEmailIsVerified::class)->handle($request, $next);
		}

		return $next($request);
	}
}
