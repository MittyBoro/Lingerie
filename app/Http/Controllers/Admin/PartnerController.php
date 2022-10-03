<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PartnerRequest;
use Illuminate\Http\Request;

use App\Models\Partner;

use Inertia\Inertia;

class PartnerController extends Controller
{

	public function index(Request $request)
	{
		$partners = Partner::orderByDesc('id')
							->filter($request->all())
							->paginated();

		return Inertia::render('Partners/Index', [
			'list' => $partners,
		]);
	}

	public function create()
	{
		return Inertia::render('Partners/Form', [
			'cities' => Partner::cities(),
			'info_types' => Partner::INFO_TYPES,
		]);
	}

	public function store(PartnerRequest $request)
	{
		$data = $request->validated();
		$data['user_id'] = $request->user()->id;

		$partner = Partner::create($data);

		return redirect(route('admin.partners.edit', $partner->id));
	}

	public function edit(Partner $partner)
	{
		$partner->editing = true;

		// $partner->setAppends(['gallery']);
		// $partner->load(['categories', 'variations']);

		return Inertia::render('Partners/Form', [
			'item' => $partner,

			'cities' => Partner::cities(),
			'info_types' => Partner::INFO_TYPES,
		]);
	}

	public function update(PartnerRequest $request, Partner $partner)
	{
		$data = $request->validated();

		$partner->update($data);

		return back();
	}


	public function destroy(Partner $partner)
	{
		if ( $partner->is_published ) {
			return back()->withErrors(['Запрещено удалять опубликованные элементы']);
		}

		$partner->delete();

		return back();
	}
}
