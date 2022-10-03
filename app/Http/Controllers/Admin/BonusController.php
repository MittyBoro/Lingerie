<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\BonusRequest;
use Illuminate\Http\Request;

use App\Models\Bonus;
use App\Models\User;
use Inertia\Inertia;

class BonusController extends Controller
{

	public function index(Request $request)
	{
		$bonuses = Bonus::with(['user', 'order'])->filter($request->all())->paginated();

		$user = User::find($request->user_id);

		return Inertia::render('Bonuses/Index', [
			'list' => $bonuses,
			'user' => $user,
		]);
	}

	public function create(Request $request)
	{
		$user = User::findOrFail($request->user_id);

		return Inertia::render('Bonuses/Form', [
			'user' => $user,
		]);
	}

	public function store(BonusRequest $request)
	{
		$data = $request->validated();
		$created = Bonus::create($data);

		return redirect(route('admin.bonuses.edit', $created->id));
	}

	public function edit(Bonus $bonus)
	{
		return Inertia::render('Bonuses/Form', [
			'item' => $bonus,
			'user' => $bonus->user,
			'order' => $bonus->order,
		]);
	}

	public function update(BonusRequest $request, Bonus $bonus)
	{
		$data = $request->validated();
		$bonus->update($data);

		return back();
	}

	public function destroy(Bonus $bonus)
	{
		$bonus->delete();

		return back();
	}
}
