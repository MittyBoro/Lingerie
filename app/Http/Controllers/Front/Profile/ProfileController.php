<?php

namespace App\Http\Controllers\Front\Profile;

use App\Http\Controllers\Front\Controller;
use Illuminate\Http\Request;
use Propaganistas\LaravelPhone\PhoneNumber;

class ProfileController extends Controller
{
	public function show(Request $request)
	{
		$user = $request->user();
		$orders = $user->orders;

		return view('profile.show', [
			'orders' => $orders,
			'user' => $user,
		]);
	}

	public function bonuses(Request $request)
	{
		$user = $request->user();

		$bonuses = $user->bonus_list;

		return view('profile.bonuses', [
			'bonuses' => $bonuses,
			'user' => $user,
		]);
	}

	public function edit(Request $request)
	{
		$user = $request->user();
		return view('profile.edit', [
			'user' => $user,
		]);
	}

	public function update(Request $request)
	{
		$user = $request->user();

		if (!$request->password) {

			if ($request->phone)
				$request->merge(['phone' => PhoneNumber::make($request->phone)->formatE164()]);

			$validated = $request->validate([
				'name'  => 'string|max:255',
				'phone' => 'nullable|phone:AUTO|unique:users,phone,'.$request->user()->id,
			]);
		} else {
			$validated = $request->validate([
				'password'  => 'string|confirmed|min:6',
				'current_password' => 'current_password',
			]);
		}

		$user->fill($validated);
		$user->save();

		return back();
	}

}
