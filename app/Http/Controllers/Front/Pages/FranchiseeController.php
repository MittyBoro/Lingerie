<?php

namespace App\Http\Controllers\Front\Pages;

use Illuminate\Http\Request;
use App\Models\Partner;

class FranchiseeController extends Controller
{
    public function index(Request $request)
    {
        $partners = Partner::franchisee()->get()
            ->each(function($item) {
                $item->information = $item->sorted_information;
            });

        $mapAddresses = Partner::franchiseeAdresses()->toArray();

        return view('pages.franchisee', [
            'page' => $this->page,
            'partners' => $partners,
            'map_addresses' => $mapAddresses,
        ]);
    }

}
