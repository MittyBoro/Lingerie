<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Product\PromoCode;
use Inertia\Inertia;

class PromoCodeController extends Controller
{

	public function index()
	{
		$codes = PromoCode::get();
		return Inertia::render('PromoCodes/Index', [
			'list' => $codes,
		]);
	}

	public function store()
	{
		$res = PromoCode::createItem();

		if (!$res) {
			return back()->withErrors(['Ошибка добавления промокода']);
		}
		return redirect()->route('admin.promo_codes.index');
	}

	public function update(Request $request, PromoCode $promoCode)
	{
		$validated = $request->validate([
			'code' => 'required|string|unique:promo_codes,code,'.$promoCode->id,
			// 'percent' => 'required|numeric',
			'is_active' => 'boolean',
			'add_bonuses' => 'boolean',
		]);

		$promoCode->update($validated);

		return back();
	}

	public function destroy(PromoCode $promoCode)
	{
		if ( $promoCode->is_active ) {
			return back()->withErrors(['Запрещено удалять активные промокоды']);
		}

		$promoCode->delete();

		return back();
	}
}
