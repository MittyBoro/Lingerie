<?php

namespace App\Http\Middleware\Admin;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle(Request $request, Closure $next, ...$guards)
	{

		// не авторизован
		if ( !Auth::check() ) {
			return redirect()->route('admin.login');
		}

		$rightRole = $guards[0];
		$user = Auth::user();

		// нельзя в админку - выкинуть
		if ( !in_array( $user->role, User::roleTypes() ) ) {
			Auth::logout();
			return redirect()->route('admin.login')->withErrors('У вас нет доступа к панели управления');
		}

		if ( $rightRole == 'editor' && !$user->is_editor ) {
			Auth::logout();
			return redirect()->route('admin.login')->withErrors('Вы не являетесь редактором');
		}

		if ( $rightRole == 'admin' && !$user->is_admin ) {
			Auth::logout();
			return redirect()->route('admin.login')->withErrors('Вы не являетесь администратором');
		}

		return $next($request);

	}
}
